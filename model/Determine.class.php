<?php

/**
 * File: Determine.class.php
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package model
 */

/** 
 * Classe Determine : un Active Record sur la table determine.
 *
 * @package model
 */
class Determine {
	// D E S   A T T R I B U T S
		
	/**#@+
	 *  @access private
	 */ 
	
	/**
	 *  Code etat afin de retrouver l'état de l'exemplaire.
	 *  @var int $code_etat
	 */
	private $code_etat; 
	
	/**
	 *  Code manuel afin de retrouver le manuel correspondant à l'exemplaire.
	 *  @var string $code_manuel
	 */
	private $code_manuel; 
	
	/**
	 *  Tarif en fonction de l'état et du manuel.
	 *  @var double $tarif
	 */
	private $tarif; 
	
	/**
	 * #@-
	 */
	
	// D E S   M E T H O D E S
	
	/**#@+
	 *  @access public
	 */ 
	
	/**
	 *  Constructeur de la classe Determine.
	 *
	 *  Fabrique un nouvel objet de type Determine vide.
	 */
	public function __construct() {
		// Pour construire un nouvel objet vide de type Article
	}
	
	/**
	 *  Magic pour imprimer.
	 *
	 *  Fonction Magic retournant une chaine de caracteres imprimable
	 *  pour imprimer facilement un objet Determine.
	 *
	 *  @return string
	 */
	public function __toString() {
		return "[Object:" . __CLASS__  . "] code_etat: ". $this->code_etat ." code_manuel: ". $this->code_manuel .";";
	}	
	
	/**
	 *   Getter générique.
	 *
	 *   Fonction d'accés aux attributs d'un objet Determine.
	 *   Reçoit en paramètre le nom de l'attribut accédé
	 *   et retourne sa valeur.
	 *  
	 *   @param string $attr_name Le nom de l'attribut
	 *   @return mixed
	 */
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	 *   Setter générique.
	 *
	 *   Fonction de modification des attributs d'un objet Determine.
	 *   Reçoit en paramétre le nom de l'attribut modifié et la nouvelle valeur.
	 *  
	 *   @param string $attr_name Le nom de l'attribut à modifier 
	 *   @param mixed $attr_val La nouvelle valeur
	 *   @return mixed La nouvelle valeur de l'attribut
	 */
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name = $attr_val;
		return $attr_val ;
	}
		
	/**
	 *   Finder sur l'id (code_etat et code_manuel).
	 *
	 *   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	 *   retourne un objet Determine.
	 *  
	 *   @static
	 *   @param int $code_etat Le code de l'etat du manuel
	 *   @param string $code_manuel Le code du manuel
	 *   @return Determine Renvoie un objet de type Determine
 	 */
	public static function findById($code_etat, $code_manuel) {
		$query = "SELECT * FROM determine WHERE code_etat=". $code_etat ." AND code_manuel='". $code_manuel ."'";
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Determine();
			$o->setAttr("code_etat", $row["code_etat"]);
			$o->setAttr("code_manuel", $row["code_manuel"]);
			$o->setAttr("tarif", $row["tarif"]);			
		} 
		return $o;
	}
	
	/**
	 *   Finder sur $code_manuel.
	 *
	 *   Renvoie toutes les lignes de la table determine qui ont le même code_manuel que le paramètre $code_manuel
	 *   sous la forme d'un tableau d'objets Determine.
	 *  
	 *   @static
	 *   @param string $code_manuel
	 *   @return array Renvoie un tableau d'objets Determine
	 */
	public static function findByManuel($code_manuel) {
		$query = "SELECT * FROM determine WHERE code_manuel='". $code_manuel ."'";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Determine();
				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("tarif", $row["tarif"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder All.
	 *
	 *   Renvoie toutes les lignes de la table determine 
	 *   sous la forme d'un tableau d'objets Determine.
	 *  
	 *   @static
	 *   @return array Renvoie un tableau d'objets Determine
	 */
	public static function findAll() {
		$query = "SELECT * FROM determine";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Determine();
				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("tarif", $row["tarif"]);
				$all[] = $o;
			}
		}
		return $all;
	}
		
	/**
	 *   Suppression dans la base.
	 *
	 *   Supprime la ligne dans la table corrsepondant à l'objet Determine actuel.
	 *   L'objet Determine doit posséder un identifiant (oid).
	 *
	 *   @return int Le nombre de lignes qui ont été supprimées
	 */
	public function delete() {
		if ((!isset($this->code_etat)) && (!isset($this->code_manuel))) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot delete");
		}
		
		$del_query = "DELETE FROM determine WHERE code_etat= ". $this->code_etat ." AND code_manuel='". $this->code_manuel ."'";
		
		try {
			return Base::doUpdate($del_query);
		}catch(BaseException $e){
			echo "[Determine::delete] - ";
			echo $e->__toString();
			echo "<br>";
			exit();
		}
	}
	
	/**
	 *   Sauvegarde dans la base.
	 *
	 *   Enregistre l'état de l'objet Determine dans la table determine.
	 *   Si l'article posséde un identifiant : Mise à jour de la ligne correspondante.
	 *   Sinon : Insertion dans une nouvelle ligne.
	 */
	public function save() {
		if ((!isset($this->code_etat)) && (!isset($this->code_manuel)))
			return $this->insert();
		else
			return $this->update();
	}
	
	/**
	 * #@-
	 */			
	
	/**
	 *   Insertion dans la base.
	 *
	 *   Insére l'objet Determine comme une nouvelle ligne dans la table.
	 *
	 *   @access public
	 *   @return int Nombre de lignes insérées
	 */					
	public function insert() {
	
		$save_query = "INSERT INTO determine (code_etat, code_manuel, tarif) VALUES ( " . 	
		(isset($this->code_etat)   ? "$this->code_etat" : "null").",".
		(isset($this->code_manuel) ? "'$this->code_manuel'" : "null").",".	
		(isset($this->tarif)       ? "$this->tarif" : "null").")";
		try {
			$aff_rows = Base::doUpdate($save_query);				
			return $aff_rows;
			
		} catch(BaseException $e){
			echo "[Determine::insert] - ";
			echo $e->__toString();
			echo "<br/>";
			exit();
		}
	}		
		
	/**
	 *   Mise à jour de la ligne courante.
	 *   
	 *   Sauvegarde l'objet Determine courant dans la base en faisant un update,
	 *   l'identifiant de l'objet doit exister (insert obligatoire auparavant).
	 *   Méthode privée - La méthode publique s'appelle save().
	 *
	 *   @acess private
	 *   @return int Nombre de lignes mises à jour
	 */
	private function update() {	
		if ((!isset($this->code_etat)) && (!isset($this->code_manuel))) {
			throw new DetermineException(__CLASS__ . " : Primary Key undefined : cannot update");
		} 
		$save_query = "UPDATE determine SET tarif = " . (isset($this->tarif)       ? "$this->tarif" : "null") . "  							
		WHERE code_etat = ". $this->code_etat ." AND code_manuel= '". $this->code_manuel ."'";
		
		try {
			$aff_rows = Base::doUpdate($save_query);
				
			return $aff_rows;
				
		} catch(BaseException $e){
			echo "[Determine::update] - ";
		  	echo $e->__toString();
		  	echo "<br/>";
			exit();
		}
	}
}
?>