<?php

session_start();

/**
 * view.ManuelView.class.php : classe qui permet faire les views des Manuels de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class ManuelView {

	private $manuel;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->manuel = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un manuel.
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
	*   fonction de modification des attributs d'un manuel.
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
				echo $this->detailView(); 
				return;
			} break;
			
			case "voirDetail": {
				echo $this->voirDetailView(); 
				return;
			} break;
			
			case "liste": {
				echo $this->listeView();
				return;
			} break;						
			
			case "creer" : { 
				$titre = "Cr&eacute;er manuel"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "save" : { 
				$titre = "Modifier manuel"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "detailManuel" : { 
				echo $this->detailManuel(); 
				return;
			} break;			
			
			case "ok": {
				$titre = "Manuel"; 
				$content = $this->okView();
			} break;		

			case "detailManuel" : { 
				echo $this->detailManuel(); 
				return;
			} break;
			
			case "importerView" : { 
				$titre = "Manuel: Resultat de l'importation"; 
				$content = $this->importerView(); 				
			} break;
			
			case "exporterView" : { 
				$titre = "Manuel : Resultat de l'exportation";
				$content= $this->exporterView(); 
				//return;
			} break;
						
			default: {
				$titre = "Manuels"; 
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
		$st->readTemplatesFromInput("ListeDetail.tmpl");
		
		$st->addVar("ListeDetail","ID",$this->manuel->getAttr("code_liste"));
		$st->addVar("ListeDetail","NOM",$this->manuel->getAttr("libelle_liste"));
		$st->addVar("ListeDetail","CLA",$this->manuel->getAttr("classe_liste"));
		return $st->getParsedTemplate('ListeDetail');
	}	
	
	public function listeView() {
		$html = "";
		if($this->manuel!=null) {		
			$st = new patTemplate();
			$st->setRoot("templates");			
			$st->readTemplatesFromInput("ManuelListeSelect.tmpl");
			
			$html = "";	
			$html .= "<div style='width:100%; overflow:auto;'>";
			$html .= "<h2>R&eacute;sultats de la recherche</h2>";		
			$html .= "<table align='left' width='95%'>";
			$html .= "<tr>";
			$html .= "	<th width='2%'  align='left'>Id</th>";
			$html .= "  <th width='40%' align='left'>Nom</th>";
			$html .= "	<th width='10%' align='left'>&nbsp;Classe</th>";
			$html .= "  <th width='30%' align='left'>&nbsp;Matiere</th>";
			$html .= "	<th width='18%' align='left'>&nbsp;&nbsp;Editeur</th>";			
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
			$html .= "<div style='width:100%; height:80%; overflow:auto; border-bottom: 1px dashed #ccc;'>";										
			$i=1;
			if($this->manuel!=null)
				foreach($this->manuel as $man) {		
					$st->addVar("ligne","CLASS"      ,($i%2==0)?"listePair":"listeImpair");
					$st->addVar("ligne","ID"         , $man->getAttr("code_manuel"));
					$st->addVar("ligne","NRO"        , $i++);	
					$st->addVar("ligne","NOM_MAN"    , $man->getAttr("titre_manuel"));	
					$st->addVar("ligne","CLASSE_MAN" , $man->getAttr("classe_manuel"));	
					$st->addVar("ligne","MAT_MAN"    , $man->getAttr("matiere_manuel"));	
					$st->addVar("ligne","EDIT_MAN"   , $man->getAttr("editeur_manuel"));	
					
					$st->parseTemplate("ligne","a");
				}		
			$html .= $st->getParsedTemplate('ManuelListeSelect');									
		} else 
			$html .= "<br/><div>Accun Manuel ne correspond a votre crit&eagrave;re de selection...</div><br/>";

		$html .= "</div>";
		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		return $html;
	}
	
	public function detailListe() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ManuelDetail.tmpl");
		
		$st->addVar("ManuelDetail","ID",$this->manuel->getAttr("code_liste"));
		$st->addVar("ManuelDetail","NOM",$this->manuel->getAttr("libelle_liste"));
		$st->addVar("ManuelDetail","CLA",$this->manuel->getAttr("classe_liste"));
		return $st->getParsedTemplate('ManuelDetail');		
	}

	public function detailManuel() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ManuelSelect.tmpl");
		
		$st->addVar("ManuelSelect","ACTCHER" ,($man==null)?"":"disabled");						
		$st->addVar("ManuelSelect","ACTMOD"  ,($man==null)?"disabled":"");		
		$st->addVar("ManuelSelect","ACTCHAM" ,"disabled");
											
		$st->addVar("ManuelSelect","JVS"        ,"/ScolBoursePHP/js/ManuelAdmin.js");
		$st->addVar("ManuelSelect","ID"         ,($man!=null)?$man->getAttr("code_manuel"):"");
		$st->addVar("ManuelSelect","NOM_MAN"    ,($man!=null)?$man->getAttr("titre_manuel"):"");
		$st->addVar("ManuelSelect","CLASSE_MAN" ,($man!=null)?$man->getAttr("classe_manuel"):"");
		$st->addVar("ManuelSelect","MAT_MAN"    ,($man!=null)?$man->getAttr("matiere_manuel"):"");
		$st->addVar("ManuelSelect","EDIT_MAN"   ,($man!=null)?$man->getAttr("editeur_manuel"):"");
		$st->addVar("ManuelSelect","AN_MAN"     ,($man!=null)?$man->getAttr("date_edition_manuel"):"");
		$st->addVar("ManuelSelect","TARIF_MAN"  ,($man!=null)?$man->getAttr("tarif_neuf_manuel"):"");
							
		$html .= $st->getParsedTemplate('ManuelSelect');  		
	}
	
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->manuel->render();	
		$html .= "	Manuel: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function voirDetailView() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
				
		$man = $this->getAttr("manuel");
		$html = "";				
		$html .= "<div>";		
		$html .= "	Code manuel: <i>".$man->getAttr("code_manuel")."</i><BR/>" ;
		$html .= "	Titre: <i><strong>".$man->getAttr("titre_manuel")."</strong></i><BR/>" ;
		$html .= "	Classe: <i>".$man->getAttr("classe_manuel")."</i><BR/>" ;
		$html .= "	Editeur: <i>".$man->getAttr("editeur_manuel")."</i><BR/>" ;
		$html .= "	Tarif neuf: <i>".$man->getAttr("tarif_neuf_manuel")."</i><BR/>" ;
		$html .= "	Date edition: <i>".$man->getAttr("date_edition_manuel")."</i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function defaultView() {
		 
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ManuelTmpl.tmpl");
		
		// Liste Manuel Section
		$i=1;
		$b = new Liste();
		$tab = $b->findAll();
		if(sizeof($tab)!=0){
			foreach($tab as $o) {
				$st->addVar("ligne","CLASS",($i%2==0)?"listePair":"listeImpair");
				$st->addVar("ligne","NRO",$i);
				$st->addVar("ligne","LIB",$o->getAttr("libelle_liste"));
				$st->addVar("ligne","ID",$o->getAttr("code_liste"));
				$nom = strtoupper($o->getAttr("classe_liste"));
				$st->addVar("ligne","CLA",$nom);
					
				$st->parseTemplate("ligne","a");
				$i++;												
			}
		}else{
			$st->addVar("ligne","NRO","");
			$st->addVar("ligne","LIB","");
			$st->addVar("ligne","ID","");
			$st->addVar("ligne","CLA","Aucune liste !");
			$st->parseTemplate("ligne","a");
		}
		
		// Section Import_Export : ajouter la liste de listes
		$liste_man_i = "<select id='imp_liste_manuel' name='imp_liste_manuel' {ATCHAM}>";
		$listes = Liste::findAll();
		if($listes!=null) {
			foreach($listes as $liste){					
				$liste_man_i .= "<option value='" . $liste->getAttr("code_liste") . "' >"; 
				$liste_man_i .= $liste->getAttr("libelle_liste") . "</option>";
			}
		} 
		$liste_man_i .= "</select>";
		//$sti = new patTemplate();
		//$sti->setRoot("templates");			
		//$st->readTemplatesFromInput("ImpExpManuel.tmpl");
		$st->addvar("ImpExpManuel","IMP_LISTE", $liste_man_i);
		$st->addvar("ImpExpManuel","EXP_LISTE", $liste_man_i);
		if (is_null($listes)) {
			$st->addvar("ImpExpManuel","ATCHAM", "disabled");
		}
		
		// Gestion Manuel Section 
		$man = $this->manuel;	
		
		
		
		// Manuel_Liste
		$liste_man = "<select id='liste_manuel' name='liste_manuel[]' multiple size='3' {ACTCHAM}>";
		$listes = Liste::findAll();
		if($listes!=null) {
			foreach($listes as $liste){	
				$manListe = null;
				if($man!=null)  
					$manListe = ListeManuel::findById($man->getAttr("code_manuel"),$liste->getAttr("code_liste"));
				$liste_man .= "<option value='" . $liste->getAttr("code_liste") . "' "; 
				$liste_man .= (($manListe!=null)?"selected":"") . ">";								
				$liste_man .= $liste->getAttr("libelle_liste") . "</option>";
			}
		} 
		$liste_man .= "</select>";
		
		$st->addVar("ManuelSelect","JVS"        ,"/ScolBoursePHP/js/ManuelAdmin.js");
		$st->addVar("ManuelSelect","ID"         ,($man!=null)?$man->getAttr("code_manuel"):"");
		$st->addVar("ManuelSelect","NOM_MAN"    ,($man!=null)?$man->getAttr("titre_manuel"):"");
		$st->addVar("ManuelSelect","CLASSE_MAN" ,($man!=null)?$man->getAttr("classe_manuel"):"");
		$st->addVar("ManuelSelect","MAT_MAN"    ,($man!=null)?$man->getAttr("matiere_manuel"):"");
		$st->addVar("ManuelSelect","EDIT_MAN"   ,($man!=null)?$man->getAttr("editeur_manuel"):"");
		$st->addVar("ManuelSelect","AN_MAN"     ,($man!=null)?$man->getAttr("date_edition_manuel"):"");
		$st->addVar("ManuelSelect","TARIF_MAN"  ,($man!=null)?$man->getAttr("tarif_neuf_manuel"):"" );		
		$st->addVar("ManuelSelect","LISTE_MAN"  ,$liste_man);		
		
		$st->addVar("ManuelSelect","ACTCHER" ,($man==null)?"":"disabled");						
		$st->addVar("ManuelSelect","ACTMOD"  ,($man==null)?"disabled":"");			
		$st->addVar("ManuelSelect","ACTINS"  ,"disabled");		
		$st->addVar("ManuelSelect","ACTCHAM" ,"disabled");
		
		// tarifs manuels
		if (! is_null($man)) {
			$tarifs= Determine::findByManuel($man->getAttr('code_manuel'));
			foreach ($tarifs as $tarif) {
				$t = $tarif->getAttr('tarif');
				$l = Etat::findById($tarif->getAttr('code_etat'))->getAttr('libelle_etat');
				$st->addVar("TarifManuel", "ETAT", $l);
				$st->addVar("TarifManuel", "TARIF", $t);
				$st->parseTemplate("TarifManuel", "a");
			}
		}									
		$html .= $st->getParsedTemplate('ManuelTmpl');  			
		return $html;
	}
	 
	public function okView() {
		$html = "";				
		$html .= "<div>";		
		$html .= "	<BR/>".$this->manuel."<BR/>";
		$html .= "	<a href='/ScolBoursePHP/index.php/Manuel/' target='_self'>Retour</a><BR/>";
		$html .= "</div>" ;		
		return $html;
	}
	
	public function importerView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ImporterTmpl.tmpl");
		
		$st->addVar("ImporterTmpl","MODULE"  ,"Manuel");						
		$st->addVar("ImporterTmpl","MESSAGE" ,($this->manuel!=null)?$this->manuel:"");		
		$html .= $st->getParsedTemplate('ImporterTmpl');  
		
		return $html;
	}
	
	public function exporterView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ExporterTmpl.tmpl");
		
		$st->addVar("ExporterTmpl","MODULE"  ,"Manuel");						
		$st->addVar("ExporterTmpl","MESSAGE" ,($this->manuel!=null)?$this->manuel:"");
		$fichier = (isset($_SESSION["fichier"]))?$_SESSION["fichier"]:"";
		$st->addVar("ExporterTmpl","FICHIER" , "/ScolBoursePHP/".$fichier);		
		$st->addVar("ExporterTmpl","RETOUR","/ScolBoursePHP/index.php/Manuel");					
		$html .= $st->getParsedTemplate('ExporterTmpl');  
		
		return $html;
	}
	

}
?>
