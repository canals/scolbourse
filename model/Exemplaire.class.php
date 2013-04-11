<?php 
  /**
   * File: Exemplaire.class.php 
   *
   * @author 
   * @package model
   */
   
   /**
    *	class Exemplaire
    *	La classe Exemplaire : ActiveRecord de la table "exemplaire"
    */
  class Exemplaire{
  
	const INVENDU = 0;
	const VENDU   = 1;
	const RENDRE  = 2;
	const ALL = 3;
  
    /**
	 *	Identifiant d'une exemplaire
	 *	@access private
	 *	@var String (20 - database field size - Default 0)
	 */
  	private $code_exemplaire;
	
	/**
	 *	Numéro de dossier-depot
	 *	@access private
	 *	@var integer (20 - database field size)
	 */
	private $num_dossier_depot;
	
	/**
	 *	Numéro de dossier-achat
	 *	@access private
	 *	@var integer (20 - database field size)
	 */
	private $num_dossier_achat;
	
	/**
	 *	Identifiant d'un etat
	 *	@access private
	 *	@var integer (5 - database field size - O par défaut)
	 */
  	private $code_etat;
	
	/**
	 *	Identifiant d'un manuel
	 *	@access private
	 *	@var String (20 - database field size - O par défaut)
	 */
  	private $code_manuel;
	
	/**
	 *	
	 *	@access private
	 *	@var integer (4 - database field size)
	 */
	private $vendu;
	
	/**
	 *	Ville de résidence de la exemplaire
	 *	@access private
	 *	@var String (Date)
	 */
	private $date_vente;
	
	/**
	 *	
	 *	@access private
	 *	@var String (Date)
	 */
	private $date_rendu;
	
	/**
     *  Constructeur de la classe Exemplaire
     *
     *  fabrique un nouvel objet Exemplaire vide
     */
	public function __construct(){
		// constructor logic
	}
	
	/**
   	 *  Fonction pour imprimer un objet Exemplaire
     *
	 *  @access public
     *  @return String 
     */
    public function __toString() {
       	return "[Object:Exemplaire] code_exemplaire:   " . $this->code_exemplaire . ":
			   num_dossier_depot  " . $this->num_dossier_depot . ":
			   num_dossier_achat " . $this->num_dossier_achat . ":
			   code_etat " . $this->code_etat . ":
			   code_manuel " . $this->code_manuel . ":
			   vendu " . $this->vendu . ":
			   date_vente " . $this->date_vente . ":
			   date_rendu " . $this->date_rendu;
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
	 *  @param String $attributeName Le nom d'attribut à modifier
	 *  @param mixed $value Valeur à établir à l'attribut
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
	 *   retourne un objet Exemplaire
	 *  
	 *   @access public
	 *   @static
	 *   @param String $code_exemplaire OID to find
	 *   @return Objet du type Exemplaire
	 */
	public static function findById($code_exemplaire) {
		$query = "SELECT * FROM exemplaire WHERE code_exemplaire=" . $code_exemplaire;
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Exemplaire();
			$o->setAttr("code_exemplaire", $row["code_exemplaire"]);
			$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
			$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
			$o->setAttr("code_etat", $row["code_etat"]);
			$o->setAttr("code_manuel", $row["code_manuel"]);
			$o->setAttr("vendu", $row["vendu"]);
			$o->setAttr("date_vente", $row["date_vente"]);			
			$o->setAttr("date_rendu", $row["date_rendu"]);			
		} 
		return $o;
	}

	/**
	 *   Finder Par Num Dossier-Depot
	 *
	 *   Renvoie toutes les lignes de la table exemplaire qui ont le même nom de exemplaire que le parametre $nom
	 *   sous la forme d'un tableau d'objets du type Exemplaire
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num Num de Dossier-Depot à chercher
	 *   @return Array renvoie un tableau d'objets du type Exemplaire
	 */	
	public static function findByNumDossierDepot($num) {
		$query = "SELECT * FROM exemplaire WHERE (num_dossier_depot LIKE " . $num . ") ORDER BY date_rendu DESC";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Exemplaire();

				$o->setAttr("code_exemplaire", $row["code_exemplaire"]);
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("vendu", $row["vendu"]);
				$o->setAttr("date_vente", $row["date_vente"]);			
				$o->setAttr("date_rendu", $row["date_rendu"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder Par Num Dossier-Achat
	 *
	 *   Renvoie toutes les lignes de la table exemplaire qui ont le même nom de exemplaire que le parametre $num
	 *   sous la forme d'un tableau d'objets du type Exemplaire
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num Num de Dossier-Achat à chercher
	 *   @return Array renvoie un tableau d'objets du type Exemplaire
	 */	
	public static function findByNumDossierAchat($num) {
		$query = "SELECT * FROM exemplaire WHERE (num_dossier_achat LIKE " . $num . ") ORDER BY date_vente DESC";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Exemplaire();

				$o->setAttr("code_exemplaire", $row["code_exemplaire"]);
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("vendu", $row["vendu"]);
				$o->setAttr("date_vente", $row["date_vente"]);			
				$o->setAttr("date_rendu", $row["date_rendu"]);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table exemplaire
	 *   sous la forme d'un tableau d'objets du type Exemplaire
	 *  
	 *   @access public
	 *   @static
	 *   @return Array renvoie un tableau d'objets du type Exemplaire
	 */	
	public static function findAll($w = self::ALL) {
		$query = "SELECT * FROM exemplaire ";
		if  ($w != self::ALL) {
			$query .= "where vendu = $w ";
		}
		$query .= " ORDER BY code_exemplaire, date_rendu DESC";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null; $c= count($dbres);
		if($c > 0) {
			foreach ($dbres as $i=>$row) {
				$o = new Exemplaire();

				$o->setAttr("code_exemplaire", $row["code_exemplaire"]);
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("code_etat", $row["code_etat"]);
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("vendu", $row["vendu"]);
				$o->setAttr("date_vente", $row["date_vente"]);			
				$o->setAttr("date_rendu", $row["date_rendu"]);
				
				$all[] = $o;
			}
			$all['count']=$c;
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
	   $exe = Exemplaire::findById($this->code_exemplaire);
       if ($exe==null) {
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
	    if(!isset($this->code_exemplaire)){
		   throw new ExemplaireException(__CLASS__ . ": Primary Key undefined : cannot insert");
	   	}
	    
		$save_query = "INSERT INTO exemplaire (". (isset($this->code_exemplaire) ? "code_exemplaire," : "") .
		(isset($this->num_dossier_depot) ? "num_dossier_depot," : "") . " num_dossier_achat," .
		(isset($this->code_etat) ? " code_etat," : "") . (isset($this->code_manuel) ? "code_manuel," : "") .
		" vendu, date_vente, date_rendu) VALUES (" .
              (isset($this->code_exemplaire) ? "'$this->code_exemplaire'," : "") . 
 			  (isset($this->num_dossier_depot) ? " '$this->num_dossier_depot'," : "") .
			  (isset($this->num_dossier_achat) ? " '$this->adresse1_exemplaire'" : "null") . "," .
			  (isset($this->code_etat) ? " '$this->code_etat'," : "") .
			  (isset($this->code_manuel) ? " '$this->code_manuel'," : "") .
			  (isset($this->vendu) ? " '$this->vendu'" : "null") . "," .
			  (isset($this->date_vente) ? " '$this->date_vente'" : "null") . "," .
              (isset($this->date_rendu) ? " '$this->date_rendu'" : "null") .")"  ;
			  
		try{
			$aff_rows = Base::doUpdate($save_query);
			return $aff_rows;
		}catch(BaseException $e){      			
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
	   if(!isset($this->code_exemplaire)){
		throw new ExemplaireException(__CLASS__ . "Primary Key undefined : can't delete");
	   }

	   $delete_query = "DELETE FROM exemplaire WHERE code_exemplaire = " . $this->code_exemplaire;

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
		echo "[Exemplaire::delete] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}

	/**
	 *   Mise à jour de la ligne courante
	 *   
	 *   Sauvegarde la exemplaire courant dans la base en faisant un update
	 *   l'identifiant de la exemplaire doit exister (insert obligatoire auparavant)
	 *   méthode privée - la méthode publique s'appelle save
	 *   @acess private
	 *   @return int nombre de lignes mises à jour
	 */
	private function update(){
	   if(!isset($this->code_exemplaire)){
		throw new ExemplaireException(__CLASS__ . ": Primary Key undefined : can't update");
	   }

	   $save_query = "UPDATE exemplaire SET num_dossier_depot=" . (isset($this->num_dossier_depot) ? "'$this->num_dossier_depot'" : "") . ",
                 num_dossier_achat=" . (isset($this->num_dossier_achat) ? "'$this->num_dossier_achat'" : "null") . ",
				 code_etat= " . (isset($this->code_etat) ? $this->code_etat : "") . ",
				 code_manuel= " . (isset($this->code_manuel) ? "'$this->code_manuel'" : "") . ",
				 vendu= " . (isset($this->vendu) ? $this->vendu : "null") . ",
				 date_vente= " . (isset($this->date_vente) ? "'$this->date_vente'" : "null") . ",
				 date_rendu= " . (isset($this->date_rendu) ? "'$this->date_rendu'" : "null") .  
				 "WHERE code_exemplaire='" . $this->code_exemplaire . "'";				 

	   try{
	  	return Base::doUpdate($save_query);
	   }
	   catch(BaseException $e){
		echo "[Exemplaire::update] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}
	
 } // Fin de la classe Exemplaire
?>
