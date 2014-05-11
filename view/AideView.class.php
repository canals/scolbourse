<?php

session_start();

/**
 * view.AideView.class.php : classe qui permet faire les views des Aides de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class AideView {

	private $aide;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->aide = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un aide.
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
	*   fonction de modification des attributs d'un aide.
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
			case "detail": {
				$titre = "Detail aide"; 
				$content = $this->detailView(); 
			} break;
			
			case "liste": {
				$titre = "Liste des aides"; 
				$content = $this->listeView();
			} break;							
			
			case "creer" : { 
				$titre = "Créer aide"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "save" : { 
				$titre = "Modifier aide"; 
				$content = $this->formulaireView(); 
			} break;
			
			default: {
				$titre = "Aides"; 
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
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
		
		$html = "";				
		$html .= "<div>";		
		$html .= "	Aide: <i>DetailView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function listeView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
		
		$i = 1; 
		$html = "";	
		$html .= "<div class='listAide'>";		
		$html .= "	Aide: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->aide->render();		
		$html .= "	Aide: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function defaultView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		$html = "";				
		$html .= "<div class='aide'>";
		try {
			$auth = new BourseAuth();
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
			$html .= "	 <a onclick='ouvrirpdf(\"/ScolBoursePHP/aide/aide_admin.pdf\");'>Aide Administrateur</a><BR/>" ;
			$html .= "	 <a onclick='ouvrirpdf(\"/ScolBoursePHP/aide/aide_benevole.pdf\");'>Aide Bénévole</a><BR/>" ;
		} catch(AuthException $a) {
			$html .= "	 <a onclick='ouvrirpdf(\"/ScolBoursePHP/aide/aide_benevole.pdf\");'>Aide</a><BR/>" ;
		}
		$html .= "</div>" ;
		return $html;
	}
}

?>