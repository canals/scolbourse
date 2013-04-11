<?php

//require_once(dirname(_FILE_).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'autoload.php');
//require_once('MDB2.php');
//require_once('DB.php');
define('CONFIG_FILE_NAME', 'db_config.ini');

function copierRepertoire( $source, $target ) {
        if (is_dir($source)) {
            @mkdir($target);
            $d = dir($source);
            while (($entry=$d->read())!==FALSE) {
                if (($entry == '.') || ($entry == '..'))
					continue;
                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    copierRepertoire($Entry,$target . '/' . $entry);
                    continue;
                }
				copy($Entry,$target . '/' . $entry);
            }
            $d->close();
        } else {
            copy($source,$target);
        }
    }
	function zipExtractTo( $zip, $to ) {
		$z = new ZipArchive();
		if ($z->open('test.zip') === TRUE) {
			$z->extractTo($to);
			$z->close();
			return TRUE ;
        } else { return FALSE ;}
	}

	function removeCache($dirname){
		if ($dirHandle = opendir($dirname)){
			$old_cwd = getcwd();
			chdir($dirname);

			while($file = readdir($dirHandle)){
				if($file == '.' || $file == '..')
					continue;
				if(is_dir($file)){
					if(!removeCache($file))
						return false;
				}else{
					if (!unlink($file))
						return false;
				}
			}
			closedir($dirHandle);
			chdir($old_cwd);
			if(!rmdir($dirname))
				return false;
			return true;
		}else{
			return false;
		}
	}

        function writeIniFile($repDestin, $repApp, $dbtype, $user, $pass, $host, $port, $dbname) {
             $file = fopen($repDestin,"w");
             $content = <<<EOT
db_driver=$dbtype
db_user=$user
db_password=$pass

host=$host
dbname=$dbname
dbport=$port
EOT;
             fputs($file,$content);
	     fclose($file);
        }


	function configFile($repDestin, $repApp, $dbtype, $user, $pass, $host, $port, $dbname) {
		$file = fopen($repDestin,"w");

		$cont = "";
		$cont .= "<?php"."\n";
		$cont .= "/**"."\n";
		$cont .= "*   Fichier de configuration pour l'accés à la base."."\n";
		$cont .= "*   Utilisé par la classe Base pour construire le DSN"."\n";
		$cont .= "*"."\n";
		$cont .= "*   @author COURTOIS Guillaume"."\n";
		$cont .= "*   @author JARNOUX Noemie"."\n";
		$cont .= "*   @author RIVAS Ronel"."\n";
		$cont .= "*   @author SUSTAITA Luis"."\n";
		$cont .= "*   @author CANALS Gerome"."\n";
		$cont .= "*"."\n";
		$cont .= "*   @package config"."\n";
		$cont .= "*/"."\n";
		$cont .= ""."\n";

		$cont .= "/***********************************************************"."\n";
		$cont .= "    APPLICATION "."\n";
		$cont .= "***********************************************************/"."\n";
		$cont .= ""."\n";
		$cont .= "/*"."\n";
		$cont .= "* @var String Repertoire d'installation de l'application"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."repApp='". $repApp ."';"."\n";
		$cont .= ""."\n";
		$cont .= ""."\n";

		$cont .= "/***********************************************************"."\n";
		$cont .= "    BASSE DE DONNEES "."\n";
		$cont .= "***********************************************************/"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String phptype database backend"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."dbtype='". $dbtype ."';"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String user identification on the DB server"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."user='". $user ."';"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String password for user authentification on the DB server"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."pass='". $pass ."';"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String hostname of the DB Server"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."host='". $host ."';"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String port number of the DB Server"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."port='". $port ."';"."\n";
		$cont .= ""."\n";
		$cont .= "/**"."\n";
		$cont .= "* @var String database name on the DB Server"."\n";
		$cont .= "*/"."\n";
		$cont .= "$"."dbname='". $dbname ."';"."\n";
 		$cont .= ""."\n";
		$cont .= "?>"."\n";
		fputs($file,$cont);
		fclose($file);
	}

