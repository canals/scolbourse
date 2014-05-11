<?php
/**
 * model.DossiersMontant.class.php : classe qui represente les Paiements des Dossiers
 * @package model
 */

class DossiersMontant {
	// D E S   A T T R I B U T S
		
	/**
	 *  num_dossier_depot afin de retrouver le numero de dossier de depot
	 *  @var $num_dossier_depot
	 **/
	private $num_dossier_depot; 
	
	/**
	 *  montant 
	 *  @var $montant
	 **/
	private $montant; 
	
	// D E S   M E T H O D E S
	
	/**
	*  Constructeur de determine
	*
	*/
	public function __construct() {

	}
	
	/**
	*  Fonction Magic retournant une chaine de caract?res imprimable
	*
	*   @access public
	*   @return String
	*/
	public function __toString() {
		return __CLASS__ . " num_dossier_depot:   ". $this->num_dossier_depot .";";
	}	

	/**
	*   Getter générique
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
	*   fonction de modification des attributs.
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
	*   Retrouve la ligne de la table correspondant à l'ID passé en paramètre
	*  
	*   @static
	*   @param integer $num_dossier_depot 
	*   @return DossiersMontant renvoie le montant du dossier
	*/
	public static function findById($num_dossier_depot) {
		$query = "select * from dossiers_montant where num_dossier_depot=". $num_dossier_depot ;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new DossiersMontant();
			$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
			$o->setAttr("montant", $row["montant"]);			
		} 
		return $o;
	}
	
	/**
	*   Finder sur $montant
	*  
	*   @static
	*   @param decimal $montant
	*   @return Array renvoie un tableau
	*/
	public static function findByMontant($montant) {
		$query = "select * from dossiers_montant where montant='". $montant ."'";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$row= $dbres[0];
				$o = new DossiersMontant();
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("montant", $row["montant"]);			
				$all[]=$o;
			}
		}
		return $all;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table dossiers_montant 
	*   sous la forme d'un tableau
	*  
	*   @static
	*   @return Array renvoie un tableau
	*/	
	public static function findAll() {
		$query = "select * from dossiers_montant";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$row= $dbres[0];
				$o = new DossiersMontant();
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("montant", $row["montant"]);			
				$all[]=$o;
			}
		}
		return $all;
	}
	
	/**
	*   Insertion dans la base
	*
	*   Insére une nouvelle ligne dans la table
	*   @access public
	*   @return int nombre de lignes insérées
	*/				
	public function insert() {
	
		$save_query = "insert into dossiers_montant (num_dossier_depot,montant) values ( " . 	
		(isset($this->num_dossier_depot)     ? "$this->num_dossier_depot" : "null").",".
		(isset($this->montant)         ? "$this->montant" : "null").")" ;
		
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
	*   méthode privée - la méthode publique s'appelle save
	*   @acess private
	*   @return int nombre de lignes mises à jour
	*/
	private function update() {	
		if (!isset($this->num_dossier_depot)) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "update dossiers_montant set 
		num_dossier_depot = "        . (isset($this->num_dossier_depot)        ? "$this->num_dossier_depot" : "null")  . ", 
		montant = "       . (isset($this->montant)       ? "$this->montant" : "null") . "  							
		where num_dossier_depot = ". $this->num_dossier_depot;
		
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
	*   Supprime la ligne dans la table 
	*   @access public
	*/	
	public function delete() {
		if (!isset($this->num_dossier_depot)) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from dossiers_montant where num_dossier_depot= ". $this->num_dossier_depot ;
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
	*   @access public
	*/
	public function save() {
		$dossier = DossiersMontant::findById($this->num_dossier_depot);			
		if ($dossier==null) 
			return $this->insert();
		else
			return $this->update();
	}				
	
	
}
?>
