<?php
	session_start();

  /**
   * File : MainView.class.php
   *
   * @author RIVAS Ronel Ronel et SUSTAITA Luis
   *
   * @package view
   * 
   *  Vista de la aplicacion
   */
   

class MainView {	

	/**
	* @access private
	* @var Titre 
	* Titre de la page
	*/
	private $titre;
	
	/**
	* @access private
	* @var content 
	* Contenu de la page
	*/
	private $contenu;

	/**
	* @access private
	* @var menu 
	* Menu superieure de la page. Il est une Tableau (Array) avec des options du menu
	*/
	private $menu;
		
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
 
	
	public function __construct(){	
		$this->titre = null;
		$this->menu = null;
		$this->publicite = null;
		$this->contenu = null;
		
		// Utilisateur courante
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();	
	}
	
	  /**
   *   Getter g&eacute;n&eacute;rique
   *
   *   fonction d'acc&eacute;s aux attributs d'un objet.
   *   Reçoit en param&egrave;tre le nom de l'attribut acc&egrave;de
   *   et retourne sa valeur.
   *  
   *   @param String $attr_name attribute name 
   *   @return mixed
   */
   
  public function getAttr($attr_name) {
    return $this->$attr_name;
  }
  
  /**
   *   Setter g&eacute;n&eacute;rique
   *
   *   fonction de modification des attributs d'un objet.
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
	
	public function addTitre($titre) {
		$this->setAttr("titre",$titre);
	}
	
	public function addContenu($content) {
		$this->setAttr("contenu",$content);
	}
	
	public function addMenu($menu) {
		$this->setAttr("menu",$menu);
	}			
		
	public function render() {	
		$st = new patTemplate();
		$st->setRoot("templates");
		$st->readTemplatesFromInput("MainView.tmpl");				
				
		// Identification de l'utilisateur
		$utilitaires = "";
		if($this->user!=null) {
			$utilitaires .= "<span class='userId'><span style='font-size:90%; font-weight:lighter;'>";
			if(date("H")<=18) $utilitaires .= "Bonjour, ";
			else $utilitaires .= "Bonsoir, ";
			$utilitaires .= "</span>";
			try {
				$auth = new BourseAuth();
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
				// Administrateur								
				$utilitaires .= "ADMINISTRATEUR: ";
			} catch(AuthException $a) {	$utilitaires .= "BENEVOLE: "; }												
			$utilitaires .= strtoupper($this->user->getAttr("nom"))." ".$this->user->getAttr("prenom") . ". ";
			$utilitaires .= "<a href='/ScolBoursePHP/scripts/logout.php'>[ Deconnexion ]</a></span>";					
		}	
		
		// Mis &agrave; jour les elements de la page
		$st->addVar("MainView","TITRE_SUP","ScolBourse - " . $this->getAttr("titre"));
		$st->addVar("MainView","MENU",$this->getMenu());
		$st->addVar("MainView","UTILITAIRES",$utilitaires);		
		$st->addVar("MainView","TITRE",$this->getAttr("titre"));			
		$st->addVar("MainView","CONTENU",$this->getAttr("contenu"));
		
		// Afficher la page
		$st->displayParsedTemplate("MainView");				
	}
	
	// Fonction private, pour render l'interface			
	private function getMenu() {		
		$i = 1;
		$html = "";		
		if($this->getAttr("menu")==null)
			$this->addMenu($this->menuParDefaut());					
		foreach($this->menu as $mnu) {			
			$class = ($_SESSION['mnuId']==$mnu[0])?"active":"";		
			$html.= "<a href='". $mnu[2] ."' id='mnu".$i."' class='" . $class . "' target='".$mnu[3]."'>". $mnu[1]."</a>"."\n";
			$i += 1;										
		}										
		return $html;
	}
	
	private function menuParDefaut() {			
		// Menu Utilisateur
		$arrMenu = array();					
		if($this->user!=null) {		
			try {
				$auth = new BourseAuth();
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
				// Administrateur								
				$arrMenu[] = array(TDBControleur::$MNU_ID       ,"Bourse"     , "/ScolBoursePHP/index.php/TDB","");
				$arrMenu[] = array(ManuelControleur::$MNU_ID       ,"Manuels"    , "/ScolBoursePHP/index.php/Manuel","");		
				$arrMenu[] = array(FamilleControleur::$MNU_ID      ,"Familles"   , "/ScolBoursePHP/index.php/Famille","");
				$arrMenu[] = array(ParametrageControleur::$MNU_ID  ,"Param&egrave;tres" , "/ScolBoursePHP/index.php/Parametrage","");	
				$arrMenu[] = array(BourseControleur::$MNU_ID       ,"Base"     , "/ScolBoursePHP/index.php/Bourse","");			
				$arrMenu[] = array(UtilisateurControleur::$MNU_ID2 ,"B&eacute;n&eacute;voles"  , "/ScolBoursePHP/index.php/Utilisateur","");	
			} catch(AuthException $a) {
				// Benevole
				$arrMenu[] = array(HomeControleur::$MNU_ID   ,"Accueil"    , "/ScolBoursePHP/index.php","");
				$arrMenu[] = array(RapportControleur::$MNU_ID ,"Rapports" , "/ScolBoursePHP/index.php/Rapport","");	
			}								
			$arrMenu[] = array(UtilisateurControleur::$MNU_ID,"Profil","/ScolBoursePHP/index.php/Utilisateur/voirProfil/".$this->user->getAttr("idUtilisateur"),"");						
			try {
				$auth = new BourseAuth();
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
				$arrMenu[] = array(AideControleur::$MNU_ID,"Aide","/ScolBoursePHP/aide/aide_admin.pdf", "_blank");				
			} catch(AuthException $a) {		
				$arrMenu[] = array(AideControleur::$MNU_ID,"Aide","/ScolBoursePHP/aide/aide_benevole.pdf", "_blank");
			}				
		} else {
			$arrMenu[] = array(AideControleur::$MNU_ID,"Aide","/ScolBoursePHP/aide/aide_anonyme.pdf", "_blank");
		}
		
		return $arrMenu;				
	}
	
}
?>
