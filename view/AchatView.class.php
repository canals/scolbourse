<?php

//session_start();

/**
 * view.AchatView.class.php : classe qui permet faire les views des Achats de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class AchatView {

	private $achat;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->achat = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un achat.
	*   Re�oit en param&egrave;tre le nom de l'attribut acc&egrave;de
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
	*   fonction de modification des attributs d'un achat.
	*   Re�oit en param&egrave;tre le nom de l'attribut modifi&eacute; et la nouvelle valeur
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
			case "ajouter": {				
				echo $this->ajouterView(); 
				return;
			} break;
			
			case "supprimer": {				
				echo $this->supprimerView(); 
				return;
			} break;
			
			case "ajouterRegle": {				
				echo $this->ajouterRegleView(); 
				return;
			} break;
			
			case "supprimerRegle": {				
				echo $this->supprimerRegleView(); 
				return;
			} break;
			
			
			case "detail": {
				$titre = "Outil d'achat des livres"; 
				$content = $this->detailView(); 
			} break;
						
			default: {
				$titre = "Achats"; 
				$content = $this->defaultView(); 
			} break;
		}		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($content);
		$mv->render(); 			
	}
	
	public function ajouterView() {
		return $this->getAttr("achat");
	}
	
	public function supprimerView() {
		return $this->getAttr("achat");
	}
	
	public function ajouterRegleView() {
	     return $this->getAttr("achat");
             //return "glouppss ..";
            //return '';
	}
	
	public function supprimerRegleView() {
		return $this->getAttr("achat");
	}
	
		
	public function detailView() {
		$html = "";	
		$html .= "<div class='listAchat'>";		
		$html .= "	Achat: <i>DetailView... </i><BR/>" ;
		$html .= "</div>" ;
		return $html;	
	}
	
	public function listeView() {		
		$html = "";	
		$html .= "<div class='listAchat'>";		
		$html .= "	Achat: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->achat->render();	
		$html .= "	Achat: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;		
		return $html;
	}
}
?>