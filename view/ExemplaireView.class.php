<?php

session_start();

/**
 * view.ExemplaireView.class.php : classe qui permet faire les views des Exemplaires de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class ExemplaireView {

	private $exemplaire;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->exemplaire = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un exemplaire.
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
	*   fonction de modification des attributs d'un exemplaire.
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
				$titre = "Detail exemplaire"; 
				$content = $this->detailView(); 
			} break;
			
			case "voirDetail": {
				echo $this->voirDetailView(); 
				return;
			} break;
			
			case "liste": {
				$titre = "Liste des exemplaires"; 
				$content = $this->listeView();
			} break;							
			
			case "creer" : { 
				$titre = "Cr&eacute;er exemplaire"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "save" : { 
				$titre = "Modifier exemplaire"; 
				$content = $this->formulaireView(); 
			} break;
			
			default: {
				$titre = "Exemplaires"; 
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
		$html .= "	Exemplaire: <i>DetailView... </i><BR/>" ;
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
		$html .= "<div class='listExemplaire'>";		
		$html .= "	Exemplaire: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->exemplaire->render();	
		$html .= "	Exemplaire: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function defaultView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
		
		$html = "";				
		$html .= "<div>";		
		$html .= "	Exemplaire: <i>DefaultView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function voirDetailView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
		
		// Trouver les donn&eacute;es pour afficher
		$exemp = $this->getAttr("exemplaire");										
		
		$man = Manuel::findById($exemp->getAttr("code_manuel"));
		$etat = Etat::findById($exemp->getAttr("code_etat"));
		$determine = Determine::findById($exemp->getAttr("code_etat"),$exemp->getAttr("code_manuel"));
		
		// Afficher l'exemplaire
		$html = "";				
		$html .= "<div>";		
		$html .= "	Code exemplaire: <i>".$exemp->getAttr("code_exemplaire")."</i><BR/>" ;
		$html .= "	Titre: <i><strong>".$man->getAttr("titre_manuel")."</strong></i><BR/>" ;
		$html .= "	Mati&egrave;re: <i>".$man->getAttr("matiere_manuel")."</i><BR/>" ;
		$html .= "	Etat: <i>".$etat->getAttr("libelle_etat")."</i><BR/>" ;
		$html .= "	Tarif: <i>".$determine->getAttr("tarif")."</i><BR/>" ;
		$html .= "</div>" ;
		
		$res= '{ "code": "'.$exemp->getAttr("code_exemplaire").'" , ';
                $res.= '"titre": "'.$man->getAttr("titre_manuel").'",';
                $res.= '"matiere": "'.$man->getAttr("matiere_manuel").'",';
                $res.= '"tarif" : "'.$determine->getAttr("tarif").'" }';
                return $res;
	}

}
?>