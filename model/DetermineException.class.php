<?php
/**
 * File : DetermineException.class.php
 *
 * @author SUSTAITA Luis
 * @package model
 */

/** 
 * Classe DetermineException : Exception en les operations 
 * avec la classe Determine.
 * 
 * @package model
 */
class DetermineException extends Exception {

	/**#@+
	 *  @access public
	 */

	/**
	 *  Constructeur de la classe DetermineException.
	 *
	 *  Fabrique un nouvel objet de type DetermineException en
	 *  utilisant le constructeur de sa classe parent.
	 *
	 *  @param string $message Message personnalisé pour l'exception
	 *  @param int $code Le code de l'exception
	 */
	public function __construct($message, $code = 0) {	
		// make sure everything is assigned properly
		parent::__construct($message, $code);
	}
	
	/**
	 *  Magic pour imprimer l'exception.
	 *
	 *  Fonction Magic retournant une chaine de caracteres imprimable
	 *  pour imprimer facilement un objet de type DetermineException.
	 *
	 *  @return string
	 */
	public function __toString() {
		// custom string representation of article
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
	
	/**
	 * #@-
	 */
}
?>