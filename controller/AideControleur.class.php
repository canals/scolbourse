<?php

session_start();

/**
* controller.AideControleur.class.php : classe qui represente le controleur des Aides de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class AideControleur extends AbstractControleur {

	public static $MNU_ID = "mnuAide";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		//$aide = Aide::findById($oid);
		
		// Afficher le result
		$view = new AideView($aide,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
		//$aides = Aide::findAll();
		
		// Afficher le result
		$view = new AideView($aides,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations
			case "creer" : { $this->frmCreerAction() ; break; }						
			case "save"  : { $this->saveProfil() ; break; }						
			
			default         : { $this->mnuAction() ; }
		} 
	}	
	
	public function mnuAction() {
		//$aide = Aide::findById(0);
		
		// Afficher le result
		$view = new AideView($aide,"mnuAction");
		$view->display ();		 
	}	

}

?>