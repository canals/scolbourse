<?php
/**
*   Fichier de configuration pour l'accés à la base.
*   Utilisé par la classe Base pour construire le DSN
*
*   @author COURTOIS Guillaume
*   @author JARNOUX Noemie
*   @author RIVAS Ronel
*   @author SUSTAITA Luis
*   @author CANALS Gerome
*
*   @package config
*/

/***********************************************************
    APPLICATION 
***********************************************************/

/*
* @var String Repertoire d'installation de l'application
*/
$repApp='/scolBoursePHP';


/***********************************************************
    BASSE DE DONNEES 
***********************************************************/

/**
* @var String phptype database backend
*/
$dbtype='mysql';

/**
* @var String user identification on the DB server
*/
$user='bourse10';

/**
* @var String password for user authentification on the DB server
*/
$pass='bourse10';

/**
* @var String hostname of the DB Server
*/
$host='localhost';

/**
* @var String port number of the DB Server
*/
$port='3306';

/**
* @var String database name on the DB Server
*/
$dbname='bourse10';

?>
