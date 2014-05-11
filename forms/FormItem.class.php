<?php
/**
 * forms.FormItem.class.php : classe qui represente les items des formulaires 
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package forms
 */

class FormItem {
	// D E S   A T T R I B U T S
	
	/**#@+
	 *  @access private
	 **/ 
	
	/**
	 *  libellé de l'item du formulaireu etat
	 *  @var $label
	 **/
	private $label;
	
	/**
	 *  nom de l'item du formulaireu etat
	 *  @var $nom
	 **/
	private $nom;
	
	/**
	 *  description du etat
	 *  @var $description
	 **/
	private $type;
	
	/**
	 *  description du etat
	 *  @var $description
	 **/
	private $valeur;
	
	/**
	 *  description du etat
	 *  @var $description
	 **/
	private $oblig;
	
	/**
	 *  Si l'item est disabled 
	 *  @var $disabled
	 **/
	private $disabled;
	
	/**
	 *  Si l'item a des managers des events. L'attribute a l'appel à la fonction javascript de l'event
	 *  De la façon suivante: "event='nomFonction(paramsValues);'".
	 *  Par example: "onclick='nomFonction('value')'"
	 *  @var $events
	 **/
	private $events;
	
	/**
	 *  description du etat
	 *  @var $description
	 **/
	private $erreur;
			 
	
	/**#@-*/
	
	
	// D E S   M E T H O D E S
	
	/**#@+
	*  @access public
	*/ 
	
	/**
	*  Constructeur de l'item 
	*
	*  fabrique un nouvel item vide
	*/
	public function __construct($label,$nom, $type, $valeur,  $oblig, $disabled, $events, $erreur) {
		 $this->setAttr("label",$label);
		 $this->setAttr("nom",$nom);
		 $this->setAttr("type",$type);
		 $this->setAttr("valeur",$valeur);
		 $this->setAttr("oblig",$oblig);
		 $this->setAttr("disabled",$disabled);
		 $this->setAttr("events",$events);
		 $this->setAttr("erreur",$erreur);		 
	}
	
	/**
	*  Magic pour imprimer
	*
	*  Fonction Magic retournant une chaine de caractéres imprimable
	*  pour imprimer facilement un Etat
	*
	*   @access public
	*   @return String
	*/
	public function __toString() {
		return $this->description;
	}	
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un etat.
	*   Reçoit en paramètre le nom de l'attribut accédé
	*   et retourne sa valeur.
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @return mixed
	*/
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	*   Setter générique
	*
	*   fonction de modification des attributs d'un etat.
	*   Reçoit en paramétre le nom de l'attribut modifié et la nouvelle valeur
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @param mixed $attr_val attribute value
	*   @return mixed new attribute value
	*/
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name=$attr_val;
		return $attr_val ;
	}					
	
	/**#@-*/	
}
?>
