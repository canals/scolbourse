<?php
	session_start();

/**
* view.UtilisateurView.class.php : classe qui permet faire les views des Utilisateurs de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package view
* 
*  View de l'aplicacion
*/
		
  
class UtilisateurView {
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
		
	/**
	* @access private
	* @var Utilisateur 
	* Donn&eacute;es a etre affich&eacute;es
	*/
	private $Utilisateur;		
	
	/**
	* @access private
	* @var mode 
	* Mode de l'affichage
	*/
	private $mode;		
	
	public function __construct($o, $m) {
		$this->Utilisateur = $o;
		$this->mode = $m;
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();
	}

	public function display() {			
		$titre= "";
		$content = "";	
		
		switch ($this->mode) {
			case "detail": {
				echo $this->detailView(); 
				return;
			} break;					
			
			case "liste": {
				$titre = "Liste des Utilisateurs"; 
				$content = $this->listeView();
			} break;				
									
			case "frmCreer" : { 
				$titre = "Cr&eacute;er Utilisateur "; 
				$content = $this->formulaireView(); 
			} break;									
			
			case "frmChangerPassw" : { 
				$titre = "Changer votre password"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "profil": {
				$titre = "Profil de l'utilisateur"; 
				$content = $this->formulaireView(); 
			} break;						
						
			default: {
				$titre = "Liste des Utilisateur"; 
				$content = $this->listeView(); 
			} break;
		} 		
 		$mv = new MainView();		
		$mv->addTitre($titre); 
		$mv->addMenu($this->getMenu());
		$mv->addContenu($content);
		$mv->render();  			
	}
		
	/***Fonctions pour render l'interface ***/
	private function detailView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("UtilisateurDetail.tmpl");
		
		$st->addVar("UtilisateurDetail","ID",$this->Utilisateur->getAttr("idUtilisateur"));
		$st->addVar("UtilisateurDetail","NOM",$this->Utilisateur->getAttr("nom"));
		$st->addVar("UtilisateurDetail","PRENOM",$this->Utilisateur->getAttr("prenom"));
		$st->addVar("UtilisateurDetail","LOGIN",$this->Utilisateur->getAttr("login"));
		$type=($this->Utilisateur->getAttr("typeUtilisateur")==BourseAuth::$ADMIN_LEVEL)?"Administrateur":"B&eacute;n&eacute;vole";
		$st->addVar("UtilisateurDetail","TYPE",$type);		
		return $st->getParsedTemplate('UtilisateurDetail');
	}
	
	private function listeView() {
		$html = "";
		if(isset($this->Utilisateur) && count($this->Utilisateur) != 0) {
			$st = new patTemplate();
			$st->setRoot("templates");			
			$st->readTemplatesFromInput("UtilisateurListe.tmpl");
			$i=1;
			foreach($this->Utilisateur as $o) {
				$st->addVar("ligne","CLASS",($i%2==0)?"listePair":"listeImpair");
				$st->addVar("ligne","NRO",$i);
				$st->addVar("ligne","ID",$o->getAttr("idUtilisateur"));
				$nom = strtoupper($o->getAttr("nom"))." ".$o->getAttr("prenom");
				$st->addVar("ligne","NOM",$nom);
				$type = ($o->getAttr("typeUtilisateur")==BourseAuth::$ADMIN_LEVEL)?"Administrateur":"B&eacute;n&eacute;vole";
				$st->addVar("ligne","TYPE",$type);
				
				$st->parseTemplate("ligne","a");
				$i++;												
			}
			$html .= $st->getParsedTemplate('UtilisateurListe');
		} else	{
			$html .= "<emph>Aucun utilisateur</emph><br>";
		}
		return $html;
	}
	
	private function formulaireView() {	
		$html = "";		
		$html .= "<div id='forms' align='center'>";
		$html .= $this->Utilisateur->render();
		$html .= "</div>";
		return $html;
	}			
	
	private function getMenu() {			
		// Menu Utilisateur
		$arrMenu = array();					
		if($this->user!=null) {		
			try {
				$auth = new BourseAuth();
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ;
				// Administrateur								
				$arrMenu[] = array(BourseControleur::$MNU_ID       ,"Bourse"     , "/ScolBoursePHP/index.php/Bourse","");
				$arrMenu[] = array(ManuelControleur::$MNU_ID       ,"Manuels"    , "/ScolBoursePHP/index.php/Manuel","");		
				$arrMenu[] = array(FamilleControleur::$MNU_ID      ,"Familles"   , "/ScolBoursePHP/index.php/Famille","");
				$arrMenu[] = array(ParametrageControleur::$MNU_ID  ,"Param&egrave;tres" , "/ScolBoursePHP/index.php/Parametrage","");				
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