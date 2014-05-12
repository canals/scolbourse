<?php

	session_start();

/**
 * controller.UtilisateurControleur.class.php : classe qui represente le controlleur des Utilisateurs de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package controller
 */

class UtilisateurControleur extends AbstractControleur {

	public static $MNU_ID = "mnuUtilisateur";
	public static $MNU_ID2 = "mnuBenevole";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$user = Utilisateur::findById($oid);
		$v = new UtilisateurView($user,"detail");
		$v->display ();	
	}
	
	public function listeAction() {	
		// Verifier le niveau d'access
		try {
			$auth = new BourseAuth() ;
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
		} catch(AuthException $a) {
			$mode = "ERREUR"; 
			$titre = "[Acc&egrave;s restreint]"; 
			$retour = "";							
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display (); 
			exit;
		}
		$lo = Utilisateur::findAll();
		$v = new UtilisateurView($lo,"liste");
		$v->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {
			// Consulter
			case "voirProfil"   : { $this->voirProfil() ; break; }
 
 			// Updates
			case "creer"        : { $this->frmCreerAction() ; break; }
			case "changerPassw" : { $this->frmChangerPassw() ; break; }
														
			case "SaveProfil"   : { $this->saveProfil() ; break; }						
							
			default             : { 
				$_SESSION['mnuId'] = self::$MNU_ID2;
				$this->listeAction() ; 
			}
		} 
	}	
	
	public function voirProfil() {			
		$ba = new BourseAuth();
		$userCourant = $ba->getUserProfile();	
		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$user = Utilisateur::findById($oid);
				
		if($userCourant->getAttr("idUtilisateur")==$user->getAttr("idUtilisateur")) 
			 $_SESSION['mnuId'] = self::$MNU_ID;
		else $_SESSION['mnuId'] = self::$MNU_ID2;	
		
		// Donn&eacute;es du formulaire
		$nomformulaire="frmUtilisateur";
		$method="POST";
		$action="#";
		$titre="Donn&eacute;es de l'utilisateur";	
		$enctype="multipart/form-data";
		$button="";	
		$script="";													
		
		// Items du formulaire
		$items[] = new FormItem("Donn&eacute;es du compte","", "titre", "",  false, "", "", "");
		$items[] = new FormItem("Login","login", "text", $user->getAttr("login"),  true, "", "", "");
		$items[] = new FormItem("Password","pwd", "password", $user->getAttr("pwd"),  false, "disabled", "", ""); 
		$items[] = new FormItem("","", "ligne", "",  false, "", "", "");
		
		$items[] = new FormItem("Coordon&eacute;es de l'utilisateur","", "titre", "",  false, "", "", "");
		$items[] = new FormItem("Nom","nom", "text", $user->getAttr("nom"),  true, "", "", "");
		$items[] = new FormItem("Pr&eacute;nom","prenom", "text", $user->getAttr("prenom"),  true, "", "", "");		
		
		/** Type d'utilisateur **/
		// B&eacute;n&eacute;vole
		$vals[] = 1;   $labs[] = "B&eacute;n&eacute;vole";	    
		$sels[] = ($user->getAttr("typeUtilisateur")!=BourseAuth::$ADMIN_LEVEL);
		// Administrateur
		$vals[] = 101; $labs[] = "Administrateur";  
		$sels[] = ($user->getAttr("typeUtilisateur")==BourseAuth::$ADMIN_LEVEL);		
		$arrTypes = Array();
		$arrTypes[]=$vals;   $arrTypes[]=$labs;  $arrTypes[]=$sels;						
		try {
			$auth = new BourseAuth();
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
			// Administrateur								
			$disabled = "";
		} catch(AuthException $a) {	$disabled = "disabled"; }					
		$items[] = new FormItem("Niveau d'acc&egrave;s","typeUtilisateur", "radio", $arrTypes,  true, $disabled, "", "");	
		
		
		// On cr&eacute;e le formulaire
		$frmObjet = new Formulaire($nomformulaire,$method, $action, $titre,  $items, $buttons, $enctype, $script);									
	
		if(!isset($_REQUEST['submit'])) {			
			$v = new UtilisateurView($frmObjet,"profil");
			$v->display ();								
		} else {			
			// On fait la validation du formulaire
			$OK = $frmObjet->validerFormulaire();			
			if($OK) {
				$this->saveProfil();
			} else {
				$v = new UtilisateurView($frmObjet,"profil");
				$v->display ();
			}
		}				
	}
	
	public function frmCreerAction() {			
		// Verifier le niveau d'access
		try {
			$auth = new BourseAuth() ;
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
		} catch(AuthException $a) {
			$mode = "ERREUR"; 
			$titre = "[Acc&egrave;s restreint]"; 
			$retour = "";							
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display (); 
			exit;
		}
		// Verifier le nievau d'access
		try {
			$auth = new BourseAuth() ;			
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 			
		} catch(AuthException $a) {
			$mode = "ERREUR"; $titre = "[Acc&egrave;s restreint]"; $retour = "";							
			$v = new MessageView($titre,$a->getMessage(),$mode, $retour);
			$v->display (); exit;
		}			
	
		// Donn&eacute;es du formulaire
		$nomformulaire="frmUtilisateur";
		$method="POST";
		$action="#";
		$titre="Donn&eacute;es de l'utilisateur";	
		$enctype="multipart/form-data";
		$button="";	
		$script="";													
		
		// Items du formulaire
		$items[] = new FormItem("Donn&eacute;es du compte","", "titre", "",  false, "", "", "");
		$items[] = new FormItem("Login","login", "text", "",  true, "", "", "");
		$items[] = new FormItem("Password","pwd", "password", "",  true, "", "", "");
		$items[] = new FormItem("Conf. password","confPassword", "password", "",  true, "", "", "");
		$items[] = new FormItem("","", "ligne", "",  false, "", "", "");
		
		$items[] = new FormItem("Coordon&eacute;es de l'utilisateur","", "titre", "",  false, "", "", "");
		$items[] = new FormItem("Nom","nom", "text", "",  true, "", "", "");
		$items[] = new FormItem("Prenom","prenom", "text", "",  true, "", "", "");		
		
		/** Type d'utilisateur **/
		// B&eacute;n&eacute;vole
		$vals[] = 1;   $labs[] = "B&eacute;n&eacute;vole";  $sels[] = true;
		// Administrateur
		$vals[] = 101; $labs[] = "Administrateur";  $sels[] = false;		
		$arrTypes = Array();
		$arrTypes[]=$vals;   $arrTypes[]=$labs;  $arrTypes[]=$sels;						
		try {
			$auth = new BourseAuth();
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
			// Administrateur								
			$disabled = "";
		} catch(AuthException $a) {	$disabled = "disabled"; }					
		$items[] = new FormItem("Niveau d'acc&egrave;s","typeUtilisateur", "radio", $arrTypes,  true, $disabled, "", "");	
					 		
		// On cr&eacute;e le formulaire
		$frmObjet = new Formulaire($nomformulaire,$method, $action, $titre,  $items, $buttons, $enctype, $script);									
	
		if(!isset($_REQUEST['submit'])) {			
			$v = new UtilisateurView($frmObjet,"frmCreer");
			$v->display ();								
		} else {			
			// On fait la validation du formulaire
			$OK = $frmObjet->validerFormulaire();			
			if($OK) {
				$this->creerProfil();
			} else {
				$v = new UtilisateurView($frmObjet,"frmCreer");
				$v->display ();
			}
		}			
	}
		
	public function creerProfil() {		
		// Verifier le niveau d'access
		try {
			$auth = new BourseAuth() ;
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
		} catch(AuthException $a) {
			$mode = "ERREUR"; 
			$titre = "[Acc&egrave;s restreint]"; 
			$retour = "";							
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display (); 
			exit;
		}
		$user = new Utilisateur();
	
		// Prendre les valeurs des attributes de l'utilisateur
		$user->setAttr("nom"             , (isset($_REQUEST["nom"]))? $_REQUEST["nom"] : $user->getAttr("nom") );
		$user->setAttr("prenom"          , (isset($_REQUEST["prenom"]))?$_REQUEST["prenom"]:$user->getAttr("prenom"));		
		$user->setAttr("login"           , (isset($_REQUEST["login"]))?$_REQUEST["login"]:$user->getAttr("login"));
		$user->setAttr("pwd"             , (isset($_REQUEST["pwd"]))?$_REQUEST["pwd"]:$user->getAttr("pwd"));									
		$user->setAttr("typeUtilisateur" , (isset($_REQUEST["typeUtilisateur"]))? $_REQUEST["typeUtilisateur"]:$user->getAttr("typeUtilisateur"));										
				
		try {
			$r = $user->save();			
			// afficher le resultat
			$message = "L'utilisateur a &eacute;t&eacute; cr&eacute;e de maniere satisfaisante..."; 
			$mode = "OK";
		}catch(Exception $e) {
			echo $e->getMessage();
			// Notifier l'erreur
			$message = "L'utilisateur n'a pas pu &ecirc;tre enregistr&eacute;.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
			$mode = "ERREUR";
		}		
			
		$titre = "Sauvegarder profil utilisateur";
		$retour = "/Utilisateur";									
		$v = new MessageView($titre,$message,$mode, $retour);
		$v->display ();				
	}
	
	public function saveProfil() {				
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$user = Utilisateur::findById($oid);		
			
		if($user==null)
			$user = new Utilisateur();
	
		// Prendre les valeurs des attributes de l'utilisateur
		$user->setAttr("nom"             , (isset($_REQUEST["nom"]))? $_REQUEST["nom"] : $user->getAttr("nom") );
		$user->setAttr("prenom"          , (isset($_REQUEST["prenom"]))?$_REQUEST["prenom"]:$user->getAttr("prenom"));		
		$user->setAttr("login"           , (isset($_REQUEST["login"]))?$_REQUEST["login"]:$user->getAttr("login"));
		$user->setAttr("pwd"             , (isset($_REQUEST["pwd"]))?$_REQUEST["pwd"]:$user->getAttr("pwd"));									
		$user->setAttr("typeUtilisateur" , (isset($_REQUEST["typeUtilisateur"]))? $_REQUEST["typeUtilisateur"]:$user->getAttr("typeUtilisateur"));										
				
		try {
			$r = $user->save();			
			// afficher le resultat
			$message = "Votre profil a &eacute;t&eacute; sauvergard&eacute; de maniere satisfaisante..."; 
			$mode = "OK";
		}catch(Exception $e) {
			echo $e->getMessage();
			// Notifier l'erreur
			$message = "Votre profil n'a pas pu &ecirc;tre enregistr&eacute;.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
			$mode = "ERREUR";
		}		
			
		$titre = "Sauvegarder profil utilisateur";
		$retour = "/Utilisateur/voirProfil/".$user->getAttr("idUtilisateur");
		$v = new MessageView($titre,$message,$mode, $retour);
		$v->display ();				
	}
	
	public function frmChangerPassw() {				
		// On obtient l'utilisateur courante
		$ba = new BourseAuth();
		$user = $ba->getUserProfile();
		
		// Donn&eacute;es du formulaire
		$nomformulaire="frmUtilisateur";
		$method="POST";
		$action="#";
		$titre="Donn&eacute;es de l'utilisateur";	
		$enctype="multipart/form-data";
		$button="";	
		$script="";													
		
		// Items du formulaire
		$items[] = new FormItem("Donn&eacute;es du compte","", "titre", "",  true, "", "", "");
		$items[] = new FormItem("Login","txtLogin", "text", $user->getAttr("login"),  false, "disabled", "", "");
		$items[] = new FormItem("Password courante","oldPassw", "password", "",  true, "", "", "");
		$items[] = new FormItem("Neuvelle password","newPassw", "password", "",  true, "", "", "");
		$items[] = new FormItem("Conf. password","newPassw2", "password", "",  true, "", "", "");
		
		// On cr&eacute;e le formulaire
		$frmObjet = new Formulaire($nomformulaire,$method, $action, $titre,  $items, $buttons, $enctype, $script);									
	
		if(!isset($_REQUEST['submit'])) {			
			$v = new UtilisateurView($frmObjet,"frmChangerPassw");
			$v->display ();								
		} else {			
			// On fait la validation du formulaire
			$OK = $frmObjet->validerFormulaire();			
			if($OK) {
				$this->changerPassword();
			} else {
				$v = new UtilisateurView($frmObjet,"frmChangerPassw");
				$v->display ();
			}
		}			
	}
	
	public function changerPassword() {				
		$ba = new BourseAuth();
		$user = $ba->getUserProfile();
	
		// Prendre les valeurs des attributes de l'utilisateur		
		$oldPassw = (isset($_REQUEST["oldPassw"]))? md5($_REQUEST["oldPassw"]) : $user->getAttr("pwd");
		$newPassw = (isset($_REQUEST["newPassw"]))? md5($_REQUEST["newPassw"]) : $user->getAttr("pwd");
		$newPassw2 = (isset($_REQUEST["newPassw2"]))? md5($_REQUEST["newPassw2"]) : $user->getAttr("pwd");
		
		if($newPassw==$newPassw2) {		
			try {				
				$r = $user->changePassword($oldPassw, $newPassw);				
				if($r!=false) {					
					$user->setAttr("password"  , $newPassw);
					// afficher le resultat
					$message = "Votre password a &eacute;t&eacute; chang&eacute;e de maniere satisfaisante..."; 
					$mode = "OK";
				} else {
					// Notifier l'erreur
					$message = "Le password courante n'est pas correcte.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
					$mode = "ERREUR";
				}
			}catch(Exception $e) {
				echo $e->getMessage();
				// Notifier l'erreur
				$message = "Votre password n'a pas pu &ecirc;tre chang&eacute;e.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
				$mode = "ERREUR";
			}
		} else {
			// Notifier l'erreur
			$message = "Les deux passwords fournis sont differentes.<br/>S'il vous pla&icirc;t, v&eacute;rifiez les informations fournies.";
			$mode = "ERREUR";
		} 		
		$titre = "Changer le password de l'utilisateur";
		$retour = "";									
		$v = new MessageView($titre,$message,$mode, $retour);
		$v->display ();						
	}
						
}

?>
