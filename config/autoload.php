<?php
/**
 *   Fichier qui contient la fonction __autoload(), pour faire 
 *   la charge automatique de classes dans la application. 
 *
 *   @author RIVAS Ronel
 *   @author SUSTAITA Luis
 *   @package config
 */
	
$autoloadPath = dirname(__FILE__);
$installDir = $autoloadPath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
$systemIncludePath = get_include_path() ;
set_include_path( $systemIncludePath . PATH_SEPARATOR . $installDir );

//ini_set('output_buffering', 4096);

/**
 *  constant qui define le suffix por les fichiers de classe 
 *  @access defaut
 *  @var CLASS_FILE_SUFFIX
 */ 		
define ('CLASS_FILE_SUFFIX' , '.class.php');

/**
 * Librarie patTemplate
 * 
 **/
require_once 'pat/patErrorManager.php';
require_once 'pat/patError.php';
require_once 'pat/patTemplate.php';


/**
 *   __autoload($className) : charge automatique de classes
 *
 *   Fonction g�n�rale pour faire la charge automatique des classes neccesaires <br/>
 *   dans le code PHP. Appel�e lorsque l'interprete se trouve avec un nouvelle $className <br/>
 *   dans le code.
 *   @access public
 **/ 
function __autoload($className) {	
	
	if(stripos($className,'patTemplate') === false) {
		$autoloadPath = dirname(__FILE__);
		$installDir = $autoloadPath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
		
		$myAppClasspath = PATH_SEPARATOR . $installDir . 'base' .
						  PATH_SEPARATOR . $installDir . 'config' .
						  PATH_SEPARATOR . $installDir . 'model' .
						  PATH_SEPARATOR . $installDir . 'view' .
						  PATH_SEPARATOR . $installDir . 'scripts' .
						  PATH_SEPARATOR . $installDir . 'templates' .
						  PATH_SEPARATOR . $installDir . 'controller' .
						  PATH_SEPARATOR . $installDir . 'forms' .
						  PATH_SEPARATOR . $installDir . 'aide' .
						  PATH_SEPARATOR . $installDir . 'rapports';
		
		$systemIncludePath = get_include_path() ;
		set_include_path( $systemIncludePath . $myAppClasspath );
		require_once ($className. CLASS_FILE_SUFFIX);
		set_include_path( $systemIncludePath );
	}
}

?>