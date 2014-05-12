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
		$content = " le tdb est pô vide :<br>";
		$ex = Exemplaire::findAll(Exemplaire::ALL);
		$exv= Exemplaire::findAll(Exemplaire::VENDU);
		$exr= Exemplaire::findAll(Exemplaire::RENDRE);
		$exs= Exemplaire::findAll(Exemplaire::INVENDU); $exst = ($ex['count'] - $exv['count']) - $exr['count'];
		//$content .= "Exemplaires déposés : ". $ex['count']." <br>";
		//$content .= " Vendus : ".$exv['count']." ; Rendus : ".$exr['count'] ."; Stock : ".$exs['count']." (controle : $exst) <br>";

		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("TdbTmpl.tmpl");
		
		$st->addVar("TdbTmpl1", "LABEL", "Exemplaires déposés :");
		$st->addVar("TdbTmpl1", "VALUE", $ex['count']);
		$st->parseTemplate("TdbTmpl1", 'a');
		$st->addVar("TdbTmpl1", "LABEL", "Vendus :");
		$st->addVar("TdbTmpl1", "VALUE", $exv['count']);
		$st->parseTemplate("TdbTmpl1", 'a');
		$st->addVar("TdbTmpl1", "LABEL", "Rendus :");
		$st->addVar("TdbTmpl1", "VALUE", $exr['count']);
		$st->parseTemplate("TdbTmpl1", 'a');
		$st->addVar("TdbTmpl1", "LABEL", "EN STOCK :");
		$st->addVar("TdbTmpl1", "VALUE", $exs['count']);
		$st->parseTemplate("TdbTmpl1", 'a');
		
		$f = Famille::findAll(); $dd = DossierDeDepot::findAll(); $da=DossierDAchat::findAll();
		$fp = Famille::findAllParticipe();
		$st->addVar("TdbTmpl2", "LABEL", "Familles dans la base :");
		$st->addVar("TdbTmpl2", "VALUE", count($f));
		$st->parseTemplate("TdbTmpl2", 'a');
		$st->addVar("TdbTmpl2", "LABEL", "dossiers dépôt :");
		$st->addVar("TdbTmpl2", "VALUE", $dd['count']);
		$st->parseTemplate("TdbTmpl2", 'a');
		$st->addVar("TdbTmpl2", "LABEL", "dossiers achat :");
		$st->addVar("TdbTmpl2", "VALUE", $da['count']);
		$st->parseTemplate("TdbTmpl2", 'a');
		$st->addVar("TdbTmpl2", "LABEL", "Familles participantes :");
		$st->addVar("TdbTmpl2", "VALUE", count($fp));
		$st->parseTemplate("TdbTmpl2", 'a');
		
		$montants_depots = DossierDeDepot::montantTDB();
		$st->addVar("TdbTmpl3", "LABEL", "Valeur des livres déposés :");
		$st->addVar("TdbTmpl3", "VALUE", $montants_depots['dsum']);
		$st->parseTemplate("TdbTmpl3", 'a');
		$st->addVar("TdbTmpl3", "LABEL", "Valeur des livres déposés vendus :");
		$st->addVar("TdbTmpl3", "VALUE", $montants_depots['vsum']);
		$st->parseTemplate("TdbTmpl3", 'a');
		$st->addVar("TdbTmpl3", "LABEL", "frais de dossiers sur les dépôts :");
		$st->addVar("TdbTmpl3", "VALUE", $montants_depots['fsum']);
		$st->parseTemplate("TdbTmpl3", 'a');
		
		$montants_ventes = DossierDAchat::montantTDB();
		$st->addVar("TdbTmpl4", "LABEL", "Valeur des livres vendus :");
		$st->addVar("TdbTmpl4", "VALUE", $montants_ventes['asum']);
		$st->parseTemplate("TdbTmpl4", 'a');
		$st->addVar("TdbTmpl4", "LABEL", "somme des dossiers achat :");
		$st->addVar("TdbTmpl4", "VALUE", $montants_ventes['vsum']);
		$st->parseTemplate("TdbTmpl4", 'a');
		$st->addVar("TdbTmpl4", "LABEL", "frais de dossiers sur les achats :");
		$st->addVar("TdbTmpl4", "VALUE", $montants_ventes['fsum']);
		$st->parseTemplate("TdbTmpl4", 'a');
		
		$montants_regles= Regle::montantTDB();
		$st->addVar("TdbTmpl5", "LABEL", "Total des règlements :");
		$st->addVar("TdbTmpl5", "VALUE", $montants_regles['rsum']);
		$st->parseTemplate("TdbTmpl5", 'a');
		foreach ($montants_regles['msum'] as $code=>$montant) {
		   $st->addVar("TdbTmpl5", "LABEL", Reglement::findById($code) -> getAttr('mode_reglement'));
		   $st->addVar("TdbTmpl5", "VALUE", $montant);
		   $st->parseTemplate("TdbTmpl5", 'a');
	   }
		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($st->getParsedTemplate("TdbTmpl"));
		$mv->render(); 			
	}
	
	

}
?>
