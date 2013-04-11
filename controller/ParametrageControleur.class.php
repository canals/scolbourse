<?php

session_start();

/**
* controller.ParametrageControleur.class.php : classe qui represente le controleur des Parametrages de l'application
*
* @author JARNOUX Noémie
* @author COURTOIS Guillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
*/

class ParametrageControleur extends AbstractControleur {

	public static $MNU_ID = "mnuParametrage";
	
	public function __construct(){
		// Pour gérer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			

		$params = $this->valeur;
		
		$option = $params[0];
		$oid = ($params[1] != null) ? $params[1] : 0;
		
		switch($option){
			
			case 'etats':{
				$etats = Etat::findById($oid);
				// Afficher le resultat
				$view = new ParametrageView(null, null, $etats, "detail");
			}break;
			
			case 'reglements':{
				$reglements = Reglement::findById($oid);
				// Afficher le resultat
				$view = new ParametrageView(null, $reglements, null, "detail");
			}break;
		
		}
		$view->display();				
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations
			//
			case "creer" : { $this->frmCreerAction() ; break; }						
			case "modifier" : { $this->modifierTaux(); break;}
			case "modifierReglement" : { $this->frmModifierAction(); break;}
			case "supprimer" : { $this->supprimerAction(); break;}
			
			default         : { $this->mnuAction(); }
		} 
	}	
	
	public function mnuAction() {

		try {
			$auth = new BourseAuth();			
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 			
		} catch(AuthException $a) {
			$mode = "ERREUR"; $titre = "[Accès restreint]"; $retour = "";						
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display(); exit;
		}
		
		$etats = Etat::findAll();
		$reglements = Reglement::findAll();
		$taux = Taux::findAll();
		
		// Afficher le result
		$view = new ParametrageView($taux, $reglements, $etats, "");
		$view->display();		 
	}
	
	public function frmCreerAction() {			
		// Vérifier le niveau d'accès
		try {
			$auth = new BourseAuth();			
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 			
		} catch(AuthException $a) {
			$mode = "ERREUR"; $titre = "[Accès restreint]"; $retour = "";						
			$v = new MessageView($titre,$a->getMessage(),$mode, $retour);
			$v->display(); exit;
		}
		
		switch($this->valeur){
			
			case 'etat':{
				// Données du formulaire
				$nomformulaire="frmEtat";
				$method="POST";
				$action="#";
				$titre="Donn&eacute;es de l'&eacute;tat";	
				$enctype="multipart/form-data";
				$button="";	
				$script="";													
				
				// Items du formulaire
				$items[] = new FormItem("&Eacute;tat", "", "titre", "",  false, "", "", "");
				$items[] = new FormItem("Code &eacute;tat","c", "text", (Base::getLastId('etat', 'code_etat') + 1),  false, "disabled", "", "");
				$items[] = new FormItem("Libell&eacute; &eacute;tat", "libelle_etat", "text", "",  true, "", "", "");
				$items[] = new FormItem("Pourcentage &eacute;tat", "pourcentage_etat", "text", "",  true, "", "", "");
								
				// On crée le formulaire
				$frmObjet = new Formulaire($nomformulaire, $method, $action, $titre, $items, $buttons, $enctype, $script);									
			
				if(!isset($_REQUEST['submit'])) {			
					$v = new ParametrageView($frmObjet, null, null, "frmCreer");
					$v->display();								
				} else {			
					// On fait la validation du formulaire
					$OK = $frmObjet->validerFormulaire();			
					if($OK) {
						$this->creerEtat();
					} else {
						$v = new ParametrageView($frmObjet, null, null, "frmCreer");
						$v->display();
					}
				}
			break;
			}
		
		case 'paiement':{
				// Données du formulaire
				$nomformulaire="frmReglement";
				$method="POST";
				$action="#";
				$titre="Donn&eacute;es du r&egrave;glement";	
				$enctype="multipart/form-data";
				$button="";	
				$script="";													
				
				// Items du formulaire
				$items[] = new FormItem("Reglement", "", "titre", "",  false, "", "", "");
				$items[] = new FormItem("Code reglement","c", "text", (Base::getLastId('reglement', 'code_reglement') + 1),  false, "disabled", "", "");
				$items[] = new FormItem("Mode reglement","mode", "text", "",  true, "", "", "");
				$items[] = new FormItem("","code", "hidden", (Base::getLastId('reglement', 'code_reglement') + 1),  false, "", "", "");
				
				// On crée le formulaire
				$frmObjet = new Formulaire($nomformulaire, $method, $action, $titre, $items, $buttons, $enctype, $script);									
			
				if(!isset($_REQUEST['submit'])) {			
					$v = new ParametrageView($frmObjet, null, null, "frmCreer");
					$v->display();								
				} else {			
					// On fait la validation du formulaire
					$OK = $frmObjet->validerFormulaire();			
					if($OK) {
						$this->creerReglement();
					} else {
						$v = new ParametrageView($frmObjet, null, null, "frmCreer");
						$v->display();
					}
				}			
			break;
			}
	
		}
	}
	
	public function creerEtat() {
		$oid = (isset($_REQUEST["code_etat"])) ? $_REQUEST["code_etat"] :  0;				
		$etat = Etat::findById($oid);		
			
		if($etat == null)
			$etat = new Etat();
	
		// Prendre les valeurs
		$etat->setAttr("code_etat", (isset($_REQUEST["code_etat"]))? $_REQUEST["code_etat"] : null);
		$etat->setAttr("libelle_etat", (isset($_REQUEST["libelle_etat"]))?$_REQUEST["libelle_etat"]:$etat->getAttr("libelle_etat"));	
		$etat->setAttr("pourcentage_etat", (isset($_REQUEST["pourcentage_etat"]))?$_REQUEST["pourcentage_etat"]:$etat->getAttr("pourcentage_etat"));
		
		try {
			$r = $etat->save();			
			// afficher le resultat
			$message = "L'&eacute;tat a &eacute;t&eacute; sauvegard&eacute;..."; 
			$mode = "OK";
		}catch(Exception $e) {
			echo $e->getMessage();
			// Notifier l'erreur
			$message = "L'&eacute;tat n'a pas pu être enregistré.<br/>S'il vous plaît, vérifiez les informations fournies.";
			$mode = "ERREUR";
		}		
			
		$titre = "Sauvergarder &eacute;tat";
		$retour = "/Parametrage";									
		$v = new MessageView($titre, $message, $mode, $retour);
		$v->display();				
	}
	
	public function creerReglement() {
		$oid = (isset($_REQUEST["code"])) ? $_REQUEST["code"] :  0;				
		$reglement = Reglement::findById($oid);		
	
		if($reglement == null)
			$reglement = new Reglement();

		// Prendre les valeurs des attributes de l'utilisateur
		$reglement->setAttr("code_reglement", (isset($_REQUEST["code"])) ? $_REQUEST["code"] : $reglement->getAttr("code_reglement"));
		$reglement->setAttr("mode_reglement", (isset($_REQUEST["mode"])) ? $_REQUEST["mode"] : $reglement->getAttr("mode_reglement"));

		try {

			$r = $reglement->save();

			// afficher le resultat
			$message = "Le r&egrave;glement a &eacute;t&eacute; correctement sauvegard&eacute;..."; 
			$mode = "OK";
		}catch(Exception $e) {
			// Notifier l'erreur
			$message = "Le reglement n'a pas pu &ecirc;tre enregistr&eacute;.<br/>V&eacute;rifiez les informations fournies.";
			$message = "<br/>" . $e->getMessage();
			$mode = "ERREUR";
		}		
			
		$titre = "Sauvegarder r&egrave;glement";
		$retour = "/Parametrage";									
		$v = new MessageView($titre, $message, $mode, $retour);
		$v->display();				
	}

	public function supprimerAction(){
		$params = $this->valeur;
	
		$option = $params[0];
		$oid = ($params[1] != null) ? $params[1] : 0;
		
		switch($option){
			case 'etat':{
				$etat = Etat::findById($oid);		
					
				if($etat == null){
					$message = "Aucun &eacute;tat à supprimer..."; 
					$mode = "OK";
				}else{
					try {
						$r = $etat->delete();
						
						// afficher le resultat
						$message = "L'&eacute;tat a &eacute;t&eacute; supprim&eacute;..."; 
						$mode = "OK";
					}catch(Exception $e) {
						// Notifier l'erreur
						$message = "L'&eacute;tat n'a pas pu être supprim&eacute;.<br/>S'il vous plaît, 
							v&eacute;rifiez les informations fournies.";
						$message .= "<br/>" . $e->getMessage();
						$mode = "ERREUR";
					}
				}
				break;
			}
			
			case 'paiement':{
				$reglement = Reglement::findById($oid);		
					
				if($reglement == null){
					$message = "Aucun r&egrave;glement &agrave; supprimer..."; 
					$mode = "OK";
				}else{
					try {
						$r = $reglement->delete();			
						// afficher le resultat
						$message = "Le reglement a &eacute;t&eacute; supprim&eacute;..."; 
						$mode = "OK";
					}catch(Exception $e) {
						// Notifier l'erreur
						$message = "Le reglement n'a pas pu &ecirc;tre supprim&eacute;.<br/>V&eacute;rifiez les informations fournies.";
						$message .= "<br/>" . $e->getMessage();
						$mode = "ERREUR";
					}
				}
				break;
			}
		}
			
		$titre = "Supprimer parametrage";
		$retour = "/Parametrage";									
		$v = new MessageView($titre, $message, $mode, $retour);
		$v->display();				

	}
	
	public function modifierTaux() {				
		$taux = Taux::findById(1);
	
		$params = $this->valeur;

		if($taux != null){

		   $taux_frais = ($params[0] != null) ? $params[0] : $taux->getAttr("taux_frais");
		   $montant_frais_envoi = ($params[1] != null) ? $params[1] : $taux->getAttr("montant_frais_envoi") ;
		   // Prendre les valeurs des attributes de l'utilisateur

		   $taux->setAttr("taux_frais", $taux_frais);
		   $taux->setAttr("montant_frais_envoi", $montant_frais_envoi);
		
		   try {
			$r = $taux->save();
			// afficher le resultat
			$message = "Les taux ont &eacute;t&eacute; correctement sauvegard&eacute;s.."; 
			$mode = "OK";
		   }catch(Exception $e) {
			echo $e->getMessage();
			// Notifier l'erreur
			$message = "Le reglement n'a pas pu &ecirc;tre enregistr&eacute;.<br/>V&eacute;rifiez les informations fournies.";
			$message .= "<br/>" . $e->getMessage();
			$mode = "ERREUR";
		   }
		}else{
		   $taux_frais = ($params[0] != null) ? $params[0] : null;
		   $montant_frais_envoi = ($params[1] != null) ? $params[1] : null;
		   // Prendre les valeurs des attributes de l'utilisateur
		   
		   $taux = new Taux();

		   $taux->setAttr("taux_frais", $taux_frais);
		   $taux->setAttr("montant_frais_envoi", $montant_frais_envoi);
		
		   try {
			$r = $taux->save();
			// afficher le resultat
			$message = "Les taux ont &eacute;t&eacute; correctement sauvegard&eacute;s.."; 
			$mode = "OK";
		   }catch(Exception $e) {
			// Notifier l'erreur
			$message = "Le reglement n'a pas pu &ecirc;tre enregistr&eacute;.<br/>V&eacute;rifiez les informations fournies.";
			$message .= "<br/>" . $e->getMessage();
			$mode = "ERREUR";
		   }

		}		
			
		$titre = "Sauvergarder profil utilisateur";
		$retour = "";									
		$v = new MessageView($titre, $message, $mode, $retour);
		echo $v->detailMessage();				
	}
	
	public function frmModifierAction(){
		// Verifier le nievau d'access
		try {
			$auth = new BourseAuth();			
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 			
		} catch(AuthException $a) {
			$mode = "ERREUR"; $titre = "[Accès restreint]"; $retour = "";						
			$v = new MessageView($titre,$a->getMessage(),$mode, $retour);
			$v->display(); exit;
		}
		
		$params = $this->valeur;
		
		$option = $params[0];
		$oid = ($params[1] != null) ? $params[1] : 0;
		
		
		
		switch($option){
			
			case 'etat':{
				$etat = Etat::findById($oid);
				
				// Données du formulaire
				$nomformulaire="frmEtat";
				$method="POST";
				$action="#";
				$titre="Donn&eacute;es de l'&eacute;tat";	
				$enctype="multipart/form-data";
				$button="";	
				$script="";													
				
				// Items du formulaire
				//__construct($label,$nom, $type, $valeur, $oblig, $disabled, $events, $erreur)
				$items[] = new FormItem("&Eacute;tat", "", "titre", "",  false, "", "", "");
				$items[] = new FormItem("Code &eacute;tat","c", "text", $etat->getAttr("code_etat"),  false, "disabled", "", "");
				$items[] = new FormItem("Libell&eacute; &eacute;tat","libelle_etat", "text", $etat->getAttr("libelle_etat"),  true, "", "", "");
				$items[] = new FormItem("Pourcentage &eacute;tat","pourcentage_etat", "text", $etat->getAttr("pourcentage_etat"),  true, "", "", "");
				$items[] = new FormItem("","code_etat", "hidden", $etat->getAttr("code_etat"), false, "", "", "");
				
				// On crée le formulaire
				$frmObjet = new Formulaire($nomformulaire, $method, $action, $titre, $items, $buttons, $enctype, $script);									
			
				if(!isset($_REQUEST['submit'])) {			
					$v = new ParametrageView($frmObjet, null, null, "frmCreer");
					$v->display();								
				} else {			
					// On fait la validation du formulaire
					$OK = $frmObjet->validerFormulaire();			
					if($OK) {
						$this->creerEtat();
					} else {
						$v = new ParametrageView($frmObjet, null, null, "frmCreer");
						$v->display();
					}
				}
			break;
			}
		
			case 'paiement':{
			
				$reglement = Reglement::findById($oid);
				
				// Données du formulaire
				$nomformulaire="frmReglement";
				$method="POST";
				$action="#";
				$titre="Donn&eacute;es du reglement";	
				$enctype="multipart/form-data";
				$button="";	
				$script="";													
				
				// Items du formulaire
				//__construct($label,$nom, $type, $valeur, $oblig, $disabled, $events, $erreur)
				$items[] = new FormItem("Reglement", "", "titre", "",  false, "", "", "");
				$items[] = new FormItem("Code reglement","c", "text", $reglement->getAttr("code_reglement"),  false, "disabled", "", "");
				$items[] = new FormItem("Mode reglement","mode", "text", $reglement->getAttr("mode_reglement"),  true, "", "", "");
				$items[] = new FormItem("","code", "hidden", $reglement->getAttr("code_reglement"),  false, "", "", "");
				
				// On crée le formulaire
				$frmObjet = new Formulaire($nomformulaire, $method, $action, $titre, $items, $buttons, $enctype, $script);									
			
				if(!isset($_REQUEST['submit'])) {			
					$v = new ParametrageView($frmObjet, null, null, "frmCreer");
					$v->display();								
				} else {			
					// On fait la validation du formulaire
					$OK = $frmObjet->validerFormulaire();			
					if($OK) {
						$this->creerReglement();
					} else {
						$v = new ParametrageView($frmObjet, null, null, "frmCreer");
						$v->display();
					}
				}			
				break;
			}
	
		}
	}
} // Fin de la classe ParametrageControleur
?>
