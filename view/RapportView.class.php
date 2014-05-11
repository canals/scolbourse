<?php

session_start();


/**
 * view.RapportView.class.php : classe qui permet faire les views des Rapports de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class RapportView {

	private $rapport;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->rapport = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un rapport.
	*   Reçoit en param&egrave;tre le nom de l'attribut acc&egrave;de
	*   et retourne sa valeur.
	*  
	*   @param String $attr_name attribute name 
	*   @return mixed
	**/	
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	*   Setter g&eacute;n&eacute;rique
	*
	*   fonction de modification des attributs d'un rapport.
	*   Reçoit en param&egrave;tre le nom de l'attribut modifi&eacute; et la nouvelle valeur
	*  
	*   @param String $attr_name attribute name 
	*   @param mixed $attr_val attribute value
	*   @return mixed new attribute value
	*/
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name=$attr_val;
		return $attr_val;
	}
	
	public function display() {			
		$titre= "";
		$content = "";			
		switch($this->mode) {			
			case "detail": {
				$titre = "Detail rapport"; 
				$content = $this->detailView(); 
			} break;
			
			case "liste": {
				$titre = "Liste des rapports"; 
				$content = $this->listeView();
			} break;	
								
			default: {
				$titre = "Rapports"; 
				$content = $this->defaultView(); 
			} break;
		}
		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($content);
		$mv->render(); 			
	}
	
	public function detailView() {		
		$html = "";				
		$html .= "<div>";		
		$html .= "	Rapport: <i>DetailView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function listeView() {		
		$i = 1; 
		$html = "";	
		$html .= "<div class='listRapport'>";		
		$html .= "	Rapport: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
		
	public function defaultView() {		 	
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("RapportTmpl.tmpl");
		
		// Rapports déjà crées Section
		$rep = "rapports/general/";
		$dir = opendir($rep);
		while ($f = readdir($dir)) {
		   if(is_file($rep.$f)) {
				$Ext = strtolower(substr($f, strrpos($f, '.')));
				if($Ext==".pdf"){
					$st->addVar("ligneRapport","FICHIER" , $f);
					
					$st->parseTemplate("ligneRapport","a");								 
				 }
		   }
		 }					
		$html .= $st->getParsedTemplate('RapportTmpl');  
		
		return $html;		
	}

}
?>