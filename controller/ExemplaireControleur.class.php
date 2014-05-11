<?php

session_start();

/**
* controller.ExemplaireControleur.class.php : classe qui represente le controleur des Exemplaires de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class ExemplaireControleur extends AbstractControleur {

	public static $MNU_ID = "mnuExemplaire";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$exemplaire = Exemplaire::findById($oid);
		
		// Afficher le result
		$view = new ExemplaireView($exemplaire,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
		$exemplaires = Exemplaire::findAll();
		
		// Afficher le result
		$view = new ExemplaireView($exemplaires,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations			
			case "voirDetail" : { $this->voirDetailAction() ; break; }						
			
			default         : { $this->mnuAction() ; }
		} 
	}	
	
	public function mnuAction() {		
		// Afficher le result
		$view = new ExemplaireView($exemplaire,"mnuAction");
		$view->display ();		 
	}	
	
	public function voirDetailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$exemplaire = Exemplaire::findById($oid);
		
		// Afficher le result
		$view = new ExemplaireView($exemplaire,"voirDetail");
		$view->display ();				
	}

}

?>