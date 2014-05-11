<?php

session_start();

/**
 * view.HomeView.class.php : classe qui permet faire les views des Homes de l'application
 *
 * @author JARNAUX Noemie
 * @author COURTOIS Gillaume
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 *
 * @package view
**/

class HomeView {

	private $home;		
	
	private $mode;
	
	/**
	* @access private
	* @var user 
	* User courante de l'application (SESSION)
	*/
	private $user;
	
	// Constructeur de la view
	public function __construct($o, $m) {
		$this->home = $o;
		$this->mode = $m;			
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();		
	}
	
	/**
	*   Getter g&eacute;n&eacute;rique
	*
	*   fonction d'acc&eacute;s aux attributs d'un home.
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
	*   fonction de modification des attributs d'un home.
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
			case "auth": {
				$titre = "ScolBourse - Bienvenue!!!"; 
				$content = $this->authenticationView(); 
			} break;
			
			case "admin": {
				$titre = "ScolBourse - Bienvenue!!!"; 
				$content = $this->homeAdminView(); 
			} break;
			
			case "user": {
				$titre = "ScolBourse - Bienvenue!!!"; 
				$content = $this->homeUserView();
			} break;							
						 
		}		
		$mv = new MainView();		
		$mv->addTitre($titre); 		
		$mv->addMenu(null);				
		$mv->addContenu($content);
		$mv->render(); 			
	}
	
	public function authenticationView() {
		
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("authTmpl.tmpl");
		
		return $st->getParsedTemplate('authTmpl');  	
	}
	
	
	public function homeAdminView() {
		$html ="";		
		$html .= "<div>"."\n";
		$html .= "	<p>Espace de parametrage et d'administration de l'application ScolBourse</p> <br/><br/>\n";
		$html .= " <p>ScolBourse Copyright (C) 2007-2008-2009 - <br/> No�mie Jarnoux ; Luis Sustaita ; 
                                 Guillaume Courtois ; Ronel Rivas ; 
								 G�r�me Canals - Tous droits r�serv�s. <br/><br/>
                   Ce programme vient SANS ABSOLUMENT AUCUNE GARANTIE ; <br/>
				   Ceci est un logiciel libre et vous �tes invit� � le redistribuer
  suivant certaines conditions ; </p>";
        $html .= "<p><a href=\"/ScolBoursePHP/licence.txt\"> Voir la licence </a></p>";
		
		$html .= "</div>"."\n";		
		return $html; 			
	}
	
	
	public function homeUserView() {
		$fam = $this->home;
				
		$st = new patTemplate();
		$st->setRoot("templates");			
		$st->readTemplatesFromInput("BourseTmpl.tmpl");
						
		/*** Section d'information sur la famille ***/
		$st->addVar("FamilleSelect","ACTCHER" ,($fam==null)?"":"disabled");						
		$st->addVar("FamilleSelect","ACTMOD"  ,($fam==null)?"disabled":"");		
		$st->addVar("FamilleSelect","ACTCHAM" ,"disabled");
		
		$st->addVar("FamilleSelect","JVS" ,"/ScolBoursePHP/js/FamilleChercher.js");
											
		$st->addVar("FamilleSelect","NUM"    ,($fam!=null)?$fam->getAttr("num_famille"):"");
		$st->addVar("FamilleSelect","NOM"    ,($fam!=null)?$fam->getAttr("nom_famille"):"");
		$st->addVar("FamilleSelect","PRENOM" ,($fam!=null)?$fam->getAttr("prenom_famille"):"");
		$st->addVar("FamilleSelect","ADRES1" ,($fam!=null)?$fam->getAttr("adresse1_famille"):"");
		$st->addVar("FamilleSelect","ADRES2" ,($fam!=null)?$fam->getAttr("adresse2_famille"):"");
		$st->addVar("FamilleSelect","CODEPO" ,($fam!=null)?$fam->getAttr("code_postal_famille"):"");
		$st->addVar("FamilleSelect","VILLE"  ,($fam!=null)?$fam->getAttr("ville_famille"):"");
		$st->addVar("FamilleSelect","TELEPH" ,($fam!=null)?$fam->getAttr("num_tel_famille"):"");
                $st->addVar("FamilleSelect","MAIL"   ,($fam!=null)?$fam->getAttr("mail_famille"):"");
		$st->addVar("FamilleSelect","NOTES"  ,($fam!=null)?$fam->getAttr("indication_famille"):"");
					
