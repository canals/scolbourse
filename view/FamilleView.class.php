<?php

session_start();

/**
 * view.FamilleView.class.php : classe qui permet faire les views des Familles de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class FamilleView {

	private $famille;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->famille = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();	
		}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un famille.
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
	*   fonction de modification des attributs d'un famille.
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
				$titre = "Detail famille"; 
				$content = $this->detailView(); 
			} break;
			
			case "liste": {
				echo $this->listeView();
				return;
			} break;

			case "listeParExemplaire": {
				echo $this->listeParExemplaireView();
				return;
			} break;			
			
			case "creer" : { 
				echo $this->creerView(); 
				return;
			} break;
			
			case "save" : { 
				$titre = "Modifier famille"; 
				$content = $this->formulaireView(); 
			} break;
			
			case "ok" : { 
				echo $this->okView(); 
				return;
			} break;
			
			case "importerView" : { 
				$titre = "Famille: Resultat de l'importation"; 
				$content = $this->importerView(); 				
			} break;
			
			case "exporterView" : { 
				$titre = "Famille: Resultat de l'exportation"; 
				$content = $this->exporterView(); 
				//return;
			} break;			
			
			default: {
				$titre = "Familles"; 
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
		$html .= "	Famille: <i>DetailView... </i><BR/>" ;
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function listeView() {
		$html = "";
		if($this->famille!=null) {		
			$st = new patTemplate();
			$st->setRoot("templates");			
			$st->readTemplatesFromInput("FamilleListeSelect.tmpl");
														
			$i=1;
			foreach($this->famille as $fam) {		
				$st->addVar("ligne","CLASS"      ,($i%2==0)?"listePair":"listeImpair");
				$st->addVar("ligne","ID"         , $fam->getAttr("num_famille"));
				$st->addVar("ligne","NRO"        , $i++);	
				$st->addVar("ligne","NOM" , (strtoupper($fam->getAttr("nom_famille")). ", ".$fam->getAttr("prenom_famille")));	
				$st->addVar("ligne","CODEPOSTAL" , $fam->getAttr("code_postal_famille"));	
				$st->addVar("ligne","VILLE"      , $fam->getAttr("ville_famille"));	
				$st->addVar("ligne","TEL"        , $fam->getAttr("num_tel_famille"));	
				
				$st->parseTemplate("ligne","a");
			}		
			$html .= $st->getParsedTemplate('FamilleListeSelect');									
		} else 
			$html .= "<br/><div>Aucune famille ne correspond &aagrave; votre crit&eagrave;re de selection...</div><br/>";
		
		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		return $html;
	}
		
	public function listeParExemplaireView() {
		$html = "";
		if($this->famille!=null) {		
			$st = new patTemplate();
			$st->setRoot("templates");			
			$st->readTemplatesFromInput("FamilleListeParExempSelect.tmpl");
			 
			$fam = $this->famille[0];			
			$st->addVar("famDepot","CLASS_DEP"      ,"listePair");
			$st->addVar("famDepot","ID_DEP"         , $fam->getAttr("num_famille"));
			$st->addVar("famDepot","NRO_DEP"        , $i++);	
			$st->addVar("famDepot","NOM_DEP"        , (strtoupper($fam->getAttr("nom_famille")). ", ".$fam->getAttr("prenom_famille")));	
			$st->addVar("famDepot","CODEPOSTAL_DEP" , $fam->getAttr("code_postal_famille"));	
			$st->addVar("famDepot","VILLE_DEP"      , $fam->getAttr("ville_famille"));	
			$st->addVar("famDepot","TEL_DEP"        , $fam->getAttr("num_tel_famille"));					
			
			$fam = (isset($this->famille[1]))?$this->famille[1]:null;			
			$st->addVar("famAchat","CLASS_ACHAT"      ,"listeImpair");
			$st->addVar("famAchat","ID_ACHAT"         , ($fam!=null)?$fam->getAttr("num_famille"):"");
			$st->addVar("famAchat","NRO_ACHAT"        , $i++);	
			$st->addVar("famAchat","NOM_ACHAT"        , ($fam!=null)?((strtoupper($fam->getAttr("nom_famille")). ", ".$fam->getAttr("prenom_famille"))):"");	
			$st->addVar("famAchat","CODEPOSTAL_ACHAT" , ($fam!=null)?$fam->getAttr("code_postal_famille"):"");	
			$st->addVar("famAchat","VILLE_ACHAT"      , ($fam!=null)?$fam->getAttr("ville_famille"):"");	
			$st->addVar("famAchat","TEL_ACHAT"        , ($fam!=null)?$fam->getAttr("num_tel_famille"):"");
								
			$html .= $st->getParsedTemplate('FamilleListeParExempSelect');									
		} else 
			$html .= "<br/><div>L'exemplaire n'existe pas. <br/>Veuillez verifier les informations fournies...</div><br/>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		return $html;
	}
		
	public function formulaireView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= $this->famille->render();		
		$html .= "	Famille: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function creerView() {	
		$html = "";		
		$html .= "<div align='center'>";		
		$html .= "	Famille Creer !!!!!!!!!!!!: <i>FormulaireView... </i><BR/>" ;						
		$html .= "</div>" ;
		
		return $html;
	}
	
	public function defaultView() {
	
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("FamilleTmpl.tmpl");				
		
		$fam = $this->famille;
		
		// Gestion Famille Section 
		$st->addVar("FamilleSelect","ACTCHER" ,($fam==null)?"":"disabled");						
		$st->addVar("FamilleSelect","ACTMOD"  ,($fam==null)?"disabled":"");		
		$st->addVar("FamilleSelect","ACTCHAM" ,"disabled");											
		$st->addVar("FamilleSelect","JVS"     ,"/ScolBoursePHP/js/FamilleAdmin.js");
		$st->addVar("FamilleSelect","NUM"     ,($fam!=null)?$fam->getAttr("num_famille"):"");
		$st->addVar("FamilleSelect","NOM"     ,($fam!=null)?$fam->getAttr("nom_famille"):"");
		$st->addVar("FamilleSelect","PRENOM"  ,($fam!=null)?$fam->getAttr("prenom_famille"):"");
		$st->addVar("FamilleSelect","ADRES1"  ,($fam!=null)?$fam->getAttr("adresse1_famille"):"");
		$st->addVar("FamilleSelect","ADRES2"  ,($fam!=null)?$fam->getAttr("adresse2_famille"):"");
		$st->addVar("FamilleSelect","CODEPO"  ,($fam!=null)?$fam->getAttr("code_postal_famille"):"");
		$st->addVar("FamilleSelect","VILLE"   ,($fam!=null)?$fam->getAttr("ville_famille"):"");
		$st->addVar("FamilleSelect","TELEPH"  ,($fam!=null)?$fam->getAttr("num_tel_famille"):"");
		$st->addVar("FamilleSelect","NOTES"   ,($fam!=null)?$fam->getAttr("indication_famille"):"");				
		$enleve = ($fam!=null)?(($fam->getAttr("enlevettfrais")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ENLEVE"  ,$enleve);		
		$adhere = ($fam!=null)?(($fam->getAttr("adherent_association")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ADHERE"  ,$adhere);
				
		$html .= $st->getParsedTemplate('FamilleTmpl'); 		
					
		return $html;
	}
/*	
	public function defaultView2() {
		// Determine le type d'utilisateur
		$estAdmin = false;						
		if($this->getAttr("user")!=null) 
		$estAdmin = ($this->getAttr("user")->getAttr("type")==BourseAuth::$ADMIN_LEVEL);
		
		$html = "";				
		
		$html .= "<h4>1° Importer une liste de familles</h4>";				
		$html .= '<form name="form1" method="post" enctype="multipart/form-data" action="/ScolBoursePHP/index.php/Famille/import">';	
		$html .= 'Vous pouvez t&eacute;l&eacute;charger un fichier de familles au format CSV. <br>';
		$html .= '<input type="file" name="fichier">&nbsp;&nbsp;<input type="submit" name="ok" value="Telecharger">';
		$html .= '</form>';	
		$html .= "<h4>2° Exporter la liste des familles</h4>";			
		$html .= '<form name="expFamille" method=post action="/ScolBoursePHP/index.php/Famille/export/csv">';	
		$html .= 'Choisissez le format d\'exportation souhaité.';
		$html .= '<table width="200">';
		$html .= '<tr>';
		$html .= '<td><label>';
        $html .= '<input type="radio" name="format" value="csv">CSV</label></td>';
        $html .= '<td><label>';
        $html .= '<input type="radio" name="format" value="sql" checked>SQL</label></td>';
		$html .= '</tr>';
		$html .= '</table>	';	
		$html .= '<br><input type="button" name="ok" value="Exporter" onclick="exporter(this.form.format);return false;">';
		$html .= "</form>";	
	
		$html .= "<h4>3° Gestion des familles</h4>";				
		
		$fam = $this->famille;
		
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("FamilleSelect.tmpl");
						
		// Section d'information sur la famille
		$st->addVar("FamilleSelect","ACTCHER" ,($fam==null)?"":"disabled");						
		$st->addVar("FamilleSelect","ACTMOD"  ,($fam==null)?"disabled":"");		
		$st->addVar("FamilleSelect","ACTCHAM" ,"disabled");
											
		$st->addVar("FamilleSelect","JVS"    ,"/ScolBoursePHP/js/FamilleAdmin.js");
		$st->addVar("FamilleSelect","NUM"    ,($fam!=null)?$fam->getAttr("num_famille"):"");
		$st->addVar("FamilleSelect","NOM"    ,($fam!=null)?$fam->getAttr("nom_famille"):"");
		$st->addVar("FamilleSelect","PRENOM" ,($fam!=null)?$fam->getAttr("prenom_famille"):"");
		$st->addVar("FamilleSelect","ADRES1" ,($fam!=null)?$fam->getAttr("adresse1_famille"):"");
		$st->addVar("FamilleSelect","ADRES2" ,($fam!=null)?$fam->getAttr("adresse2_famille"):"");
		$st->addVar("FamilleSelect","CODEPO" ,($fam!=null)?$fam->getAttr("code_postal_famille"):"");
		$st->addVar("FamilleSelect","VILLE"  ,($fam!=null)?$fam->getAttr("ville_famille"):"");
		$st->addVar("FamilleSelect","TELEPH" ,($fam!=null)?$fam->getAttr("num_tel_famille"):"");
		$st->addVar("FamilleSelect","NOTES"  ,($fam!=null)?$fam->getAttr("indication_famille"):"");
					
		$enleve = ($fam!=null)?(($fam->getAttr("enlevettfrais")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ENLEVE" ,$enleve);		
		$adhere = ($fam!=null)?(($fam->getAttr("adherent_association")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ADHERE" ,$adhere);
		
		$html .= $st->getParsedTemplate('FamilleSelect');  
					
		return $html;
	}
*/
	public function okView() {
		$html = "";				
		$html .= "<div>";		
		$html .= "	<BR/>".$this->famille."<BR/>";
		$html .= "	<a href='/ScolBoursePHP/index.php/Famille/' target='_self'>Retour</a><BR/>";
		$html .= "</div>" ;		
		return $html;
	}
	
	public function importerView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ImporterTmpl.tmpl");
		
		$st->addVar("ImporterTmpl","MODULE"  ,"Famille");						
		$st->addVar("ImporterTmpl","MESSAGE" ,($this->famille!=null)?$this->famille:"");		
		$html .= $st->getParsedTemplate('ImporterTmpl');  
		
		return $html;
	}
	
	public function exporterView() {
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("ExporterTmpl.tmpl");
		
		$st->addVar("ExporterTmpl","MODULE"  ,"Famille");						
		$st->addVar("ExporterTmpl","MESSAGE" ,($this->famille!=null)?$this->famille:"export ? de quoi ???");
		$fichier = (isset($_SESSION["fichier"]))?$_SESSION["fichier"]:"";
		$st->addVar("ExporterTmpl","FICHIER" , "/ScolBoursePHP/".$fichier);		
		$st->addVar("ExporterTmpl","RETOUR","/ScolBoursePHP/index.php/Famille");		
		$html .= $st->getParsedTemplate('ExporterTmpl');  
		return $html;
		
		
	}

}
?>
