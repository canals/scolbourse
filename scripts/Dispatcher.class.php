<?php
/**
 * scripts.Dispatcher.class.php : classe qui represente le point d'entr�e aux controleurs de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package scripts
 */

class Dispatcher {
	// Liste des modules de l'application
	private $listModules = Array('Achat','Aide','Bourse','Depot', 'Exemplaire','Famille','Manuel','Parametrage','Rapport','Utilisateur', 'TDB' );
	
	public function __construct() {
	}
	
	public function dispatch() {		
		// Managing URI parameters
		// Exemple URI: http://Serveur:port/ScolBoursePHP/index.php/Class/ACTION/Params
		$url_array = split('/', $_SERVER['PATH_INFO']);				
		if(in_array($url_array[1],$this->listModules)) {
			$module_name = $url_array[1] . 'Controleur';
			$module = new $module_name();			
			$url_params = array_slice($url_array, 2);
		} else {
			$module = new HomeControleur();	
			$url_params = $url_array;
		}
		$module->callAction($url_params);		
	}
}
?>