<?php
/**
 * File : ManuelException.class.php
 *
 * @author SUSTAITA Luis
 * @package model
 */

/** 
 * Classe ExemplaireException.class.php : Exeception en les operations 
 * avec la classe Manuel.
 * 
 * @package model
 */
class ExemplaireException  extends Exception {

	/**
	 *  #@+
	 *  @access public
	 */
	
	/**
	 *  Constructeur de la classe ManuelException.
	 *
	 *  Fabrique un nouvel objet de type AuthException en
	 *  utilisant le constructeur de sa classe parent.
	 *
	 *  @param string $message Message personnalisé pour l'exception
	 *  @param int $code Le code de l'exception (0 par défaut)
	 */
	public function __construct($message, $code = 0) {
       // make sure everything is assigned properly
       parent::__construct($message, $code);
	}

    /**
	 *  Magic pour imprimer l'exception.
	 *
	 *  Fonction Magic retournant une chaine de caracteres imprimable
	 *  pour imprimer facilement un objet de type ManuelException.
	 *
	 *  @return string
	 */
	public function __toString() {
		// custom string representation of object
       return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
   	}
	
	/**
	 * #@-
	 */
}
?>