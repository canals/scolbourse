<?php 
/**
 * File: Manuel.class.php
 *
 * @author SUSTAITA Luis
 * @package model
 */

/** 
 * Classe Manuel : un Active Record sur la table manuel
 * @package model
 */
 
class Manuel{
	
	/**
	 * #@+
	 * @access private
	 */
	
	/**
	 *	Identifiant d'un manuel
	 *	@var string (20 - database field size)
	 */
  	private $code_manuel;
	
	/**
	 *	Titre du manuel
	 *	@var string (128 - database field size)
	 */
	private $titre_manuel;
	
	/**
	 *	Matière du manuel
	 *	@var string (64 - database field size)
	 */
	private $matiere_manuel;
	
	/**
	 *	Classe du manuel
	 *	@var string (20 - database field size)
	 */
	private $classe_manuel;
	
	/**
	 *	Editeur du manuel
	 *	@var string (100 - database field size)
	 */
	private $editeur_manuel;
	
	/**
	 *	Date d'&eacute;dition du manuel
	 *	@var string (10 - database field size)
	 */
	private $date_edition_manuel;
	
	/**
	 *	Tarif du manuel quand il est neuf
	 *	@var double (8,2 - database field size)
	 */
	private $tarif_neuf_manuel;
	
	/**
	 *	Disponibilité de ce manuel (occasion)
	 *	@var boolean (1 - database field size)
	 */
	private $dispo_occasion_manuel;
	
	/**
	 *	Disponibilité de ce manuel (neuf)
	 *	@var boolean (1 - database field size)
	 */
	private $dispo_neuf_manuel;
	
	/**
	 * #@-
	 */
	
	/**
	 * #@+
	 * @access public
	 */
	
	/**
     *  Constructeur de la classe Manuel.
     *
     *  Fabrique un nouvel objet Manuel vide.
     */
	public function __construct(){
		// constructor logic
	}
	
	/**
	 *  Magic pour imprimer.
	 *
	 *  Fonction Magic retournant une chaine de caract&eacute;res imprimable
	 *  pour imprimer facilement un objet Article.
	 *
	 *  @return string
	 */
    public function __toString() {
        return "[Object:Manuel] code_manuel: " . $this->code_manuel . " : 
				   titre_manuel  " . $this->titre_manuel . " : 
				   matiere_manuel " . $this->matiere_manuel . " : 
				   classe_manuel " . $this->classe_manuel . " : 
				   editeur_manuel " . $this->editeur_manuel . " : 
				   date_edition_manuel " . $this->date_edition_manuel . " : 
				   tarif_neuf_manuel " . $this->tarif_neuf_manuel . " : 
				   dispo_occasion_manuel " . $this->dispo_occasion_manuel . " : 
				   dispo_neuf_manuel " . $this->dispo_neuf_manuel;
    }
	
	
	/**
	 *   Getter g&eacute;n&eacute;rique.
	 *
	 *   Fonction d'accés aux attributs d'un objet Manuel.
	 *   Reçoit en paramètre le nom de l'attribut accédé
	 *   et retourne sa valeur.
	 *  
	 *   @param string $attr_name Le nom de l'attribut
	 *   @return mixed
	 */
	public function getAttr($attr_name){
		return $this->$attr_name;
	}
	
	/**
	 *   Setter générique.
	 *
	 *   Fonction de modification des attributs d'un objet Manuel.
	 *   Reçoit en paramétre le nom de l'attribut modifié et la nouvelle valeur.
	 *  
	 *   @param string $attr_name Le nom de l'attribut à modifier 
	 *   @param mixed $attr_val La nouvelle valeur
	 *   @return mixed La nouvelle valeur de l'attribut
	 */
	public function setAttr($attr_name, $attr_val){
		$this->$attr_name = $attr_val;
		return $attr_val;
	}
	
