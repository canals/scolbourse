<?php
/**
 * base.BaseException.class.php : Exeception en l'acces � la base de donn�es
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package base
 */

class BaseException extends Exception {
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
