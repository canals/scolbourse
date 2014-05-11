<?php
/**
 * model.Reglement.class.php : classe qui represente les types de Règlements
 *
 * @package model
 */

class Reglement {  	
	// D E S   A T T R I B U T S
	
	/**#@+
	 *  @access private
	 **/ 
	
	/**
	 *  identifiant de Reglement
	 *  @var $code_reglement
	 **/
	private $code_reglement; 
	
	/**
	 *  mode de règlement
	 *  @var $mode_reglement
	 **/
	private $mode_reglement; 
	
	/**#@-*/
	
	
	// D E S   M E T H O D E S
	
	/**#@+
	*  @access public
	*/ 
	
	/**
	*  Constructeur de règlement
	*
	*  fabrique un nouveau règlement vide
	*/
	public function __construct() {
		// Anything necessary to construct a new Reglement de ce classe
	}
	
	/**
	*  Magic pour imprimer
	*
	*  Fonction Magic retournant une chaine de caract?res imprimable
	*  pour imprimer facilement un Reglement
	*
	*   @access public
	*   @return String
	*/
	public function __toString() {
		return __CLASS__ . " Code reglement:   ". $this->code_reglement .";";
	}	
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un règlement.
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
	*   fonction de modification des attributs d'un règlement.
	*   Reçoit en paramétre le nom de l'attribut modifié et la nouvelle valeur
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @param mixed $attr_val attribute value
	*   @return mixed new attribute value
	*/
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name = $attr_val;
		return $attr_val ;
	}
		
	/**
	*   Finder sur $ID
	*
	*   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	*   retourne un Règlement
	*  
	*   @static
	*   @param integer $code_reglement OID to find
	*   @return reglement renvoie un reglement de type Règlement
	*/
	public static function findById($code_reglement) {
		$query = "select * from reglement where code_reglement=". $code_reglement;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new reglement();
			$o->setAttr("code_reglement", $row["code_reglement"]);
			$o->setAttr("mode_reglement", $row["mode_reglement"]);
		} 
		return $o;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table reglement 
	*   sous la forme d'un tableau de reglement
	*  
	*   @static
	*   @return Array renvoie un tableau de reglement
	*/	
	public static function findAll() {
		$query = "select * from reglement order by code_reglement";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new reglement();
				$o->setAttr("code_reglement", $row["code_reglement"]);
				$o->setAttr("mode_reglement", $row["mode_reglement"]);
				$all[]=$o;
			}
		}
		return $all;
	}
	
	/**
	*   Insertion dans la base
	*
	*   Insére le reglement comme une nouvelle ligne dans la table
	*   @access public
	*   @return int nombre de lignes insérées
	*/				
	public function insert() {
	
		$user = Reglement::findById((isset($this->code_reglement)? "$this->code_reglement" : "null"));		
		if($user!=null) 
			return "ERREUR";
			
		$save_query = "INSERT INTO reglement (code_reglement, mode_reglement) VALUES ( " . 	
		(isset($this->code_reglement)        ? "$this->code_reglement" : "null").",".
		(isset($this->mode_reglement)     ? "'$this->mode_reglement'" : "null").")" ;
		
		
		
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
		} catch(BaseException $e){
			echo "[Reglement::insert] - ";
			echo $e->__toString();
			echo "<br>";
			exit();
		}
	}		
		
	/**
	*   mise à jour de la ligne courante
	*   
	*   Sauvegarde le reglement courant dans la base en faisant un update
	*   le code du reglement  doit exister (insert obligatoire auparavant)
	*   méthode privée - la méthode publique s'appelle save
	*   @acess private
	*   @return int nombre de lignes mises à jour
	*/
	private function update() {	
		if (!isset($this->code_reglement)) {
			throw new ReglementException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "UPDATE reglement SET  
			mode_reglement = "     . (isset($this->mode_reglement)     ? "'$this->mode_reglement'" : "null") .
			" WHERE  `reglement`.`code_reglement` =" . $this->code_reglement;
			
		
		
			
		try {
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
			
		} catch(BaseException $e){
			echo "[Reglement::update] - ";
			echo $e->__toString();
			echo "<br>";
			exit();
		}
	}
		
	/**
	*   Suppression dans la base
	*
	*   Supprime la ligne dans la table corrsepondant au reglement courant
	*   @access public
	*/	
	public function delete() {
		if (!isset($this->code_reglement)) {
			throw new ReglementException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from reglement where code_reglement= $this->code_reglement";
		try {
			return Base::doUpdate($del_query);
		} catch(BaseException $e){
			echo "[Reglement::delete] - ";
			echo $e->__toString();
			echo "<br>";
			exit();
		}
	}
	
	/**
	*   Sauvegarde dans la base
	*
	*   Enregistre l'état du reglement dans la table
	*   Si le reglement posséde un identifiant : mise à jour de la ligne correspondante
	*   sinon : insertion dans une nouvelle ligne
	*   @access public
	*/
	public function save() {
		$o = Reglement::findById($this->code_reglement);
		
		if ($o == null)
			return $this->insert();
		else
			return $this->update();
	}				
	
	
}
?>