	/**
	 *   Finder sur l'id.
	 *
	 *   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	 *   retourne un objet Article
	 *  
	 *   @static
	 *   @param int $code_manuel OID à rechercher
	 *   @return Manuel Renvoie un objet de type Manuel
 	 */
	public static function findById($code_manuel) {	
		$query = "SELECT * FROM manuel WHERE code_manuel='" . $code_manuel."'";
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row = $dbres[0];
			$o = new Manuel();
			$o->setAttr("code_manuel", $row["code_manuel"]);
			$o->setAttr("titre_manuel", $row["titre_manuel"]);
			$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
			$o->setAttr("classe_manuel", $row["classe_manuel"]);
			$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
			$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
			$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
			$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
			$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);		
		} 
		return $o;
	}
	
	/**
	 *   Finder par Titre.
	 *
	 *   Renvoie toutes les lignes de la table manuel qui ont le même titre (ou qui se ressemble) que le parametre $titre_manuel
	 *   sous la forme d'un tableau d'objets de type Manuel.
	 *  
	 *   @static
	 *   @param string $titre_manuel Titre du manuel à chercher
	 *   @param string $order The name of the field to order by in the SELECT query (code_manuel par défaut)
	 *   @return array Renvoie Un tableau d'objets Manuel
	 */
	public static function findByTitre($titre_manuel, $order = "code_manuel") {
		// Etablir l'order de la requete
		$orderBy = " ORDER BY " . $order;
							
		$query = "SELECT * FROM manuel WHERE (titre_manuel LIKE '%" . $titre_manuel . "%') " . $orderBy .";";
		
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);		
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder par Mati&egrave;re.
	 *
	 *   Renvoie toutes les lignes de la table manuel qui ont le même titre (ou qui se ressemble) que le parametre $titre_manuel
	 *   sous la forme d'un tableau d'objets de type Manuel.
	 *  
	 *   @static
	 *   @param string $matiere_manuel Titre du manuel à chercher
	 *   @param string $order The name of the field to order by in the SELECT query (code_manuel par défaut)
	 *   @return array Renvoie un tableau d'objets Manuel
	 */
	public static function findByMatiere($matiere_manuel, $order = "code_manuel") {
		// Etablir l'ordre de la requête
		$orderBy = " ORDER BY " . $order;
							
		$query = "SELECT * FROM manuel WHERE (matiere_manuel LIKE '%" . $matiere_manuel . "%') " . $orderBy .";";
		
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder par Classe.
	 *
	 *   Renvoie toutes les lignes de la table manuel qui ont la même classe (ou qui se ressemble) que le param&egrave;tre $classe_manuel
	 *   sous la forme d'un tableau d'objets de type Manuel.
	 *  
	 *   @static
	 *   @param string $classe_manuel Classe du manuel à chercher
	 *   @param string $order The name of the field to order by in the SELECT query (code_manuel par défaut)
	 *   @return array Renvoie un tableau d'objets Manuel
	 */
	public static function findByCode($code_manuel, $order = "code_manuel") {
		// Etablir l'ordre de la requête
		$orderBy = " ORDER BY " . $order;							
		$query = "SELECT * FROM manuel WHERE (code_manuel LIKE '%" . $code_manuel . "%') " . $orderBy .";";
	
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {			
			foreach ( $dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder par Editeur.
	 *
	 *   Renvoie toutes les lignes de la table manuel qui ont le même éditeur (ou qui se ressemble) que 
	 *   le param&egrave;tre $editeur_manuel sous la forme d'un tableau d'objets de type Manuel.
	 *  
	 *   @static
	 *   @param string $editeur_manuel Editeur du manuel à chercher
	 *   @param string $order The name of the field to order by in the SELECT query (code_manuel par défaut)
	 *   @return array Renvoie un tableau d'objets Manuel
	 */
	public static function findByEditeur($editeur_manuel, $order = "code_manuel") {
		// Etablir l'ordre de la requête
		$orderBy = " ORDER BY " . $order;
							
		$query = "SELECT * FROM manuel WHERE (editeur_manuel LIKE '%" . $editeur_manuel . "%') " . $orderBy .";";
		
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder par Date d'édition.
	 *
	 *   Renvoie toutes les lignes de la table manuel qui ont le même éditeur (ou qui se ressemble) que 
	 *   le param&egrave;tre $date_edition_manuel sous la forme d'un tableau d'objets de type Manuel.
	 *  
	 *   @static
	 *   @param string $date_edition_manuel Date d'&eacute;dition du manuel à chercher
	 *   @param string $order The name of the field to order by in the SELECT query (code_manuel par défaut)
	 *   @return array Renvoie un tableau d'objets Manuel
	 */
	public static function findByDateEdition($date_edition_manuel, $order = "code_manuel") {
		// Etablir l'ordre de la requête
		$orderBy = " ORDER BY " . $order;
							
		$query = "SELECT * FROM manuel WHERE (date_edition_manuel LIKE '%" . $date_edition_manuel . "%') " . $orderBy .";";
		
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
	 *   Finder All.
	 *
	 *   Renvoie toutes les lignes de la table manuel 
	 *   sous la forme d'un tableau d'objets de type Manuel
	 *  
	 *   @static
	 *   @param string $order The name of the field to order by in the SELECT query (idArticle par défaut)
	 *   @return array Renvoie un tableau d'objets Manuel
	 */
	public static function findAll($order = "code_manuel") {
		// Etablir l'order de la requete
		$orderBy = " ORDER BY " . $order;
	
		$query = "SELECT * FROM manuel" . $orderBy .";";

		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Manuel();
				$o->setAttr("code_manuel", $row["code_manuel"]);
				$o->setAttr("titre_manuel", $row["titre_manuel"]);
				$o->setAttr("matiere_manuel", $row["matiere_manuel"]);
				$o->setAttr("classe_manuel", $row["classe_manuel"]);
				$o->setAttr("editeur_manuel", $row["editeur_manuel"]);
				$o->setAttr("date_edition_manuel", $row["date_edition_manuel"]);
				$o->setAttr("tarif_neuf_manuel", $row["tarif_neuf_manuel"]);			
				$o->setAttr("dispo_occasion_manuel", $row["dispo_occasion_manuel"]);			
				$o->setAttr("dispo_neuf_manuel", $row["dispo_neuf_manuel"]);
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
  	 *   Suppression dans la base.
   	 * 
   	 *   Supprime la ligne dans la table corrsepondant à l'objet courant.
   	 *   L'objet doit posséder un OID.
	 *   
	 *   @return int Le nombre de lignes supprimées (en cas de succès)
   	 */
	public function delete(){
	   if(!isset($this->code_manuel)){
			throw new ManuelException(__CLASS__ . "Primary Key undefined : can't delete");
	   }

	   $delete_query = "DELETE FROM manuel WHERE code_manuel = " . $this->code_manuel;

	   try{
			return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
			echo "[Manuel::delete] - ";
			echo $e->__toString();
			echo "<br>";
	   }
	}
	
	/**
   	 *   Sauvegarde dans la base.
     *
     *   Enregistre l'état de l'objet dans la table
     *   Si l'objet posséde un identifiant : mise à jour de la ligne correspondante.
     *   Sinon : insertion dans une nouvelle ligne.
     *
     *   @return int Le nombre de lignes touchées
     */
	public function save() {
    	$manuel = Manuel::findById($this->code_manuel);	
		if ($manuel==null) {
      		return $this->insert();
    	} else {
      		return $this->update();
    	}
    }
	
	/**
	 * #@-
	 */
	 
	/**
     *   Insertion dans la base.
     *
     *   Insére l'objet comme une nouvelle ligne dans la table
     *   l'objet doit posséder un identifiant (code_manuel),
	 *   sinon, une exception va être produite et l'objet ne sera pas inséré.
     *
	 *   @access private
     *   @return int nombre de lignes insérées 
     */									
  	public function insert() {    	
		$save_query = "INSERT INTO manuel (code_manuel, titre_manuel, matiere_manuel, classe_manuel," .
		"editeur_manuel, date_edition_manuel, tarif_neuf_manuel, dispo_occasion_manuel, dispo_neuf_manuel" .
		") VALUES (".
		  (isset($this->code_manuel) ? "'$this->code_manuel'" : "") . "," .
		  (isset($this->titre_manuel) ? "'$this->titre_manuel'" : "null") . "," .
		  (isset($this->matiere_manuel) ? "'$this->matiere_manuel'" : "null") . "," .
		  (isset($this->classe_manuel) ? "'$this->classe_manuel'" : "null") . "," .
		  (isset($this->editeur_manuel) ? "'$this->editeur_manuel'" : "null") . "," .
		  (isset($this->date_edition_manuel) ? "'$this->date_edition_manuel'" : "null") . "," .
		  (isset($this->tarif_neuf_manuel) ? "'$this->tarif_neuf_manuel'" : "null") . "," .
		  (isset($this->dispo_occasion_manuel) ? "'$this->dispo_occasion_manuel'" : "1") . "," .
		  (isset($this->dispo_neuf_manuel) ? "'$this->dispo_neuf_manuel'" : "1") .")";
		  
		
		
		  
    	//try{
      		$aff_rows = Base::doUpdate($save_query);
      		return $aff_rows;
    	/*}catch(BaseException $e){
      		echo "[Manuel::insert] - ";
			echo $e->__toString();
			echo "<br/>";
    	}*/
  	}
	
	/**
	 *   Mise à jour de la ligne courante.
	 *   
	 *   Sauvegarde l'objet Manuel dans la base en faisant un update.
	 *   L'identifiant de la famille doit exister (insert obligatoire auparavant)
	 *  
	 *   @acess private
	 *   @return int Nombre de lignes mises à jour
	 */									
  	public function update() {
    	if (!isset($this->code_manuel)) {
      		throw new ManuelException(__CLASS__ . " : Primary Key undefined : cannot update");
    	}     	
		$save_query = "UPDATE manuel SET titre_manuel= " . (isset($this->titre_manuel) ? "'$this->titre_manuel'" : "null") . ", " .
					"matiere_manuel= " . (isset($this->matiere_manuel) ? "'$this->matiere_manuel'" : "null") . ", " .
					"classe_manuel= " . (isset($this->classe_manuel) ? "'$this->classe_manuel'" : "null") . ", " .
					"editeur_manuel= " . (isset($this->editeur_manuel) ? "'$this->editeur_manuel'" : "null") . ", " .
					"date_edition_manuel= " . (isset($this->date_edition_manuel) ? "'$this->date_edition_manuel'" : "null") . ", " .
					"tarif_neuf_manuel= " . (isset($this->tarif_neuf_manuel) ? "'$this->tarif_neuf_manuel'" : "null") . ", " .
					"dispo_occasion_manuel= " . (isset($this->dispo_occasion_manuel) ? "'$this->dispo_occasion_manuel'" : "1") . "," .
					"dispo_neuf_manuel= " . (isset($this->dispo_neuf_manuel) ? "'$this->dispo_neuf_manuel'" : "1") .
					" WHERE code_manuel = '" . $this->code_manuel . "'";
					
		
					
					
    	try{
      		$aff_rows = Base::doUpdate($save_query);
      		return $aff_rows;
    	}catch(BaseException $e){
      		echo "[Manuel::update] - ";
			echo $e->__toString();
			echo "<br/>";
    	}
  	}
	
} // Fin de la classe 'Manuel' 
?>
