<?php

//session_start();

/**
* controller.AchatControleur.class.php : classe qui represente le controleur des Achats de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class AchatControleur extends AbstractControleur {

	public static $MNU_ID = "mnuAchat";
	
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
		$_SESSION["tabActive"] = "tabAchat";
		
		switch ($this->action) {		
			// Operations			
			case "ajouterExemplaire" :   { $this->ajouterAction() ; break; }
			case "supprimerExemplaire" : { $this->supprimerAction() ; break; }
			
			case "ajouterRegle" :   { $this->ajouterRegleAction() ; break; }
			case "supprimerRegle" : { $this->supprimerRegleAction() ; break; }
											
			default      : { $this->mnuAction() ; }
		} 
	}	
	
	public function mnuAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$achat = Famille::findById($oid);		
		
		$view = new AchatView($achat,"detail");
		$view->display();		 
	}		
	
	
	public function ajouterAction() {				
		if(count($this->valeur)!=2) {
			// Erreur numero de parametres invalid!!!
			$message = "L'exemplaire n'a pas pu &ecirc;tre ajout&eacute;.<br/>Veuillez v&eacute;rifier les informations fournies.";			
		} else {
			// On obtient les parametres
			$params = $this->valeur;
			$numDossierAchat = $params[0]; 
			$codeExemplaire  = $params[1]; 
					  				
			// On verifie que les donn&eacute;es soient valides					
			$famille = Famille::findById($numDossierAchat);		
			$dossier = DossierDAchat::findById($numDossierAchat);	
			$exemplaire = Exemplaire::findById($codeExemplaire);													
			
			// On fait tous les validations
			if($famille==null) 
				$message = "Le numero de dossier de dep&ocirc;t n'est pas valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
			else if($exemplaire==null)
				$message = "L'exemplaire n'existe pas dans la base.<br/>Veuillez v&eacute;rifier les informations fournies."; 	
			else if($exemplaire->getAttr("vendu")!=0)
				$message = "L'exemplaire est d&eacute;j&agrave; vendu.<br/>Veuillez v&eacute;rifier les informations fournies."; 	
			else {
				$manuel = Manuel::findById($exemplaire->getAttr("code_manuel"));			
				$etat = Etat::findById($exemplaire->getAttr("code_etat"));	
				
				if($manuel==null)
					$message = "Le code du manuel n'est pas valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 			
				else if($etat==null)
					$message = "Le code etat n'est pas valide.<br/>Veuillez v&eacute;rifier les informations fournies."; 										
				else {	
					if($dossier==null) {
						// Creer le dossier achat
						$dossier = new DossierDAchat();
						$dossier->setAttr("num_dossier_achat",$numDossierAchat);
						$dossier->setAttr("date_creation_achat",date("Y-m-d"));												
						// etablir les frais � payer
						$taux = Taux::findById(1);
						$montantFrais = ($famille->getAttr("enlevettfrais")=="n")?$taux->getAttr("taux_frais"):0.0;						
						$dossier->setAttr("frais_dossier_achat", $montantFrais);
						$dossier->setAttr("montant_livre_achete",0.0);
						$dossier->setAttr("etat_dossier_achat",1);
						$dossier->setAttr("date_dernier_achat",date("Y-m-d"));
						$r = $dossier->save();						
					} 
					
					try {
						// Si tout va bien, on enregistre l'exemplaire
						$exemplaire->setAttr("num_dossier_achat",$numDossierAchat);					
						$exemplaire->setAttr("vendu", Exemplaire::VENDU);
						$exemplaire->setAttr("date_vente",date("Y-m-d"));														
						$r = $exemplaire->save();						
						
						// Metre � jour le dossier de depot de l'exemplaire
						$dossDepot = DossierDeDepot::findById($exemplaire->getAttr("num_dossier_depot"));
						$dossDepot->calculerMontants();		
						$r = $dossDepot->save();
						
						// Mise � jour du dossier achat
						$dossier->setAttr("date_dernier_achat",date("Y-m-d"));				
						$dossier->calculerMontants();				
						$r = $dossier->save();						
						
						// afficher le resultat
						$message = '{"message": "OK"}'; 			
					} catch(Exception $e) {			
						// Notifier l'erreur
						$message = "L'exemplaire n'a pas pu &ecirc;tre ajout&eacute;.<br/>Veuillez v&eacute;rifier les informations fournies.";
					}				
				}		
			}	
		}
		$view = new AchatView($message,"ajouter");
		$view->display();		 				
	}		
	
	public function supprimerAction() {		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$exemplaire = Exemplaire::findById($oid);	
				
		if($exemplaire->getAttr("vendu")==1) {
			// On verifie que les donn&eacute;es soient valides					
			$dossier = DossierDAchat::findById($exemplaire->getAttr("num_dossier_achat"));	
					
			try {
				// Si tout va bien, on enregistre l'exemplaire
				$exemplaire->setAttr("num_dossier_achat","");					
				$exemplaire->setAttr("vendu",Exemplaire::INVENDU);
				$exemplaire->setAttr("date_vente","0000-00-00");	
				$r = $exemplaire->save();
				// Metre � jour le dossier de depot de l'exemplaire
				$dossDepot = DossierDeDepot::findById($exemplaire->getAttr("num_dossier_depot"));
				$dossDepot->calculerMontants();		
				$r = $dossDepot->save();	
				
				// Mise � jour du dossier achat	
				$dossier->calculerMontants();		
				$r = $dossier->save();	
				
				// afficher le resultat
				$message = "L'exemplaire a &eacute;t&eacute; rendr&eacute;e avec succ&egrave;s..."; 			
			}catch(Exception $e) {			
				// Notifier l'erreur
				$message = "L'exemplaire n'a pas pu &ecirc;tre rendr&eacute;e.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
			}				
		} else {
			// Notifier l'erreur
				$message = "L'exemplaire n'a pas pu &ecirc;tre rendr&eacute;e, car il n'est pas vendu.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
		}		
								
		$view = new AchatView($message,"supprimer");
		$view->display();		 
	}	

	public function ajouterRegleAction() {	
                $message="";
		if(count($this->valeur)<3) {
			// Erreur numero de parametres invalid!!!
			$message = '{"message": "paiment non valide. <br/>"}';			
		} else {
			// On obtient les parametres
			$params = $this->valeur;
			$numDossierAchat = $params[0]; 
			$modePaiment     = $params[1]; 
			$montantPai      = round($params[2],2);
			$cheque          = $params[3];			
					  				
			// On verifie que les donn&eacute;es soient valides					
			$famille = Famille::findById($numDossierAchat);	
				
			$reglement = Reglement::findById($modePaiment);	
                        //echo "famille : $famille  : regle : $reglement<br>";			
			 											
			// On fait tous les validations
			if($famille==null) 
				$message = '{"message": "numero de dossier achat non valide.<br/>"}'; 			
			else if($reglement==null)
				$message = '{"message": "mode de paiement non valide.<br/>" }'; 				
			else {	
				$dossier = $famille->getAttr("dossierDAchat");

				if($dossier==null) {
					$message = '{"message": "pas d\'achats &agrave; payer.<br/>Veuillez v&eacute;rifier les informations fournies."}'; 				
				} else {	
					// Verifier le montant pay�e
					$totalPayee = 0;
					$regles = Regle::findByNumDossierAchat($dossier->getAttr("num_dossier_achat"));
					if($regles!=null) {	
						foreach($regles as $regle) {				
							$reglement = reglement::findById($regle->getAttr("code_reglement"));						
							$totalPayee += round(floatval($regle->getAttr("montant")),2);
						}
					}	
				
					$total_payer = round(floatval($dossier->getAttr("frais_dossier_achat")),2) + round(floatval($dossier->getAttr("montant_livre_achete")),2);
//echo " a payer : $total_payer ". round(floatval($dossier->getAttr("frais_dossier_achat")),2)." ". round(floatval($dossier->getAttr("montant_livre_achete")),2);
//echo "<br> $total_payer : $totalPayee : $montantPai <br>";
					$difference = round( floatval($total_payer) - (floatval($totalPayee)+floatval($montantPai)), 2);
//echo "diff : $difference "  ;
				
					if($difference<0) {
						 $message = '{"message": "Attention,  montant superieur au restant d&ucirc; !<br/>"}'; 				
					} else {	
						try {
							// Si tout va bien, on enregistre le règlement
							$regle = new Regle();						
							$regle->setAttr("num_dossier_achat",$numDossierAchat);					
							$regle->setAttr("code_reglement",$modePaiment);
							$regle->setAttr("montant",$montantPai);					
							$regle->setAttr("numero_cheque",$cheque);
							$regle->setAttr("datereg",date("Y-m-d"));					
											
							$r = $regle->save();						
							
							// Mise � jour du dossier achat						
							$dossier->calculerMontants();				
							$r = $dossier->save();					
							
							// afficher le resultat
							$message = '{ "message": "OK"}'; 			
						} catch(Exception $e) {			
							// Notifier l'erreur
							$message = '{ "message": "sauvegarde du paiement échouée - veuillez recommencer"}';
						}
					}
				}				
			}		
		}			
		$view = new AchatView($message,"ajouterRegle");
		$view->display();		 				
	}		
	
	public function supprimerRegleAction() {		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$regle = Regle::findById($oid);	
				
		// On verifie que les donn&eacute;es soient valides					
		$dossier = DossierDAchat::findById($regle->getAttr("num_dossier_achat"));	
				
		try {
			// Si tout va bien, on enregistre l'exemplaire			
			$r = $regle->delete();
			
			// Mise � jour du dossier achat	
			$dossier->calculerMontants();		
			$r = $dossier->save();	
			
			// afficher le resultat
			$message = '{ "message" : "OK" }'; 			
		}catch(Exception $e) {			
			// Notifier l'erreur
			$message = '{"message": "reglement non supprime"}';
		}				
								
		$view = new AchatView($message,"supprimerRegle");
		$view->display();		 
	}		

}

?>