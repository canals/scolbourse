<?php 
  /**
   * File: Etat.class.php 
   *
   * @author 
   * @package model
   */
   
   /**
    *	class Etat
    *	La classe Etat : ActiveRecord de la table "etat"
    */
  class Etat{
  
    /**
	 *	Identifiant d'un etat (auto_increment)
	 *	@access private
	 *	@var integer (5 - database field size)
	 */
  	private $code_etat;
	
	/**
	 *	Libelle de l'etat
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $libelle_etat;
	
	/**
	 *	Pourcentage de l'etat
	 *	@access private
	 *	@var integer (3 - database field size)
	 */
	private $pourcentage_etat;
	
	/**
	 *  Constructeur de la classe Etat
	 *
	 *  fabrique un nouvel objet Etat vide
	 */
	public function __construct(){
		// constructor logic
	}
	
	/**
   	 *  Fonction pour imprimer un objet Etat
     *
	 *  @access public
     	 *  @return String 
     	 */
    	public function __toString() {
        	return "[Object:" . __CLASS__ . "] code_etat:   " . $this->code_etat . ":
				   libelle_etat  " . $this->libelle_etat . ":
				   pourcentage_etat " . $this->pourcentage_etat ;
    	}
	
	
	/**
	 *	Getter Generique
	 *	
	 *	@access public
	 *	@param String $attributeName Le nom d'attribut à obtenir
	 *	@return mixed
	 */
	public function getAttr($attributeName){
		return $this->$attributeName;
	}
	
	/**
	 *	Setter Generique
	 *	
	 *	@access public
	 *      @param String $attributeName Le nom d'attribut à modifier
	 *      @param mixed $value Valeur à établir à l'attribut
	 *	@return mixed
	 */
	public function setAttr($attributeName, $value){
		$this->$attributeName = $value;
		return $value;
	}

	/**
	 *   Finder par ID
	 *
	 *   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	 *   retourne un objet Etat
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $idArticle OID to find
	 *   @return objet Etat
	 */
	public static function findById($code_etat) {
		$query = "SELECT * FROM etat WHERE code_etat=". $code_etat;
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Etat();
			$o->setAttr("code_etat", $row["code_etat"]);
			$o->setAttr("libelle_etat", $row["libelle_etat"]);
			$o->setAttr("pourcentage_etat", $row["pourcentage_etat"]);
		} 
		return $o;
	}

	/**
	 *   Finder Par Nom
	 *
	 *   Renvoie toutes les lignes de la table etat qui ont le même libelle de etat que le parametre $libelle
	 *   sous la forme d'un tableau d'objets Etat
	 *  
	 *   @access public
	 *   @static
	 *   @param String $nom Nom de etat à chercher
	 *   @return Array renvoie un tableau d'objets du type Etat
	 */	
	public static function findByNom($libelle) {
		$query = "SELECT * FROM etat WHERE (libelle_etat LIKE '%" . $libelle . "%') ORDER BY code_etat";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Etat();

				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("libelle_etat", $row["libelle_etat"]);
				$o->setAttr("pourcentage_etat", $row["pourcentage_etat"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder Par Pourcentage d'etat
	 *
	 *   Renvoie toutes les lignes de la table etat qui ont le même pourcentage que le parametre $num
	 *   sous la forme d'un tableau d'objets Etat
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num Pourcentage à chercher
	 *   @return Array renvoie un tableau d'objets du type Etat
	 */	
	public static function findByPourcentage($num) {
		$query = "SELECT * FROM etat WHERE (pourcentage_etat LIKE " . $num . ") ORDER BY code_etat";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Etat();

				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("libelle_etat", $row["libelle_etat"]);
				$o->setAttr("pourcentage_etat", $row["pourcentage_etat"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table etat
	 *   sous la forme d'un tableau d'article
	 *  
	 *   @access public
	 *   @static
	 *   @return Array renvoie un tableau d'objets du type Etat
	 */	
	public static function findAll() {
		$query = "SELECT * FROM etat ORDER BY code_etat";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Etat();

				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("libelle_etat", $row["libelle_etat"]);
				$o->setAttr("pourcentage_etat", $row["pourcentage_etat"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
   	 *   Sauvegarde dans la base
	 *
	 *   Enregistre l'état de l'objet dans la table
	 *   Si l'objet posséde un identifiant : mise à jour de la ligne correspondante
	 *   Sinon : insertion dans une nouvelle ligne
	 *
	 *   @access public
	 *   @return int Le nombre de lignes touchées
	 */
	public function save() {
	   if (!isset($this->code_etat)) {
			return $this->insert();
	   } else {
			return $this->update();
	   }
    }
	
	/**
	 *   Insertion dans la base
	 *
	 *   Insére l'objet comme une nouvelle ligne dans la table
	 *
	 *   @access private
	 *   @return int nombre de lignes insérées 
	 */									
  	private function insert() { 
	        $save_query = "INSERT INTO etat (libelle_etat, pourcentage_etat) VALUES (".
		(isset($this->libelle_etat) ? "'$this->libelle_etat'" : "null") . " , " .
                (isset($this->pourcentage_etat) ? $this->pourcentage_etat : "null") . ")";
    		try{
      			$aff_rows = Base::doUpdate($save_query);
                        $this->setAttr("code_etat", Base::getLastId("etat","code_etat"));
      			return $aff_rows;
    		}catch(BaseException $e){
      			echo "[Etat::insert] - ";
				echo $e->__toString();
				echo "<br>";
    		}
  	}

	/**
  	 *   Suppression dans la base
   	 * 
   	 *   Supprime la ligne dans la table corrsepondant à l'objet courant
   	 *   L'objet doit posséder un OID
	 *   
	 *   @access public
	 *   @return int Le nombre de lignes touches (en cas de success)
   	 */
	public function delete(){
	   if(!isset($this->code_etat)){
		throw new EtatException(__CLASS__ . "Primary Key undefined : can't delete");
	   }

	   $delete_query = "DELETE FROM etat WHERE code_etat = " . $this->code_etat;

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
			echo "[Etat::delete] - ";
			echo $e->__toString();
			echo "<br>";
	   }
	}

	/**
	 *   Mise à jour de la ligne courante
	 *   
	 *   Sauvegarde la etat courant dans la base en faisant un update
	 *   l'identifiant de la etat doit exister (insert obligatoire auparavant)
	 *   méthode privée - la méthode publique s'appelle save
	 *   @acess private
	 *   @return int nombre de lignes mises à jour
	 */
	private function update(){
	   if(!isset($this->code_etat)){
		throw new EtatException(__CLASS__ . ": Primary Key undefined : can't update");
	   }

	   $save_query = "UPDATE  `etat` SET  `libelle_etat` = " . (isset($this->libelle_etat) ? "'$this->libelle_etat'" : "null") . ",
                     `pourcentage_etat` = " . (isset($this->pourcentage_etat) ? "'$this->pourcentage_etat'" : "null") . "
				     WHERE  `etat`.`code_etat` = " . $this->code_etat;
	   try{
	  	  return Base::doUpdate($save_query);
	   }
	   catch(BaseException $e){
		  echo "[Etat::update] - ";
		  echo $e->__toString();
		  echo "<br>";
	   }
	}
	
 } // Fin de la classe Etat
?>