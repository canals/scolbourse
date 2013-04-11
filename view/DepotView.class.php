<?php

session_start();

/**
 * view.DepotView.class.php : classe qui permet faire les views des Depots de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class DepotView {

	private $depot;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->depot = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un depot.
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
	*   fonction de modification des attributs d'un depot.
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
			case "ajouter": {				
				echo $this->ajouterView(); 
				return;
			} break;					
			
			case "supprimer": {				
				echo $this->supprimerView(); 
				return;
			} break;
			
			case "rendre": {				
				echo $this->rendreView(); 
				return;
			} break;	
			
			case "retourInvendus": {				
				echo $this->retourInvendusView(); 
				return;
			} break;
			
			case "detail": {
				$titre = "Outil d'depot des livres"; 
				$content = $this->detailView(); 
			} break;
						
			default: {
				$titre = "Depots"; 
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
		return $this->getAttr("depot");
	}
		
	public function supprimerView() {
		return $this->getAttr("depot");
	}
	
	public function rendreView() {
		return $this->getAttr("depot");
	}
		
	public function detailView() {
		$html = "";	
		$html .= "<div class='listDepot'>";		
		$html .= "	Depot: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		return $html;
	}
	
	public function listeView() {		
		$html = "";	
		$html .= "<div class='listDepot'>";		
		$html .= "	Depot: <i>ListeView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->depot->render();	
		$html .= "	Depot: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;		
		return $html;
	}
	
	
	public function retourInvendusView() {
		$fam = $this->depot;
				
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("RetourInvendusTmpl.tmpl");							
				
		/*** Section pour les Depots ***/	
		if($fam!=null) {
			/*** Section pour les Depots ***/											
			$dossierDeDepot = $fam->getAttr("dossierDeDepot");	
			$st->addVar("RetourInvendusTmpl","NUM_FAMILLE" , ($fam!=null)?$fam->getAttr("num_famille"):"");									
			
			if($dossierDeDepot!=null) {			
						
				// Ajouter les exempaires				
				$exemplaires = $dossierDeDepot->getAttr("exemplaires");
				$select = (count($exemplaires)>0)?"default":"empty";
				$st->addVar("detailInvendus","SELECT" , $select);				
								
				if($exemplaires != null) {
					$i=0;
					foreach($exemplaires as $ex) {					
						if($ex->getAttr("vendu")==Exemplaire::INVENDU) {								
							$man = Manuel::findById($ex->getAttr("code_manuel"));
							$etat = Etat::findById($ex->getAttr("code_etat"));
							$determine = Determine::findById($etat->getAttr("code_etat"), $man->getAttr("code_manuel"));
							
							$st->addVar("ligneListe","CLASS" , ($i%2==0)?"listePair":"listeImpair");										
														
							$st->addVar("ligneListe","CODE_EXEMPLAIRE" , $ex->getAttr("code_exemplaire"));
							$st->addVar("ligneListe","TITRE"           , $man->getAttr("titre_manuel"));
							$st->addVar("ligneListe","MATIERE"         , $man->getAttr("matiere_manuel"));
							$st->addVar("ligneListe","ETAT"            , strtoupper($etat->getAttr("libelle_etat")));
							$st->addVar("ligneListe","TARIF"           , floatval($determine->getAttr("tarif")));
							
							// Le dossierpour les achat qui sont fait pour l'association: la valeur "1" represente à l'association
							$st->addVar("ligneListe","NUM_FAMILLE" , $fam->getAttr("num_famille"));				
							$st->addVar("ligneListe","DOSSIER_ACHAT" , 1);				
							
							$i++;
							$st->parseTemplate("ligneListe","a");
						}
					}	
				}												
			}											
		} 	 		
		return $st->getParsedTemplate('RetourInvendusTmpl');  
	}
	
}
?>