/**
 * LET'S GO : 
 * 
 * 0) check php installation
 * 1) echo install form
 * 2) get submitted values
 * 3) check values & environment
 * 4) if every thing goes well, create the config file
 */
        
if (version_compare(PHP_VERSION, '5.1', '<')) {
    echo "<b>fatal error : php 5.1+ required, ". PHP_VERSION ." found </b>";
    exit(0);
}
        
if(!isset($_REQUEST['frmConf_submit'])) {
		// Afficher le formulaire
		$repInstall = dirname(dirname(dirname(__FILE__))) ;
		$serverWeb = 'localhost';
		$portWeb   = "80";
		$dbtype    = "mysql";
		$user      = "scolbourse";
		$pass 	   = "";
		$host      = "localhost";
		$port 	   = "3306";
		$dbname    = "scolbourse";
		$creatable = "checked";

		include("./support/frmConf.php");
	} else {
	$ERROR_MSG = null;
	// 1) Récupérer et calculer les différents paramètres et chemins
	//

	//$repInstall = ((isset($_REQUEST["repInstall"]))? $_REQUEST["repInstall"] : $repInstall) ;
	$serverWeb = (isset($_REQUEST["serverWeb"]))? $_REQUEST["serverWeb"]:"localhost";
	$portWeb   = (isset($_REQUEST["portWeb"]))?   $_REQUEST["portWeb"]:"80";
	$dbtype    = (isset($_REQUEST["dbtype"]))?$_REQUEST["dbtype"]:"mysql";
	$user      = (isset($_REQUEST["user"]))?  $_REQUEST["user"]:"root";
	$pass 	   = (isset($_REQUEST["pass"]))?  $_REQUEST["pass"]:"";
	$host      = (isset($_REQUEST["host"]))?  $_REQUEST["host"]:"localhost";
	$port 	   = (isset($_REQUEST["port"]))?  $_REQUEST["port"]:"3306";
	$dbname    = (isset($_REQUEST["dbname"]))?$_REQUEST["dbname"]:"scolbourse";
	$creatable = (isset($_REQUEST["creatable"]))?$_REQUEST["creatable"]:null;

	//$repSource = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SB-sources';
        //$zipSource = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ScolBoursePHP.zip';


	//
	//  2) Quelques tests
	//
	// D'abord la BD :
        /*
		$dsn = "$dbtype://$user:$pass@$host:$port/$dbname";
		//$db = & MDB2::connect($dsn);
		$db = DB::connect($dsn);
	    if ( PEAR::isError($db) ) {
			$ERROR_MSG .= '<b>Connexion SGBD impossible : verifiez les parametres </b><br/>'.$db->getMessage() .'<br/>';
		}
        */
        try {
        $dsn="$dbtype:host=$host;dbname=$dbname";
        $db = new PDO($dsn, $user,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                                               PDO::ERRMODE_EXCEPTION=>true,
                                               PDO::ATTR_PERSISTENT=>true));
        } catch (PDOException $e) {
          $ERROR_MSG .= '<b>Connexion SGBD impossible : verifiez les parametres </b><br/>'.$e->getMessage() .'<br/>';  
        }     
	// les répertoires
		//if (! is_dir($repSource)) {  // AND (! file_exists($zipSource))) {
		//	$ERROR_MSG .= "<b> source $repSource ou $zipSource non trouve </b><br/>";
		//}
                $repInstall = dirname(dirname(dirname(__FILE__))) ;
		if (! is_dir($repInstall.DIRECTORY_SEPARATOR.'ScolBoursePHP')) {
			$ERROR_MSG .= "<b>repertoire installation $repInstall/ScolBoursePHP non trouve </b><br/>";
		}
		if (is_dir($repInstall.DIRECTORY_SEPARATOR.'ScolBoursePHP')) {
                        $configdir = $repInstall.DIRECTORY_SEPARATOR.'ScolBoursePHP'.DIRECTORY_SEPARATOR. 'config';
			$ok = @fopen( $configdir.DIRECTORY_SEPARATOR.'config.test' , 'w+') ;
			if ($ok) { @unlink($configdir.DIRECTORY_SEPARATOR.'config.test');
		    } else {
			$ERROR_MSG .= "<b>ecriture impossible dans le répertoire config : verifier droits d'acces </b><br/>";
		    }
		}
		//
		// SI LE MESSAGE D4ERREUR N'EST PAS VIDE : réafficher le formulaire et quitter
		// SINON, procéder à l'installation

		if ($ERROR_MSG) {
			include("./support/frmConf.php");
			exit();
		}




	/*** 3) INSTALLATION **/
	// Copie des fichiers
	//$repDestin = $repInstall . DIRECTORY_SEPARATOR . 'ScolBoursePHP' ;
	//copierRepertoire( $repSource, $repDestin ) ;

	//zipExtractTo( $zipSource, $repInstall );

	// Mise à jour le fichier de configuration: CONFIG.PHP
	$repApp = '/scolBoursePHP';
	$file_name = $configdir.DIRECTORY_SEPARATOR.CONFIG_FILE_NAME;

	//configFile($file_name, $repApp, $dbtype, $user, $pass, $host, $port, $dbname) ;
        writeIniFile($file_name, $repApp, $dbtype, $user, $pass, $host, $port, $dbname) ;
	//
	//echo "créer les tables : $creatable <br/>";

	/*** 3) CREER les tables  si demané **/

	$ERROR_MSG=null;
	//$dsn = "$dbtype://$user:$pass@$host:$port/$dbname";
	//$db = & MDB2::connect($dsn);
        /*
        $db = DB::connect($dsn);
	if ( PEAR::isError($db) ) {
	  $ERROR_MSG='<b>Connexion SGBD impossible : verifiez les parametres </b><br/>'.$db->getMessage() .'<br/>';
	} else {
         * 
         */
	if ($creatable) {
            
        try {
        $dsn="$dbtype:host=$host;dbname=$dbname";
        $db = new PDO($dsn, $user,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                                               PDO::ERRMODE_EXCEPTION=>true,
                                            PDO::ATTR_PERSISTENT=>true));
        $db->beginTransaction();
        $rep = "./support/sql/";
		$dir = opendir($rep);

		while ($f = readdir($dir)) {
			if(is_file($rep.$f)) {
				$fichier = $rep . $f;
				$queries = explode(';',file_get_contents($fichier));
				foreach ($queries as $query) {
      					//$dbres = $db->query($query);
				$dbres = $db->exec($query);
				
				}
				}
			}
			$rep = "./support/init/";
			$dir = opendir($rep);
			echo "<br/><strong>données initiales</strong><br/>";
			while ($f = readdir($dir)) {
				if(is_file($rep.$f)) {
					$fichier = $rep . $f;
					$queries = explode(';',file_get_contents($fichier));
					foreach ($queries as $query) {
                                        //$dbres = $db->exec($query);
					$dbres = $db->exec($query);
					
				}
				}
			}
        $db->commit();
        } catch (PDOException $e) {
          $db->rollback();
          $ERROR_MSG .= '<b>echec creation des tables '.$e->getMessage() .'</b><br/>'.$e->getMessage() .'<br/>';  
        } 
		
	}

	if (! $ERROR_MSG) $ERROR_MSG = '<strong></strong>Installation de scolBoursePHP complete</strong><br/>';

	// Definir le nom et l'adresse web de l'application
	$nomApp = substr($dirApp, strrpos($dirApp , DIRECTORY_SEPARATOR)+1, strlen($dirApp));
	$adresseWebApp = "http://" . $serverWeb . (($portWeb=="80")?"":(":".$portWeb)) . "/" . "ScolBoursePHP";

	// Afficher le Resultats
	include_once("./support/resultMessage.php");

  }

?>
