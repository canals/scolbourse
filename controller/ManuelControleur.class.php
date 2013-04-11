<?php

session_start();

/**
* controller.ManuelControleur.class.php : classe qui represente le controleur des Manuels de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class ManuelControleur extends AbstractControleur {

	public static $MNU_ID = "mnuManuel";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$manuel = Manuel::findById($oid);
		
		// Afficher le result
		$view = new ManuelView($manuel,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
		$manuel = Manuel::findAll();
		
		// Afficher le result
		$view = new ManuelView($manuel,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations			
			case "voirDetail" : { $this->voirDetailAction() ; break; }

			case "creer" : { $this->frmCreerAction() ; break; }						
			case "creerliste" : { $this->creerListeAction() ; break; }
			
			case "import"     : { $this->importerAction() ; break; }		
			case "export"     : { $this->exporterAction() ; break; }			
			
			case "listeDetail"     : { $this->listeDetail() ; break; }				
			case "listeParEdit"    : { $this->listeParEditeurAction() ; break; }
			case "listeParCode"    : { $this->listeParCodeAction() ; break; }
			case "listeParMatiere" : { $this->listeParMatiereAction() ; break; }	
			case "listeParNom"     : { $this->listeParNomAction() ; break; }
                        case "calculerTarifs"  : { $this->calculerTarifsAction(); break;}						
			
			default         : { $this->mnuAction() ; }
		} 
	}	
	
	public function calculerTarifsAction() {
	     $mess .= "<strong>calcul des tarifs occasion</strong><br/>";
         $mans = Manuel::findAll(); if (empty($mans)) {$mess .= "pas de manuels dans la base";}
         $etats= Etat::findAll();if (empty($etats)) {$mess .=  "pas d' etats dans la base"; }
	     if ($mans AND $etats) {
		 foreach ($mans as $man) {
            $mess .= $man->getattr('code_manuel').' ::: ';
            foreach ($etats as $etat) {
                $tarif = $man->getattr('tarif_neuf_manuel') * $etat->getattr('pourcentage_etat');
                $tarif = round($tarif/100 , 2);
                $mess .= '('.$etat->getattr('code_etat').')'. $tarif .'€ - ';
                $d = Determine::findById($etat->getattr('code_etat'),$man->getattr('code_manuel') );
                if (!empty($d)) {
                    $d->setattr('tarif', $tarif);
                    $d->save();
                } else {
                    $d = new Determine() ; 
                    $d->setattr('code_manuel', $man->getattr('code_manuel') );
                    $d->setattr('code_etat', $etat->getattr('code_etat') );
                    $d->setattr('tarif', $tarif);
                    $d->insert() ;
                }
            }
            $mess .=  "-- OK <br/>";
         }}
		 $mode = "OK"; 
			$titre = "[Calcul des tarifs occasion]"; 
			$retour = "/ScolBoursePHP/index.php/Manuel";							
			$v = new MessageView($titre, $mess, $mode, $retour);
			$v->display (); 
    }

	public function mnuAction() {		
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

		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;		
		$manuel = Manuel::findById($oid);	
		
		// Afficher le result
		$view = new ManuelView($manuel,"mnuAction");
		$view->display ();		 
	}	
	
	 
	public function creerListeAction() {		
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
		
		$list = new Liste();
		$list->setAttr(libelle_liste,$_POST['libelle_liste']);
		$list->setAttr(classe_liste,$_POST['classe_liste']);

		$list->save();
		header('Location:/ScolBoursePHP/index.php/Manuel/');			
	}	
	
	public function voirDetailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$manuel = Manuel::findById($oid);		
		// Afficher le result
		$view = new ManuelView($manuel,"voirDetail");
		$view->display ();				
	}
	
	public function listeParEditeurAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;			
		$manuels = Manuel::findByEditeur($oid);		
		$view = new ManuelView($manuels,"liste");
		$view->display();	 
	}
	
	public function listeParCodeAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$manuels = Manuel::findByCode($oid);		
		$view = new ManuelView($manuels,"liste");
		$view->display();		 
	}
	
	public function listeParMatiereAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$manuels = Manuel::findByMatiere($oid);		
		$view = new ManuelView($manuels,"liste");
		$view->display();		 
	}	
	
	public function listeParNomAction() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;					
		$manuels = Manuel::findByTitre($oid);		
		$view = new ManuelView($manuels,"liste");
		$view->display();		
	}	
	
	public function listeDetail() {
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$liste = Liste::findById($oid);
		
		// Afficher le result
		$view = new ManuelView($liste,"detail");
		$view->display ();		 
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
		} else { //if(substr($fichier,-3) == "csv"){
			$message = "Aahh nooon ! que du CSV"; //$this->insertIntoTableCSV();
		}
		$view = new ManuelView($message ,"importerView");
		$view->display ();		
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
		$liste = $_POST['imp_liste_manuel'];
		//on lit la 1ere liste pour voir si ya des titres de colonnes 
		$row = fgetcsv($file, 1024, ";", "\"");
		
		$k = 1;	
		$message = "";		
		while ( ! feof( $file ) ){
			$k++;
			$row = fgetcsv( $file, 1024, ";", "\"" );
			if (count($row) <10) {
				$message .="Erreur sur la ligne $k : colonne manquante (ligne non importée)<br/>";
			} else {
				// on traite la ligne : créer le manuel s'il n'existe pas 
				// lier à la liste
				if (is_null(Manuel::findById($row[1])) ) {
					$m= new Manuel();
					$m->setAttr("code_manuel", $row[1]);
					$m->setAttr("titre_manuel", $row[2]);
					$m->setAttr("matiere_manuel", $row[3]);
					$m->setAttr("classe_manuel", $row[7]);
					$m->setAttr("editeur_manuel", $row[4]);
					$m->setAttr("date_edition_manuel", $row[5]);
					$m->setAttr("tarif_neuf_manuel", $row[6]);			
					$m->setAttr("dispo_occasion_manuel", $row[8]);			
					$m->setAttr("dispo_neuf_manuel", $row[9]);
					try {
						$m->insert();
						$message .= "manuel $row[1] ajoute dans la base <br/>";
					}catch (BaseException $b) {
						$message.= "Erreur sur la ligne $k : insertion base impossible (valeur incorrecte)<br/>";
					}
				} else {
					$message .= "ligne $k ignoree : manuel deja present dans la base <br/>";
				}
				if (is_null( ListeManuel::findById($row[1], $liste ))) {
					$o = new ListeManuel();
					$o->setAttr("code_manuel", $row[1]);
					$o->setAttr("code_liste", $liste);
					$o->setAttr("num_manuel_liste", $row[0]);
					try {
						$o->insert();
						$message.= "manuel $row[1] ajoute a la liste $liste <br/>";
					}catch (BaseException $b) {
						$message.= "Erreur sur la ligne $k : ajout liste impossible (propabblement déjà ajoutée)<br/>";
					}
				} else {
					$message .= "ligne $k  : manuel deja present dans la liste <br/>";
				}
			}
		}		

		if($message=="")
			$message .= "<h4>Importation complete : aucune erreur</h4>h4>";
		else
			$message = "<h4>Importation incomplete : erreurs detectes :</h4><br/>".$message;
		
		return $message;
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
		$format = ($this->valeur!=null) ? $this->valeur : 0 ;				
		//on regarde si c'est un fichier csv ou un fichier sql
	
		if($format=='csv'){
			$liste = $_POST['imp_liste_manuel'];
			$fname = "export/export_liste_manuels_".$liste."_".date("dmy").".csv";	
			$e=$this->exporterCSV($liste, $fname);
			if ($e) {
			  $message = "Export de la liste de manuels liste $liste dans le fichier $fname";
		      $_SESSION["fichier"]=$fname;
		    } else {
			  $message = "Export impossible : liste vide ou probleme ecriture dans le fichier $fname";
			}
			$view = new ManuelView($message ,"exporterView");
			$view->display (); 
					 		
		} else {

			$mode = "ERREUR"; 
			$titre = "[export impossible]"; 
			$retour = "/ScolBoursePHP/index.php/Manuel";							
			$v = new MessageView($titre, "Ouuupss : un format d'export imprevu !", $mode, $retour);
			$v->display (); 
            	 		
		}	

	}	
		
	private function exporterCSV($liste, $fname){
	$lm = ListeManuel::findByCodeListe($liste);
	if (is_null($lm)) return (FALSE);
	$f = fopen ($fname, 'w+');
	if (! $f) return (FALSE) ;
	$csv_delim=";"; $csv_enclose="\"";
	$ligne=array("ordre","code","Titre","Matiere","Editeur","Edition","Tarif neuf","Classe","occasion","neuf");
	fputcsv($f, $ligne, $csv_delim, $csv_enclose);
	foreach ($lm as $m) {
		$ordre = $m->getAttr('num_manuel_liste');
		$manuel= Manuel::findById($m->getAttr('code_manuel'));
		$code = $manuel->getAttr('code_manuel');
		$titre= $manuel->getAttr('titre_manuel');
		$matiere=$manuel->getAttr('matiere_manuel');
		$editeur=$manuel->getAttr('editeur_manuel');
		$edition=$manuel->getAttr('date_edition_manuel');
		$tarif=$manuel->getAttr('tarif_neuf_manuel');
		$classe=$manuel->getAttr('classe_manuel');
		$occasion=$manuel->getAttr('dispo_occasion_manuel');
		$neuf=$manuel->getAttr('dispo_neuf_manuel');
		$ligne=array($ordre,$code,$titre,$matiere,$editeur,$edition,$tarif,$classe,$occasion,$neuf);
		fputcsv($f, $ligne, $csv_delim, $csv_enclose);
	}
	fclose($f);
	return (5);


	}
	
	private function dumpMySQL($serveur, $login, $password, $base, $mode){		
		$connexion = mysql_connect($serveur, $login, $password);
		mysql_select_db($base, $connexion); 

		$insertions = "";
		// si l'utilisateur a demandé les donn&eacute;es 
		if($mode > 1) {
			$donnees = mysql_query("SELECT * FROM manuel");			
			
			//regarder si la table est vide ou non 
			if(mysql_num_rows($donnees)==0) 
				$insertions .= "INSERT INTO manuel VALUES (),";
			else 
				$insertions .= "INSERT INTO manuel VALUES (";
			
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
			
			$fichierDump = fopen("./autres/sql/sauvegarde/Sauvegardemanuel.sql", "w+");
			fwrite($fichierDump, $insertions2);
			fclose($fichierDump);
			$insertions="";
		}
		mysql_close($connexion);
	}
	
	public function frmCreerAction() {			
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
		try {
			//on verifie que les champs ne soient pas vides			
			$man = new Manuel();
			$man->setAttr(code_manuel,$_POST['code_manuel']);
			$man->setAttr(titre_manuel,$_POST['titre_manuel']);
			$man->setAttr(matiere_manuel,$_POST['matiere_manuel']);
			$man->setAttr(classe_manuel,$_POST['classe_manuel']);
			$man->setAttr(editeur_manuel,$_POST['editeur_manuel']);
			$man->setAttr(date_edition_manuel,$_POST['date_edition_manuel']);
			$man->setAttr(tarif_neuf_manuel,$_POST['tarif_neuf_manuel']);
			$man->save();	
			
			// Section pour l'association du manuel a la liste
			$res = ListeManuel::deleteByCode($man->getAttr(code_manuel));
			$listes = $_POST['liste_manuel']; 	$i=1;
			foreach($listes as $idListe) {
				$lm = new ListeManuel();
				$lm->setAttr("code_manuel",$man->getAttr(code_manuel));
				$lm->setAttr("code_liste",$idListe);
				$lm->setAttr("num_manuel_liste",$i);
				$lm->save();
				$i++;
			}
			// Calcul des tarifs occasion du manuel
	        $etats= Etat::findAll();
			if (!is_null($etats)) {
                foreach ($etats as $etat) {
					$tarif = $man->getattr('tarif_neuf_manuel') * $etat->getattr('pourcentage_etat');
					$tarif = round($tarif/100 , 2);
					$d = Determine::findById($etat->getattr('code_etat'),$man->getattr('code_manuel') );
					if (!is_null($d)) {
						$d->setattr('tarif', $tarif);
						$d->save();
					} else {
						$d = new Determine() ; 
						$d->setattr('code_manuel', $man->getattr('code_manuel') );
						$d->setattr('code_etat', $etat->getattr('code_etat') );
						$d->setattr('tarif', $tarif);
						$d->insert() ;
					}
                }
            }
            header('Location:/ScolBoursePHP/index.php/Manuel/voir/'.$man->getAttr('code_manuel'));		 
		}catch(Exception $a) {
			$mode = "ERREUR"; 
			$titre = "Cr&eacute;er Manuel"; 
			$message = "Le Manuel existe d&eacute;j&agrave; dans la base de donn&eacute;es.<br/>Veuillez verifier les donn&eacute;es saisies.";
			$retour = "/ScolBoursePHP/Manuel/";							
			$v = new MessageView($titre, $message, $mode, $retour);
			$v->display (); 
			exit;
		}
	}

}

?>
