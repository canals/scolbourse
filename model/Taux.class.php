<?php
/**
 * model.Taux.class.php : classe qui represente les Taux de l'application
 *
 * @package model
 */

class Taux {
	// D E S   A T T R I B U T S
	
	/**#@+
	 *  @access private
	 **/ 
	
	/**
	 *  identifiant de Taux
	 *  @var $code_taux
	 **/
	private $code_taux; 
	
	/**
	 *  taux de frais de dossier
	 *  @var $taux_frais
	 **/
	private $taux_frais; 
	
	/**
	 *  Montant des frais d'envoi des documents
	 *  @var $montant_frais_envoi
	 **/
	private $montant_frais_envoi; 
	

	/**#@-*/
	
	
	// D E S   M E T H O D E S
	
	/**#@+
	*  @access public
	*/ 
	
	/**
	*  Constructeur de taux
	*
	*  fabrique un nouveau taux vide
	*/
	public function __construct() {
		// Anything necessary to construct a new Taux de ce classe
	}
	
	/**
	*  Magic pour imprimer
	*
	*  Fonction Magic retournant une chaine de caract?res imprimable
	*  pour imprimer facilement un Taux
	*
	*   @access public
	*   @return String
	*/
	public function __toString() {
		return __CLASS__ . " CodeTaux:   ". $this->code_taux .";";
	}	
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un taux.
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
	*   fonction de modification des attributs d'un taux.
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
		
	/**
	*   Finder sur $ID
	*
	*   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	*   retourne un Taux
	*  
	*   @static
	*   @param integer $code_taux OID to find
	*   @return taux renvoie un taux de type Taux
	*/
	public static function findByID($code_taux) {
		$query = "select * from taux where code_taux=". $code_taux;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new taux();
			$o->setAttr("code_taux", $row["code_taux"]);
			$o->setAttr("taux_frais", $row["taux_frais"]);
			$o->setAttr("montant_frais_envoi", $row["montant_frais_envoi"]);
		} 
		return $o;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table taux 
	*   sous la forme d'un tableau de taux
	*  
	*   @static
	*   @return Array renvoie un tableau de taux
	*/	
	public static function findAll() {
		$query = "select * from taux";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new taux();
				$o->setAttr("code_taux", $row["code_taux"]);
				$o->setAttr("taux_frais", $row["taux_frais"]);
				$o->setAttr("montant_frais_envoi", $row["montant_frais_envoi"]);
				$all[]=$o;
			}
		}
		return $all;
	}
	
	/**
	*   Insertion dans la base
	*
	*   Insére le taux comme une nouvelle ligne dans la table
	*   @access public
	*   @return int nombre de lignes insérées
	*/				
	public function insert() {
	
		$user = taux::findByID((isset($this->code_taux)? "$this->code_taux" : "null"));		
		if($user!=null) 
			return "ERREUR";
			
		$save_query = "insert into taux (code_taux,taux_frais,montant_frais_envoi) values ( " . 	
		(isset($this->code_taux)        ? "'$this->code_taux'" : "null").",".
		(isset($this->taux_frais)     ? "'$this->taux_frais'" : "null").",".
		(isset($this->montant_frais_envoi)      ? "'$this->montant_frais_envoi'" : "null").")" ;
		
		
		
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}		
		
	/**
	*   mise à jour de la ligne courante
	*   
	*   Sauvegarde le taux courant dans la base en faisant un update
	*   le code du taux  doit exister (insert obligatoire auparavant)
	*   méthode privée - la méthode publique s'appelle save
	*   @acess private
	*   @return int nombre de lignes mises à jour
	*/
	private function update() {	
		if (!isset($this->code_taux)) {
			throw new TauxException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "update taux set 
		code_taux = "        . (isset($this->code_taux)        ? "'$this->code_taux'" : "null")  . ", 
		taux_frais = "     . (isset($this->taux_frais)     ? "'$this->taux_frais'" : "null")   . ", 
		montant_frais_envoi = "      . (isset($this->montant_frais_envoi)      ? "'$this->montant_frais_envoi'" : "null");
		
		
		
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
			
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}
		
	/**
	*   Suppression dans la base
	*
	*   Supprime la ligne dans la table corrsepondant au taux courant
	*   @access public
	*/	
	public function delete() {
		if (!isset($this->code_taux)) {
			throw new TauxException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from taux where code_taux= $this->code_taux";
		
		$del_query = str_replace("'\''", "''", $del_query);
		$del_query = str_replace("''''", "''", $del_query);
		
		try {
			return Base::doUpdate($del_query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}
	
	/**
	*   Sauvegarde dans la base
	*
	*   Enregistre l'état du taux dans la table
	*   Si le taux posséde un identifiant : mise à jour de la ligne correspondante
	*   sinon : insertion dans une nouvelle ligne
	*   @access public
	*/
	public function save() {
		if (!isset($this->code_taux))
			return $this->insert();
		else
			return $this->update();
	}				
	
	
}
?>