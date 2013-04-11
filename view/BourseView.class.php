<?php

session_start();

/**
 * view.BourseView.class.php : classe qui permet faire les views de la Bourse 
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class BourseView {

	private $bourse;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->bourse = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un bourse.
	*   Reçoit en paramètre le nom de l'attribut accède
	*   et retourne sa valeur.
	*  
	*   @param String $attr_name attribute name 
	*   @return mixed
	**/	
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	*   Setter générique
	*
	*   fonction de modification des attributs d'un bourse.
	*   Reçoit en paramètre le nom de l'attribut modifié et la nouvelle valeur
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
			case "liste": {
				$titre = "Liste des bourses"; 
				$content = $this->listeView();
			} break;
			
			default: {
				$titre = "Bourse"; 
				$content = $this->defaultView(); 
			} break;
		}
		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($content);
		$mv->render(); 			
	}
	
	
	public function listeView() {
		$i = 1; 
		$html = "";	
		$html .= "<div class='listBourse'>";		
		$html .= "	Bourse: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	
	public function defaultView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("BourseAdmin.tmpl");			
		$html .= $st->getParsedTemplate('BourseAdmin');  
		
		return $html;	
	}

}
?>