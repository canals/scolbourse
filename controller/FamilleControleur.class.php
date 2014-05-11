<?php

session_start();

/**
* controller.FamilleControleur.class.php : classe qui represente le controleur des Familles de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class FamilleControleur extends AbstractControleur {

	public static $MNU_ID = "mnuFamille";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$famille = Famille::findById($oid);
		
		// Afficher le result
		$view = new FamilleView($famille,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
		$familles = Famille::findAll();
		
		// Afficher le result
		$view = new FamilleView($familles,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {		
		switch ($this->action) {		
			// Operations
			case "creer" : { $this->frmCreerAction() ; break; }						
					
			case "import" : { $this->importerAction() ; break; }	
			case "export" : { $this->exporterAction() ; break; }
			
			case "listeParDossier"    : { $this->listeParDossierAction() ; break; }
			case "listeParNom"        : { $this->listeParNomAction() ; break; }
			case "listeParTel"        : { $this->listeParTelAction() ; break; }			
			case "listeParExemplaire" : { $this->listeParExemplaireAction() ; break; }					
			
			default         : { $this->mnuAction() ; }
		} 
	}	
	
	public function mnuAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;		
		$famille = Famille::findById($oid);	
		// Afficher le result
		$view = new FamilleView($famille,"mnuAction");
		$view->display ();	 
	}
	
	public function listeParDossierAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$famille = Famille::findByNumDossier($oid);		
		$view = new FamilleView($famille,"liste");
		$view->display();		 
	}
	
	public function listeParNomAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$famille = Famille::findByNom($oid);		
		$view = new FamilleView($famille,"liste");
		$view->display();		 
	}
	
	public function listeParTelAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$famille = Famille::findByNumTelephone($oid);		
		$view = new FamilleView($famille,"liste");
		$view->display();		 
	}
	
	public function listeParExemplaireAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$exemp = Exemplaire::findById($oid);
		$allFam=null;
		if($exemp!=null) {			
			$famille = Famille::findById($exemp->getAttr("num_dossier_depot"));				
			$allFam[] = $famille;			
			if($exemp->getAttr("num_dossier_achat")!=null){
				$famille = Famille::findById($exemp->getAttr("num_dossier_achat"));				
				$allFam[] = $famille;
			}
		}
		$view = new FamilleView($allFam,"listeParExemplaire");
		$view->display();		 	 
	}
	
	public function frmCreerAction() {			
			//on verifie que les champs ne soient pas vides			
			if($_POST['adherent_association']=='on') $ad = 'o';
			else $ad = 'n';
			
			if($_POST['enlevettfrais']=='on') $frais = 'o';
			else $frais = 'n';			
			
			//il faut regarder si la famille existe deja alors on la modifie
			if($_POST['num_famille']!='') $fam = Famille::findById($_POST['num_famille']);
			else $fam = new Famille();
			
			$fam->setAttr(nom_famille, $_POST['nom_famille']);
			$fam->setAttr(prenom_famille,$_POST['prenom_famille']);
			$fam->setAttr(num_tel_famille,$_POST['num_tel_famille']);
                        $fam->setAttr(mail_famille,$_POST['mail_famille']);
			$fam->setAttr(ville_famille,$_POST['ville_famille']);
			$fam->setAttr(code_postal_famille,$_POST['code_postal_famille']);
			$fam->setAttr(adresse1_famille, $_POST['adresse1_famille']);
			$fam->setAttr(adresse2_famille,$_POST['adresse2_famille']);			
			$fam->setAttr(adherent_association,$ad);
			$fam->setAttr(enlevettfrais,$frais);
			$fam->setAttr(indication_famille,strip_tags($_POST['indication_famille']));
			
			$fam->save();
                        var_dump($fam);
						
			$auth = new BourseAuth();
			$user = $auth->getUserProfile();
			try {
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
				// L'utilisateur est l'administrateur.
				header('Location: /ScolBoursePHP/index.php/Famille/voir/'.$fam->getAttr('num_famille'));
			} catch(AuthException $a) {
				// L'utilisateur est un Benevole. 
				header('Location: /ScolBoursePHP/index.php/'.$fam->getAttr('num_famille'));
			} 

	}

	public function importerAction() {
		// Verifier le niveau d'access
		try {
			$auth = new BourseAuth() ;
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
		} catch(AuthException $a) {
			$mode = "ERREUR"; 
			$titre = "[Acc&egrave;s restreint]"; 
			$retour = "";							
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display (); 
			exit;
		}
		//on regarde si c'est un fichier csv ou un fichier sql
		$fichier = $_FILES['fichier']['name'];
		if(substr($fichier,-3) == "csv"){
			$message = $this->insertIntoTableCSV();
		} else if(substr($fichier,-3) == "csv"){
			$message = "AAAHH Noooon ! Que du CSV !";
		}
		$view = new FamilleView($message ,"importerView");
		$view->display ();
	}	
	
	public function exporterAction() {
		// Verifier le niveau d'access
		try {
			$auth = new BourseAuth() ;
			$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
		} catch(AuthException $a) {
			$mode = "ERREUR"; 
			$titre = "[Acc&egrave;s restreint]"; 
			$retour = "";							
			$v = new MessageView($titre, $a->getMessage(), $mode, $retour);
			$v->display (); 
			exit;
		}
		$format = ($this->valeur!=null) ? $this->valeur : 'csv' ;				
		//on regarde si c'est un fichier csv ou un fichier sql
		if($format=='csv'){
			$content= $_POST['content'];
			$fname = "export/export_famille_".date("dmy").".csv";
			$e=$this->exporterCSV($content, $fname); 		
			if ($e) {
				$message = "Export de la liste de famille dans le fichier $fname";
				$_SESSION["fichier"]=$fname;
		    } else {
				$message = "Export impossible : liste vide ou probleme ecriture dans le fichier $fname";
			}	
		$view = new FamilleView($message ,"exporterView");
		$view->display (); 
		} else {

			$mode = "ERREUR"; 
			$titre = "[export impossible]"; 
			$retour = "/ScolBoursePHP/index.php/Famille";							
			$v = new MessageView($titre, "Ouuupss : un format d'export imprevu !", $mode, $retour);
			$v->display (); 
            	 		
		}		
	}
	
	private function insertIntoTableSQL() {
		try{
			$query=file_get_contents($_FILES['fichier']['tmp_name']); 			
			$query = str_replace("'\''", "''", $query);
			$query = str_replace("''''", "''", $query);
						
			$dbres = Base::doUpdate($query);
			$message = "L'importation du fichier a &eacute;t&eacute; bien execut&eacute;e.";
		} catch(BaseException $e){
			$message = "Erreur pendant l'importation de donn&eacute;es.<br/><br/>Causes possibles:";
			$message .= "<br/><ul>";
			$message .= "<li><i>- Les donn&eacute;es existent d&eacute;j&agrave;</i></li>";
			$message .= "<li><i>- Vous avez import&eacute; un fichier incorrect !</i></li>";
			$message .= "</ul>";
		}
		return $message;	
	}	

	private function insertIntoTableCSV() {
		$file = fopen( $_FILES['fichier']['tmp_name'], 'r' );
		// on passe la premi�re ligne, qui contient les titres de colonnes
		$row = fgetcsv($file, 1024, ";", "\"");
		
		$k = 1;	
		$message = "";	$erreur=false;	
		while ( ! feof( $file ) ){
			$k++;
			$row = fgetcsv( $file, 1024, ";", "\"" );
                        if (count($row) == 0) break;
			if (count($row) <8) {
				$message .="Erreur sur la ligne $k : colonne manquante (ligne non import�e)<br/>";
				$erreur=true;
			} else {
				// on traite la ligne : cr�er la famille et ins�rer
					$m= new Famille();
					$m->setAttr("nom_famille", $row[0]);
					$m->setAttr("prenom_famille", $row[1]);
					$m->setAttr("adresse1_famille", $row[2]);
					$m->setAttr("adresse2_famille", $row[3]);
					$m->setAttr("code_postal_famille", $row[4]);
					$m->setAttr("ville_famille", $row[5]);
					$m->setAttr("num_tel_famille", $row[6]);
                                        $m->setAttr("mail_famille", $row[7]);
					try {
						$m->save();
						$message .= "famille $row[0] ajoute dans la base <br/>";
					}catch (BaseException $b) {
						$message.= "Erreur sur la ligne $k : insertion base impossible (valeur incorrecte)<br/>";
						$erreur=true;
					}
				}
		}		

		if( !$erreur)
			$message .= "<br/><h4>Importation complete : aucune erreur</h4>";
		else
			$message = "<h4>Importation incomplete : erreurs detectes :</h4><br/>".$message;
		
		return $message;
	}	
	
		
			
	private function exporterCSV($content, $fname){
	if ($content == 1) 	$lf = Famille::findAll();
	if ($content == 0) 	$lf = Famille::findAllParticipe();
	if (is_null($lf)) return (FALSE);
	$f = fopen ($fname, 'w+');
	if (! $f) return (FALSE) ;
	$csv_delim=";"; $csv_enclose="\"";
	$ligne=array("nom_famille","prenom_famille","adresse1_famille","adresse2_famille","code_postal_famille","ville_famille","num_tel_famille", 'mail_famille');
	fputcsv($f, $ligne, $csv_delim, $csv_enclose);
	foreach ($lf as $fm) {
		$nom = $fm->getAttr('nom_famille');
		$prenom = $fm->getAttr('prenom_famille');
		$adr1= $fm->getAttr('adresse1_famille');
		$adr2= $fm->getAttr('adresse2_famille');
		$code=$fm->getAttr('code_postal_famille');
		$ville=$fm->getAttr('ville_famille');
		$tel=$fm->getAttr('num_tel_famille');
                $mail=$fm->getAttr('mail_famille');
		$ligne=array($nom,$prenom,$adr1,$adr2,$code,$ville,$tel,$mail);
		fputcsv($f, $ligne, $csv_delim, $csv_enclose);
	}
	fclose($f);
	return (5);
	}
		
	private function dumpMySQL($serveur, $login, $password, $base, $mode){
		$connexion = mysql_connect($serveur, $login, $password);
		mysql_select_db($base, $connexion); 

		$insertions = "";
		// si l'utilisateur a demand� les donn&eacute;es 
		if($mode > 1) {
			$donnees = mysql_query("SELECT * FROM famille");			
			
			//regarder si la table est vide ou non 
			if(mysql_num_rows($donnees)==0) 
				$insertions .= "INSERT INTO famille VALUES (),";
			else 
				$insertions .= "INSERT INTO famille VALUES (";
			
			$comp=0;
			while($nuplet = mysql_fetch_array($donnees)) {
				if($comp!=0)
					$insertions .=  "(";
				for($i=0; $i < mysql_num_fields($donnees); $i++){
					if($i != 0)
						$insertions .=  ", ";
					if(mysql_field_type($donnees, $i) == "string" || mysql_field_type($donnees, $i) == "blob")
						$insertions .=  "'";
					$insertions .= addslashes($nuplet[$i]);
					if($nuplet[$i]=='')
						$insertions .=  "";			
					if(mysql_field_type($donnees, $i) == "string" || mysql_field_type($donnees, $i) == "blob")
						$insertions .=  "'";
				}
				$insertions .=  "),";
				$comp = $comp +1;
			}
			//supprimer le derniere caractere
			$insertions2 = substr($insertions, 0, strlen($insertions)-1);
			$insertions2 .= ";";
					
			$insertions2 = str_replace("'\''", "''", $insertions2);
			$insertions2 = str_replace("''''", "''", $insertions2);
			
			
			$fichierDump = fopen("./autres/sql/sauvegarde/SauvegardeFamille.sql", "w+");
			fwrite($fichierDump, $insertions2);
			fclose($fichierDump);
			$insertions="";
		}
		mysql_close($connexion);	 
	}
	
}

?>
