<?php

session_start();

/**
* controller.TDBControleur.class.php : classe qui represente le controleur de tableau de bord de la bourse
*
* @author Gérôme Canals
*
* @package controller
**/

class TDBControleur extends AbstractControleur {

	public static $MNU_ID = "mnuTDB";
	
	public function __construct(){
		// Pour gérer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {
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
		
		//$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$view = new TDBView();
		$view->display ();				
	}
	

	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations
			case "ouvrir" : { $this->ouvrirBourse() ; break; }
			case "fermer" : { $this->fermerAction() ; break; }		
			case "structure" : { $this->structureAction() ; break; }		
			case "donneesSauvegarde" : { $this->donneesSauvegardeAction() ; break; }
			case "donnees" : { $this->donneesAction() ; break; }			
			case "exportDonnees" : { $this->exportDonneesAction() ; break; }		
			case "save"  : { $this->saveProfil() ; break; }						
			default         : { $this->detailAction() ; }
		} 
	}	
	
	public function mnuAction() {
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
		
		// Afficher le result
		$view = new MessageView("Tableau de bord","detail", "OK", "/ScolBoursPHP/index.php/TDB");
		$view->display ();		 
	}	
	

}

?>
