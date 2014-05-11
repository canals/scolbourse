<?php
	// index.php
	require_once 'config/autoload.php';
        session_start();

        // l'application est-elle installée ?

        if (!is_file (dirname(_FILE_).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db_config.ini'))
            header('Location: install/install.php');

        // activer output_buffering
        //ob_start();





/* Affiche l'encodage interne courant */
echo mb_internal_encoding();
/* Utilise l'encodage interne UTF-8 */
/*mb_internal_encoding('UTF-8');*/
/* Affiche l'encodage interne courant */
echo mb_internal_encoding();
echo  mb_http_output();


        // On traite les requêtes
	
	$handler = new Dispatcher();
	$handler->dispatch();

        //ob_end_flush();
?>
