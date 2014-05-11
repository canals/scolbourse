<?php 
  /**
   * File: Liste.class.php 
   *
   * @author 
   * @package model
   */
   
   /**
    *	class Liste
    *	La classe Liste : ActiveRecord de la table "liste"
    */
  class Liste{
  
    	/**
	 *	Identifiant d'une liste (O par défaut)
	 *	@access private
	 *	@var integer (5 - database field size)
	 */
  	private $code_liste;
	
	/**
	 *	Libelle de la liste
	 *	@access private
	 *	@var String (64 - database field size)
	 */
	private $libelle_liste;
	
	/**
	 *	Classe de la liste
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $classe_liste;
	
	/**
     	 *  Constructeur de la classe Liste
     	 *
     	 *  fabrique un nouvel objet Liste vide
     	 */
	public function __construct(){
		// constructor logic
	}
	
	/**
   	 *  Fonction pour imprimer un objet Liste
     	 *
	 *  @access public
     	 *  @return String 
     	 */
    	public function __toString() {
        	return "[Object:Liste] code_liste:   " . $this->code_liste . ":
				   libelle_liste  " . $this->libelle_liste . ":
				   classe_liste " . $this->classe_liste ;
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
	 *   retourne un objet Liste
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $idArticle OID to find
	 *   @return objet Liste
	 */
	public static function findById($code_liste) {
		$query = "SELECT * FROM liste WHERE code_liste=". $code_liste;
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Liste();
			$o->setAttr("code_liste", $row["code_liste"]);
			$o->setAttr("libelle_liste", $row["libelle_liste"]);
			$o->setAttr("classe_liste", $row["classe_liste"]);
		} 
		return $o;
	}

	/**
	 *   Finder Par Nom
	 *
	 *   Renvoie toutes les lignes de la table liste qui ont le même libelle de liste que le parametre $libelle
	 *   sous la forme d'un tableau d'objets Liste
	 *  
	 *   @access public
	 *   @static
	 *   @param String $nom Nom de liste à chercher
	 *   @return Array renvoie un tableau d'objets du type Liste
	 */	
	public static function findByNom($libelle) {
		$query = "SELECT * FROM liste WHERE (libelle_liste LIKE '%" . $libelle . "%') ORDER BY code_liste";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Liste();

				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("libelle_liste", $row["libelle_liste"]);
				$o->setAttr("classe_liste", $row["classe_liste"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder Par classe d'une liste
	 *
	 *   Renvoie toutes les lignes de la table liste avec une description de classe proche à le parametre $classe
	 *   sous la forme d'un tableau d'objets Liste
	 *  
	 *   @access public
	 *   @static
	 *   @param String $classe Classe à chercher
	 *   @return Array renvoie un tableau d'objets du type Liste
	 */	
	public static function findByClasse($classe) {
		$query = "SELECT * FROM liste WHERE (classe_liste LIKE '%" . $classe . "%') ORDER BY code_liste";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Liste();

				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("libelle_liste", $row["libelle_liste"]);
				$o->setAttr("classe_liste", $row["classe_liste"]);
				
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
	 *   @return Array renvoie un tableau d'objets du type Liste
	 */	
	public static function findAll() {
		$query = "SELECT * FROM liste ORDER BY code_liste";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Liste();

				$o->setAttr("code_liste", $row["code_liste"]);
				$o->setAttr("libelle_liste", $row["libelle_liste"]);
				$o->setAttr("classe_liste", $row["classe_liste"]);
				
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
    	   if (!isset($this->code_liste)) {
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
		$save_query = "INSERT INTO liste (libelle_liste, classe_liste) VALUES (".
		(isset($this->libelle_liste) ? "'$this->libelle_liste'" : "null") . " , " .
                (isset($this->classe_liste) ? "'$this->classe_liste'" : "null") . ")";		
				
		
		
		
				
    		try{
      			$aff_rows = Base::doUpdate($save_query);
				$this->setAttr("code_liste", Base::getLastId("liste","code_liste"));						
      			return $aff_rows;
    		}catch(BaseException $e){
      			echo "[Liste::insert] - ";
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
	   if(!isset($this->code_liste)){
		throw new ListeException(__CLASS__ . "Primary Key undefined : can't delete");
	   }

	   $delete_query = "DELETE FROM liste WHERE code_liste = " . $this->code_liste;

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
		echo "[Liste::delete] - ";
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
	   if(!isset($this->code_liste)){
		throw new ListeException(__CLASS__ . ": Primary Key undefined : can't update");
	   }

	   $save_query = "UPDATE liste SET libelle_liste= " . (isset($this->libelle_liste) ? "'$this->libelle_liste'" : "null") . ",
                                 classe_liste= " . (isset($this->classe_liste) ? "'$this->classe_liste'" : "null") . ",
				 WHERE code_liste=" . $this->code_liste;

		
		
		
	   try{
	  	return Base::doUpdate($save_query);
	   }
	   catch(BaseException $e){
		echo "[Liste::update] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}
	
 } // Fin de la classe Liste
?>
