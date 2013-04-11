<?php		
	session_start();	
	session_destroy();	
	header("Location:"."/ScolBoursePHP/index.php");
?>