		$enleve = ($fam!=null)?(($fam->getAttr("enlevettfrais")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ENLEVE" ,$enleve);		
		$adhere = ($fam!=null)?(($fam->getAttr("adherent_association")=="o")?"checked":""):"";
		$st->addVar("FamilleSelect","ADHERE" ,$adhere);
				
		/*** Etablir le pane active ***/
		if($fam==null) 
			unset($_SESSION["tabActive"]);
		
		$st->addVar("BourseTmpl","TAB_ACTIVE" , (isset($_SESSION["tabActive"]))?$_SESSION["tabActive"]:"tabDepot");		
		$st->addVar("BourseTmpl","PNL_ACTIVE" , (isset($_SESSION["tabActive"]))?"'".$_SESSION["tabActive"]."'":"null");
		/***********************/
				
		/*** Section pour les Depots ***/	
		$st->addVar("DepotTmpl","ACTCHER" ,($fam!=null)?"":"disabled");								
		$st->addVar("AchatTmpl","ACTCHER" ,($fam!=null)?"":"disabled");	

		if($fam!=null) {
			/*** Section pour les Depots ***/											
			$dossierDeDepot = $fam->getAttr("dossierDeDepot");	
			$st->addVar("DepotTmpl","NUM_FAMILLE" , ($fam!=null)?$fam->getAttr("num_famille"):"");				
			if($dossierDeDepot!=null) {			
						
				// Ajouter les exempaires				
				$exemplaires = $dossierDeDepot->getAttr("exemplaires");
				$select = (count($exemplaires)>0)?"default":"empty";
				$st->addVar("detailDepot","SELECT" , $select);				
				
				$i=1;	$sub_total = 0.0;	
				if($exemplaires != null) {
					foreach($exemplaires as $ex) {
						$man = Manuel::findById($ex->getAttr("code_manuel"));
						$etat = Etat::findById($ex->getAttr("code_etat"));
						$determine = Determine::findById($etat->getAttr("code_etat"), $man->getAttr("code_manuel"));
						
						$st->addVar("ligneDepot","CLASS" , ($i%2==0)?"listePair":"listeImpair");			
						$st->addVar("ligneDepot","NRO"   , $i++);
						
						$st->addVar("ligneDepot","CODE_MANUEL"     , $man->getAttr("code_manuel"));
						$st->addVar("ligneDepot","CODE_EXEMPLAIRE" , $ex->getAttr("code_exemplaire"));
						$st->addVar("ligneDepot","TITRE"           , $man->getAttr("titre_manuel"));
						$st->addVar("ligneDepot","MATIERE"         , $man->getAttr("matiere_manuel"));
						$st->addVar("ligneDepot","ETAT"            , strtoupper($etat->getAttr("libelle_etat")));
						$st->addVar("ligneDepot","TARIF"           , floatval($determine->getAttr("tarif")));
						
						switch($ex->getAttr("vendu")) {
							case Exemplaire::VENDU: { $vendu = "&radic;"; } break;
							case Exemplaire::RENDRE: { $vendu = "&reg;"; } break;
							default: $vendu = "";
						}
						
						$st->addVar("ligneDepot","VENDU"           , $vendu);
						$sub_total += floatval($determine->getAttr("tarif"));
					
						$st->parseTemplate("ligneDepot","a");
					}	
				}
				$st->addVar("detailDepot","MONTANT_LIVRE"  , $sub_total);
				
				$enlever = ($dossierDeDepot->getAttr("enlevefraisenv_depot")=="o")?"checked":"";											
				$st->addVar("DepotTmpl","LIVRES_DEPOSEES", count($dossierDeDepot->getAttr("exemplaires")));
				$st->addVar("DepotTmpl","MONTANT_LIVRE"  , $sub_total);
				$st->addVar("DepotTmpl","LIVRES_AJOUTES" , 0);
				$st->addVar("DepotTmpl","FRAIS_DOSSIER"  , (($fam->getAttr("enlevettfrais")!="o")?$dossierDeDepot->getAttr("frais_dossier_depot"):0.0));
				$st->addVar("DepotTmpl","FRAIS_ENVOI"    , (($dossierDeDepot->getAttr("enlevefraisenv_depot")!="o")?$dossierDeDepot->getAttr("frais_envoi_depot"):0.0));
				$st->addVar("DepotTmpl","MONTANT_VENTES" , $dossierDeDepot->getAttr("montant_livre_depose_vendu"));				
				$st->addVar("DepotTmpl","ENLEVER_FRAIS"  , $enlever);
				
				$totalDepot =  $dossierDeDepot->getAttr("montant_livre_depose_vendu");				
				$totalDepot -= ($dossierDeDepot->getAttr("enlevefraisenv_depot")!="o")?$dossierDeDepot->getAttr("frais_envoi_depot"):0.0;				
				$totalDepot -= ($fam->getAttr("enlevettfrais")!="o")?$dossierDeDepot->getAttr("frais_dossier_depot"):0.0;
								
				$st->addVar("DepotTmpl","MONTANT_TOTAL"  , ($totalDepot>=0)?$totalDepot:0.0);				
			}
						
			/*** Section pour les Achats ***/											
			$dossierDAchat = $fam->getAttr("dossierDAchat");
			$st->addVar("AchatTmpl","NUM_FAMILLE" , ($fam!=null)?$fam->getAttr("num_famille"):"");			
			if($dossierDAchat!=null) {
			
				$exemplaires = $dossierDAchat->getAttr("exemplaires");
				$select = (count($exemplaires)>0)?"default":"empty";
				$st->addVar("detailAchat","SELECT" , $select);
											
				// Ajouter les exempaires
				$i=1;
				$sub_total = 0.0;
				$allEx = $dossierDAchat->getAttr("exemplaires");
				if($allEx != null) {
					foreach($allEx as $ex) {
						$man = Manuel::findById($ex->getAttr("code_manuel"));
						$etat = Etat::findById($ex->getAttr("code_etat"));
						$determine = Determine::findById($etat->getAttr("code_etat"), $man->getAttr("code_manuel"));					
						$st->addVar("ligneAchat","CLASS" , ($i%2==0)?"listePair":"listeImpair");			
						$st->addVar("ligneAchat","NRO"   , $i++);					
						$st->addVar("ligneAchat","CODE_EXEMPLAIRE" , $ex->getAttr("code_exemplaire"));
						$st->addVar("ligneAchat","TITRE"           , $man->getAttr("titre_manuel"));
						$st->addVar("ligneAchat","MATIERE"         , $man->getAttr("matiere_manuel"));
						$st->addVar("ligneAchat","ETAT"            , strtoupper($etat->getAttr("libelle_etat")));
						$st->addVar("ligneAchat","TARIF"           , $determine->getAttr("tarif"));														
						$st->parseTemplate("ligneAchat","a");
						
						$sub_total += floatval($determine->getAttr("tarif"));
					}
				}
				$st->addVar("detailAchat","MONTANT_LIVRE"  , $sub_total);
				
				//Ajouter les reglements
				$reglements = Reglement::findAll();
				$htmlRegles = "";
				$htmlRegles .= "<select name='modePaiment' id='modePaiment' " . $select . " {ACTCHERR}>"."\n";
				$htmlRegles .= "<option value='0'>Mode de paiment</option>"."\n";
				foreach($reglements as $regle) {
					$htmlRegles .= "<option value='".$regle->getAttr("code_reglement")."'>";
					$htmlRegles .= $regle->getAttr("mode_reglement")."</option>"."\n";
				}
				$htmlRegles .= "</select>"."\n";			
				$st->addVar("AchatTmpl","REGLEMENTS", $htmlRegles);
				// Trouver les reglements efectu&eacute;es par la famille				
				$totalPayee = 0.0;
				$regles = Regle::findByNumDossierAchat($dossierDAchat->getAttr("num_dossier_achat"));
				if($regles!=null) {	
					$i=1;			
					foreach($regles as $regle) {				
						$reglement = Reglement::findById($regle->getAttr("code_reglement"));						
						$totalPayee += round(floatval($regle->getAttr("montant")),2);
						
						$st->addVar("ligneRegle","CLASS" , ($i%2==0)?"listePair":"listeImpair");			
						$st->addVar("ligneRegle","NUM" , $i);
						$st->addVar("ligneRegle","NUM_REGLE" , $regle->getAttr("num_regle"));
						$st->addVar("ligneRegle","DATE_PAIMENT" , substr($regle->getAttr("datereg"),1,10));
						$st->addVar("ligneRegle","MODE_PAIMENT" , $reglement->getAttr("mode_reglement"));
						$st->addVar("ligneRegle","MONTANT"      , floatval($regle->getAttr("montant")));
						$st->addVar("ligneRegle","CHEQUE_INFO"  , $regle->getAttr("numero_cheque"));
	
						$st->parseTemplate("ligneRegle","a");					
						$i++;
					}
				}
				
				$total_payer = round(floatval($dossierDAchat->getAttr("frais_dossier_achat")) + floatval($dossierDAchat->getAttr("montant_livre_achete")),2);
				$difference = round(floatval($total_payer) - floatval($totalPayee),2);
				
				$st->addVar("AchatTmpl","LIVRES_ACHETES", count($dossierDAchat->getAttr("exemplaires")));
				$st->addVar("AchatTmpl","MONTANT_LIVRE" , floatval($dossierDAchat->getAttr("montant_livre_achete")));
				$st->addVar("AchatTmpl","FRAIS_DOSSIER" , (($fam->getAttr("enlevettfrais")=="o")?"0.0":$dossierDAchat->getAttr("frais_dossier_achat")));				
				$st->addVar("AchatTmpl","TOTAL_PAYEE"   , $totalPayee);
				$st->addVar("AchatTmpl","TOTAL_PAYER"   , $total_payer);
				$st->addVar("AchatTmpl","DIFFERENCE"   , $difference);
				
				// Activer o deactiver les reglements
				$st->addVar("AchatTmpl","ACTCHERR" ,(($select=="empty")||($difference<=0))?"disabled":"");	
			} else {
				//Ajouter les reglements
				$htmlRegles = "";
				$htmlRegles .= "<select name='modePaiment' id='modePaiment' disabled >"."\n";
				$htmlRegles .= "<option value='0'>Mode de paiment</option>"."\n";				
				$htmlRegles .= "</select>"."\n";			
				$st->addVar("AchatTmpl","REGLEMENTS", $htmlRegles);				
				$st->addVar("AchatTmpl","ACTCHERR" ,"disabled");
			} 			
		}else {
			//Ajouter les reglements
			$htmlRegles = "";
			$htmlRegles .= "<select name='modePaiment' id='modePaiment' disabled >"."\n";
			$htmlRegles .= "<option value='0'>Mode de paiment</option>"."\n";				
			$htmlRegles .= "</select>"."\n";			
			$st->addVar("AchatTmpl","REGLEMENTS", $htmlRegles);
			$st->addVar("AchatTmpl","ACTCHERR" ,"disabled");
		} 		 		
		return $st->getParsedTemplate('BourseTmpl');  
	}
 
}
?>
