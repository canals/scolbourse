<?php

session_start();

/**
 * view.TBDView.class.php : classe qui permet faire les views Tableau de bord
 *
 * @author Gérôme Canals
 *
 * @package view
**/

class TDBView {

	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct() {

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
		$titre= "Tableau de Bord de la Bourse";
		$content = "pour l'instant, le tbd est vide";

		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($content);
		$mv->render(); 			
	}
	
	

}
?>
