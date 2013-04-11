<?php

	//session_start();
/**
 * controller.AbstractControleur.class.php : classe qui represente le super classe abstract 
 *                                           par toutes les controleurs de l'application
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package controller
 */

abstract class AbstractControleur {

	public $action;
	public $valeur;

		
	public function callAction($url_params) {	
		$this->setParams($url_params);							
		switch ($this->action) {
			case "detail" : { $this->detailAction() ; break; }
			case "liste"  : { $this->listeAction() ; break; }				
			default       : { $this->defaultAction() ; }
		} 
	}		
	
	private function setParams($url_params) {
		if(isset($url_params)) {
			$this->action = $url_params[0];										
			if(count($url_params)==2)
				$this->valeur = $url_params[1];					
			else if(count($url_params)>2)
				$this->valeur = array_slice($url_params, 1);	
			else
				$this->valeur = null;							
		} else {
			$this->action = "default";
			$this->valeur = null;
		}
	}
}

?>