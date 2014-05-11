<?php

session_start();

/**
 * view.ParametrageView.class.php : classe qui permet faire les views des Parametrages de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class ParametrageView {

	private $tx;

	private $etat;
	
	private $reglement;
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($oTaux, $oReglement, $oEtat, $m) {
		$this->tx = $oTaux;
		$this->reglement = $oReglement;
		$this->etat = $oEtat;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un parametrage.
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
	*   fonction de modification des attributs d'un parametrage.
	*   Reçoit en paramètre le nom de l'attribut modifié et la nouvelle valeur
	*  
	*   @param String $attr_name attribute name 
	*   @param mixed $attr_val attribute value
	*   @return mixed new attribute value
	*/
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name = $attr_val;
		return $attr_val;
	}
	
	public function display() {			
		$titre= "";
		$content = "";			
		switch($this->mode) {			
			case "detail": { 
				echo $this->detailView(); 
				return;
			} break;
			
			case "liste": {
				$titre = "Liste des parametrages"; 
				$content = $this->listeView();
			} break;							
			
			case "frmCreer" : { 
				$titre = "Créer parametrage"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "save" : { 
				$titre = "Modifier parametrage"; 
				$content = $this->formulaireView(); 
			} break;
			
			default: {
				$titre = "Parametrages"; 
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
		$st = new patTemplate();
		$st->setRoot("templates");

		$html = "";
	
		if($this->etat != null){
			$st->readTemplatesFromInput("EtatDetail.tmpl");
		
			$st->addVar("EtatDetail", "CODE", $this->etat->getAttr("code_etat"));
			$st->addVar("EtatDetail", "LIBELLE", $this->etat->getAttr("libelle_etat"));
			$st->addVar("EtatDetail", "POURCENTAGE", $this->etat->getAttr("pourcentage_etat"));

			$html = $st->getParsedTemplate('EtatDetail');
		}elseif($this->reglement != null){

			$st->readTemplatesFromInput("ReglementDetail.tmpl");
		
			$st->addVar("ReglementDetail", "CODE_PAIEMENT", $this->reglement->getAttr("code_reglement"));
			$st->addVar("ReglementDetail", "LIBELLE_PAIEMENT", $this->reglement->getAttr("mode_reglement"));

			$html = $st->getParsedTemplate('ReglementDetail');
		}
		
		return $html;
	}
	
	public function listeView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type") == BourseAuth::$ADMIN_LEVEL);
		
		$i = 1; 
		$html = "";	
		$html .= "<div class='listParametrage'>";		
		$html .= "	Parametrage: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div id='forms' align='center'>";		
		$html .= $this->tx->render();						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function defaultView() {
		$html = "";
			
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("Parametrage.tmpl");
		
		if(isset($this->etat) && count($this->etat) != 0) {
			$i = 1;
			foreach($this->etat as $o) {
				$st->addVar("ligne", "CLASS", ($i % 2 == 0) ? "listePair" : "listeImpair");
				$st->addVar("ligne", "CODE", $o->getAttr("code_etat"));
				$st->addVar("ligne", "LIBELLE", $o->getAttr("libelle_etat"));
				$st->addVar("ligne","POURCENTAGE", $o->getAttr("pourcentage_etat"));
				
				$st->parseTemplate("ligne", "a");
				$i++;												
			}
		}

		if(isset($this->reglement) && count($this->reglement) != 0){
			$i = 1;
			foreach($this->reglement as $r){
				$st->addVar("ligne_paiement", "CLASS", ($i % 2 == 0) ? "listePair" : "listeImpair");
				$st->addVar("ligne_paiement", "CODE_PAIEMENT", $r->getAttr("code_reglement"));
				$st->addVar("ligne_paiement", "LIBELLE_PAIEMENT", $r->getAttr("mode_reglement"));
				
				$st->parseTemplate("ligne_paiement", "a");
				$i++;
			}
		} 

		if(isset($this->tx) && count($this->tx) != 0){
			$i = 1;
			foreach($this->tx as $t){
				$st->addVar("ligne_frais", "FRAIS_DOSSIER", $t->getAttr("taux_frais"));
				$st->addVar("ligne_frais", "FRAIS_ENVOI", $t->getAttr("montant_frais_envoi"));
				
				$st->parseTemplate("ligne_frais", "a");
				$i++;
			}
		}		

		$html .= $st->getParsedTemplate('Parametrage');
		
		return $html;
	}
}
?>
