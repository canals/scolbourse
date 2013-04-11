<?php
/**
 * controller.AuthException.class.php : Exeception en les operations 
 * avec l'Authentication des Utilisateurs de l'application
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package controller
 */

class AuthException extends Exception {

	public function __construct($message, $code = 0) {
		// make sure everything is assigned properly
		parent::__construct($message, $code);
	}
	
	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
	
}
?>
