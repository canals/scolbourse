<?php

	require_once 'config/autoload.php';
	
	session_start();
			
	$auth= new BourseAuth() ;
		
	$login = (isset($_REQUEST["login"]))?$_REQUEST["login"]:null;
	$passw = (isset($_REQUEST["passw"]))?$_REQUEST["passw"]:null;	
		
	$login = htmlspecialchars(mysql_escape_string($login));	
	$passw = htmlspecialchars(mysql_escape_string($passw));	

	try {
		$auth->checkUserIdentity($login, $passw);
		echo "1";
	} catch (AuthException $a) {
	  echo $a->getMessage();
	  exit;
	}		
?>