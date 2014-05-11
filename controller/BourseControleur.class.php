<?php

session_start();

/**
* controller.BourseControleur.class.php : classe qui represente le controleur des Bourses de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
*
* @package controller
**/

class BourseControleur extends AbstractControleur {

	public static $MNU_ID = "mnuBourse";
	
	public function __construct(){
		// Pour gérer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {
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
		$view = new BourseView($bourse,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
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
	
		$view = new BourseView($bourse,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations
			case "ouvrir" : { $this->ouvrirBourse() ; break; }
			case "fermer" : { $this->fermerAction() ; break; }		
			case "structure" : { $this->structureAction() ; break; }		
			case "donneesSauvegarde" : { $this->donneesSauvegardeAction() ; break; }
			case "donnees" : { $this->donneesAction() ; break; }			
			case "exportDonnees" : { $this->exportDonneesAction() ; break; }		
			case "save"  : { $this->saveProfil() ; break; }						
			default         : { $this->mnuAction() ; }
		} 
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
		
		// Afficher le result
		$view = new BourseView($bourse,"mnuAction");
		$view->display ();		 
	}	
	
	public function ouvrirBourse() {
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
	
		try{
		$link = mysql_connect("localhost", "root", "")
			or die("Impossible de se connecter : " . mysql_error());
		$query=file_get_contents("./autres/sql/dropBase.sql"); 
		mysql_query($query);
		$query2=file_get_contents("./autres/sql/creerBase.sql"); 
		mysql_query($query2);
				
		$rep = "./autres/sql/tables/";
		$dir = opendir($rep); 
		while ($f = readdir($dir)) {
		   if(is_file($rep.$f)) {
			  $query=file_get_contents("./autres/sql/tables/".$f); 
			  $dbres = Base::doUpdate($query);

		   }
		 }
		 
		mysql_select_db("scolbourse", $link);		
		$listeTables = mysql_query("show tables", $link);
		while($table = mysql_fetch_array($listeTables))
		{
			mysql_query("DELETE from ".$table[0].";");
		}
		$rep = "./autres/sql/sauvegarde/";
		$dir = opendir($rep); 
		while ($f = readdir($dir)) {
		   if(is_file($rep.$f)) {
			$query=file_get_contents("./autres/sql/sauvegarde/".$f); 
			$dbres = Base::doUpdate($query);
		   }
		 }
		 
		mysql_close($link);
			//$view = new BourseView($bourse,"ok");
			//$view->display ();
			$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>La bourse &agrave; bien &eacute;t&eacute; ouverte !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;

		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}

	public function structureAction() {	
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
	
		try{
		$link = mysql_connect("localhost", "root", "")
			or die("Impossible de se connecter : " . mysql_error());
		$query=file_get_contents("./autres/sql/dropBase.sql"); 
		mysql_query($query);
		$query2=file_get_contents("./autres/sql/creerBase.sql"); 
		mysql_query($query2);
		mysql_close($link);
				
		$rep = "./autres/sql/tables/";
		$dir = opendir($rep); 
		while ($f = readdir($dir)) {
		   if(is_file($rep.$f)) {
			  $query=file_get_contents("./autres/sql/tables/".$f); 
			  $dbres = Base::doUpdate($query);

		   }
		 }

			//$view = new BourseView($bourse,"ok");
			//$view->display ();
			$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Les tables ont &eacute;t&eacute; mise à&agrave; vides !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;

		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}

	}	

	public function donneesSauvegardeAction() {
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
		
		//il faut lire le fichier ligne à ligne
		try{
				
		$connexion = mysql_connect("$host:$port",$user,$pass);
		mysql_select_db($dbname, $connexion);		
				
		$listeTables = mysql_query("show tables", $connexion);
		while($table = mysql_fetch_array($listeTables))
		{
			mysql_query("DELETE from ".$table[0].";");
		}
		$rep = "./autres/sql/sauvegarde/";
		$dir = opendir($rep); 
		while ($f = readdir($dir)) {
		   if(is_file($rep.$f)) {
			$query=file_get_contents("./autres/sql/sauvegarde/".$f); 
			$dbres = Base::doUpdate($query);
		   }
		 }

			//$view = new BourseView($bourse,"ok");
			//$view->display ();
			$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Les fichiers de sauvegardes ont bien &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;s !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;

		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}

	}	

	public function donneesAction() {
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
	
		try{
			$query=file_get_contents($_FILES['fichier']['tmp_name']);
			$query = str_replace("'\''", "''", $query);
			$query = str_replace("''''", "''", $query);
			
			$dbres = Base::doUpdate($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}

		//$view = new BourseView($bourse,"ok");
		//$view->display ();		
			$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Le fichier &agrave; bien &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
 
	}	
	
	//Fonction d'export
	public function dumpMySQL($serveur, $login, $password, $base, $mode){
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
	
		$connexion = mysql_connect($serveur, $login, $password);
		mysql_select_db($base, $connexion);
		
		$insertions = "";
		
		$listeTables = mysql_query("show tables", $connexion);
		while($table = mysql_fetch_array($listeTables))
		{
			$insertions = "";
			// si l'utilisateur a demandé les donn&eacute;es 
			if($mode > 1)
			{
				$donnees = mysql_query("SELECT * FROM ".$table[0]);
				//regarder si la table est vide ou non 
				if(mysql_num_rows($donnees)==0){
					$insertions .= "INSERT INTO ".$table[0]." VALUES (),";
				}else{
					$insertions .= "INSERT INTO ".$table[0]." VALUES (";
				}

				
				$comp=0;
				while($nuplet = mysql_fetch_array($donnees))
				{
					if($comp!=0)
						$insertions .=  "(";
					for($i=0; $i < mysql_num_fields($donnees); $i++)
					{
					  if($i != 0)
						 $insertions .=  ", ";
					  if(mysql_field_type($donnees, $i) == "string" || mysql_field_type($donnees, $i) == "blob")
						 $insertions .=  "'";
					  $insertions .= addslashes($nuplet[$i]);
					  if($nuplet[$i]=='')
					  	$insertions .=  "''";			
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
				
				$fichierDump = fopen("./autres/sql/sauvegarde/Sauvegarde".$table[0].".sql", "w+");
				fwrite($fichierDump, $insertions2);
				fclose($fichierDump);
				$insertions="";

			}
		}
	 
		mysql_close($connexion);
	 
	}

	public function exportDonneesAction() {
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
	
		include_once('config/config.db.php');			
		$this->dumpMySQL("$host:$port", $user, $pass, $dbname, 3);
				
		//$view = new BourseView($bourse,"export");
		//$view->display ();		
					$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Les donn&eacute;es de la base ont bien &eacute;t&eacute; sauvegard&eacute;es !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
 
	}	
	
	public function fermerAction() {
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
	
		$this->dumpMySQL("localhost", "root", "", "scolbourse", 3);
		//$view = new BourseView($bourse,"export");
		//$view->display ();		
					$html = "";	
			$html .= "<div style='width:200; overflow:auto;'>";
			$html .= "<h2>Resultat</h2>";		
			$html .= "<table align='left'>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>La bourse &agrave; bien &eacute;t&eacute; ferm&eacute;e !</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='' onclick='closeMessage(); return false;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
 
	}	
}

?>