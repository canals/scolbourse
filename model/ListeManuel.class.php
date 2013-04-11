<?php 
  /**
   * File: ListeManuel.class.php 
   *
   * @author 
   * @package model
   */
   
   /**
    *	class ListeManuel
    *	La classe ListeManuel : ActiveRecord de la table "liste"
    */
  class ListeManuel{
  
    /**
	 *	Identifiant d'un manuel (O par défaut)
	 *	@access private
	 *	@var String (20 - database field size)
	 */
  	private $code_manuel;
	
	/**
	 *	Libelle de la liste
	 *	@access private
	 *	@var integer (5 - database field size)
	 */
	private $code_liste;
	
	/**
	 *	Classe de la liste
	 *	@access private
	 *	@var integer (2 - database field size)
	 */
	private $num_manuel_liste;
	
	/**
     *  Constructeur de la classe ListeManuel
     *
     *  fabrique un nouvel objet ListeManuel vide
     */
	public function __construct(){
		// constructor logic
	}
	
	/**
   	 *  Fonction pour imprimer un objet ListeManuel
     *
	 *  @access public
     *  @return String 
     */
    public function __toString() {
        return "[Object:ListeManuel] code_manuel:   " . $this->code_manuel . ":
				code_liste  " . $this->code_liste . ":
				num_manuel_liste " . $this->num_manuel_liste ;
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
	 *   retourne un objet ListeManuel
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $idArticle OID to find
	 *   @return objet ListeManuel
	 */
	public static function findById($code_manuel, $code_liste) {
		$query = "SELECT * FROM liste_manuel WHERE code_manuel='". $code_manuel . "' AND code_liste=" . $code_liste;		
		$o = null;
		try {
			$dbres = Base::doSelect($query); 					
			if(count($dbres) == 1) {				
				$row = $dbres[0];
				$o = new ListeManuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("num_manuel_liste", $row["num_manuel_liste"]);
			} 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		
		return $o;
	}
	
	/**
	 *   Finder Par classe d'une liste
	 *
	 *   Renvoie toutes les lignes de la table liste avec une description de classe proche à le parametre $classe
	 *   sous la forme d'un tableau d'objets ListeManuel
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num numéro de manuel-liste à chercher
	 *   @return Array renvoie un tableau d'objets du type ListeManuel
	 */	
	public static function findByNumManuelListe($num) {
		$query = "SELECT * FROM liste_manuel WHERE (num_manuel_liste LIKE " . $num . ") ORDER BY code_manuel";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new ListeManuel();

				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("num_manuel_liste", $row["num_manuel_liste"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	public static function findByCodeListe($num) {
		$query = "SELECT * FROM liste_manuel WHERE code_liste = $num  ORDER BY num_manuel_liste";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new ListeManuel();

				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("num_manuel_liste", $row["num_manuel_liste"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table liste
	 *   sous la forme d'un tableau d'article
	 *  
	 *   @access public
	 *   @static
	 *   @return Array renvoie un tableau d'objets du type ListeManuel
	 */	
	public static function findAll() {
		$query = "SELECT * FROM liste_manuel ORDER BY code_manuel";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new ListeManuel();

				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("num_manuel_liste", $row["num_manuel_liste"]);
				
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
		
		$man_liste = ListeManuel::findById($this->code_manuel,$this->code_liste);
		if ($man_liste==null) {
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
  	public function insert() { 
		if(!isset($this->code_manuel) || !isset($this->code_liste)){
		   throw new ListeManuelException(__CLASS__ . ": Primary Key undefined : cannot insert");
	   	}
	
		$save_query = "INSERT INTO liste_manuel (code_manuel, code_liste, num_manuel_liste) VALUES ('$this->code_manuel', " . 
		"$this->code_liste" . (isset($this->num_manuel_liste) ? " , $this->num_manuel_liste" : ", null") . ")";
					
		
		
		
		//try{
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
		/*}catch(BaseException $e){
			echo "[ListeManuel::insert] - ";
		echo $e->__toString();
		echo "<br>";
		}*/
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
	   if(!isset($this->code_manuel) || !isset($this->code_liste)){
		throw new ListeManuelException(__CLASS__ . "Primary Key undefined : can't delete");
	   }

	   $delete_query = "DELETE FROM liste_manuel WHERE code_manuel = '" . $this->code_manuel ."' AND code_liste=" . $this->code_liste;

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
		echo "[ListeManuel::delete] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}
	
	public static function deleteByCode($codeManuel){
	   $delete_query = "DELETE FROM liste_manuel WHERE code_manuel = '" . $codeManuel ."'";

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
		echo "[ListeManuel::delete] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}

	/**
	 *   Mise à jour de la ligne courante
	 *   
	 *   Sauvegarde la liste courant dans la base en faisant un update
	 *   l'identifiant de la liste doit exister (insert obligatoire auparavant)
	 *   méthode privée - la méthode publique s'appelle save
	 *   @acess private
	 *   @return int nombre de lignes mises à jour
	 */
	private function update(){
	   if(!isset($this->code_manuel)){
		  throw new ListeManuelException(__CLASS__ . ": Primary Key undefined : can't update");
	   }

	   $save_query = "UPDATE liste_manuel SET
                     num_manuel_liste= " . (isset($this->num_manuel_liste) ? "$this->num_manuel_liste" : "null") . "
				 	 WHERE code_manuel='" . $this->code_manuel . "' AND code_liste=" . $this->code_liste;
					 
		
		

	   try{
	  	return Base::doUpdate($save_query);
	   }
	   catch(BaseException $e){
		echo "[ListeManuel::update] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}
	
 } // Fin de la classe ListeManuel
?>
