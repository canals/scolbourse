<?php

session_start();

/**
* controller.DepotControleur.class.php : classe qui represente le controleur des Depots de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class DepotControleur extends AbstractControleur {

	public static $MNU_ID = "mnuDepot";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$this->defaultAction();			
	}
	
	public function listeAction() {	
		$this->defaultAction();
	}
	
	public function defaultAction() {
		// Etablir que l'onglet active
		$_SESSION["tabActive"] = "tabDepot";
		
		switch ($this->action) {		
			// Operations			

			case "ajouterExemplaire" :   { $this->ajouterAction() ; break; }
			case "supprimerExemplaire" : { $this->supprimerAction() ; break; }				
			
			case "fraisEnvoi" : { $this->fraisEnvoiAction() ; break; }	
			
			case "retourInvendus" : { $this->retourInvendusAction() ; break; }	
			case "rendreExemplaire" : { $this->rendreExemplaireAction() ; break; }	
											
			default      : { $this->mnuAction() ; }
		} 
	}	
	
	public function mnuAction() {
		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$depot = Famille::findById($oid);		
		
		$view = new DepotView($depot,"detail");
		$view->display();		 
	}		
	
	
	public function ajouterAction() {				
		if(count($this->valeur)!=4) {
			// Erreur numero de parametres invalid!!!
			$message = "Echec de l'ajout de l'exemplaire <br/>Veuillez v&eacute;rifier les informations fournies.";			
		} else {
			// On obtient les parametres
			$params = $this->valeur;
			$numDossierDepot = $params[0]; 
			$codeExemplaire  = $params[1]; 
			$codeManuel      = $params[2]; 
			$codeEtat        = $params[3]; 
 				
			// On verifie que les donn&eacute;es soient valides					
			$famille = Famille::findById($numDossierDepot);			
			$dossier = DossierDeDepot::findById($numDossierDepot);	
			$manuel = Manuel::findById($codeManuel);			
			$etat = Etat::findById($codeEtat);		
			$exemplaire = Exemplaire::findById($codeExemplaire);			
			
			// On fait tous les validations
			if($famille==null) 
				$message = "Num&eacute;ro de dossier dep&ocirc;t non valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
			else if($manuel==null)
				$message = "Code  manuel non valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
			else if($etat==null)
				$message = "Code etat non valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
			else if($exemplaire!=null)
				$message = "L'exemplaire existe d&eacute;j&agrave; dans la base.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
			else {	
				if($dossier==null) {
					// Creer le dossier depot
					$dossier = new DossierDeDepot();
					$dossier->setAttr("num_dossier_depot",$numDossierDepot);
					$dossier->setAttr("date_creation_depot",date("Y-m-d"));						
					// etablir les frais à payer
					$taux = Taux::findById(1);
					$montatFrais = ($famille->getAttr("enlevettfrais")=="n")?$taux->getAttr("taux_frais"):0.0;
					$dossier->setAttr("frais_dossier_depot", $montatFrais);
					$dossier->setAttr("frais_envoi_depot",$taux->getAttr("montant_frais_envoi"));					
					$dossier->setAttr("montant_livre_depose_vendu",0.0);
					$dossier->setAttr("enlevefraisenv_depot","n");
					$dossier->setAttr("etat_dossier_depot",1);
					$r = $dossier->save();
					$r = $dossier->save();
				}
				
				try {
					// Si tout va bien, on enregistre l'exemplaire
					$exemplaire = new Exemplaire();					
					$exemplaire->setAttr("code_exemplaire",$codeExemplaire);
					$exemplaire->setAttr("num_dossier_depot",$numDossierDepot);
					$exemplaire->setAttr("num_dossier_achat","");
					$exemplaire->setAttr("code_etat",$codeEtat);
					$exemplaire->setAttr("code_manuel",$codeManuel);
					$exemplaire->setAttr("vendu",0);
					$exemplaire->setAttr("date_vente","0000-00-00");
					$exemplaire->setAttr("date_rendu","0000-00-00");
									
					$r = $exemplaire->save();						
					
					// Mise à jour du dossier depot
					$dossier->setAttr("date_dernier_depot",date("Y-m-d"));				
					$dossier->calculerMontants();				
					$r = $dossier->save();					
					
					// afficher le resultat
					$message = "OK"; 			
				}catch(Exception $e) {			
					// Notifier l'erreur
					$message = "Echec de l'ajout de l'exemplaire <br/>Veuillez v&eacute;rifier les informations fournies.";
				}				
			}		
		}			
		$view = new DepotView($message,"ajouter");
		$view->display();		 				
	}		
	
	public function supprimerAction() {		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$exemplaire = Exemplaire::findById($oid);	
		
		if($exemplaire->getAttr("vendu")==0) {
			// On verifie que les donn&eacute;es soient valides					
			$dossier = DossierDeDepot::findById($exemplaire->getAttr("num_dossier_depot"));	
					
			try {
				$r = $exemplaire->delete();	
				
				// Mise à jour du dossier depot	
				$dossier->calculerMontants();
				$r = $dossier->save();	
				
				// afficher le resultat
				$message = "OK"; 			
			}catch(Exception $e) {			
				// Notifier l'erreur
				$message = "Echec de la suppression.<br/>V&eacute;rifiez les informations fournies.";
			}				
		} else {
			// Notifier l'erreur
				$message = "Exemplaire  d&eacute;j&agrave; vendu : suppression impossible !";
		}		
								
		$view = new DepotView($message,"supprimer");
		$view->display();		 
	}	

	public function fraisEnvoiAction() {						
		// On obtient les parametres
		$params = $this->valeur;
		$numDossierDepot   = $params[0]; 
		$enleverFraisEnvoi = $params[1]; 			
			
		// On verifie que les donn&eacute;es soient valides				
		$dossier = DossierDeDepot::findById($numDossierDepot);			
		try {			
			// Mise à jour du dossier depot
			$dossier->setAttr("enlevefraisenv_depot",$enleverFraisEnvoi);
			$dossier->calculerMontants();
			$r = $dossier->save();					
			
			// afficher le resultat
			$message = "OK"; 			
		}catch(Exception $e) {			
			// Notifier l'erreur
			$message = "Le dossier n'a pas pu &ecirc;tre mis &agrave; jour.<br/>Veuillez v&eacute;rifier les informations fournies.";
		}				
							
		$view = new DepotView($message,"maj");
		$view->display();			
	}	
		
	private function retourInvendusAction(){
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;		
		$famille = Famille::findById($oid);	
					
		$view = new DepotView($famille,"retourInvendus");
		$view->display();				
	}
	
	private function rendreExemplaireAction(){
		if(count($this->valeur)!=2) {
			// Erreur numero de parametres invalid!!!
			$message = "L'exemplaire n'a pas pu &ecirc;tre rendu.";			
		} else {
			// On obtient les parametres
			$params = $this->valeur;
			$numDossierDepot = $params[0]; 
			$codeExemplaire  = $params[1]; 						
			
			// On verifie que les donn&eacute;es soient valides					
			$famille = Famille::findById($numDossierDepot);			
			$dossier = DossierDeDepot::findById($numDossierDepot);					
			$exemplaire = Exemplaire::findById($codeExemplaire);	
			
			
			 			
			// On fait tous les validations
			if($famille==null) 
				$message = "Num&eacute;ro de dossier invalide."; 						
			else if($exemplaire==null)
				$message = "Exemplaire inconnu."; 			
			else {	
								
				try {
					// Si tout va bien, on rendre l'exemplaire					
					$exemplaire->setAttr("vendu",Exemplaire::RENDRE);
					$exemplaire->setAttr("date_vente","0000-00-00");
					$exemplaire->setAttr("date_rendu",date("Y-m-d"));									
					$r = $exemplaire->save();						
					
					// Mise à jour du dossier depot					
					$dossier->calculerMontants();				
					$r = $dossier->save();					
					
					// afficher le resultat
					$message = "OK"; 			
				}catch(Exception $e) {			
					// Notifier l'erreur
					$message = "Echec du rendu exemplaire !";
				}				
			}		
		}			
		$view = new DepotView($message,"rendre");
		$view->display();					
	}

	

}

?>