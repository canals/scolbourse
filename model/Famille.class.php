<?php 
  /**
   * File: Famille.class.php 
   *
   * @author 
   * @package model
   */
   
   /**
    *	class Famille
    *	La classe Famille : ActiveRecord de la table "famille"
    */
  class Famille{
  
    /**
	 *	Identifiant d\"une famille (auto_increment)
	 *	@access private
	 *	@var integer (20 - database field size)
	 */
  	private $num_famille;
	
	/**
	 *	Nom de la famille
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $nom_famille;
	
	/**
	 *	Pr�nom de la famille
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $prenom_famille;
	
	/**
	 *	Premi�re adresse de la famille
	 *	@access private
	 *	@var String (100 - database field size)
	 */
	private $adresse1_famille;
	
	/**
	 *	Deuxi�me adresse de la famille
	 *	@access private
	 *	@var String (100 - database field size)
	 */
	private $adresse2_famille;
	
	/**
	 *	Code postal de l\"adresse de la famille
	 *	@access private
	 *	@var String (5 - database field size)
	 */
	private $code_postal_famille;
	
	/**
	 *	Ville de r�sidence de la famille
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $ville_famille;
	
	/**
	 *	Premi�re adresse (de paiement ou facturation) de la famille
	 *	@access private
	 *	@var String (100 - database field size)
	 */
	private $adresse1_cheque_famille;
	
	/**
	 *	Deuxi�me adresse (de paiement ou facturation) de la famille
	 *	@access private
	 *	@var String (100 - database field size)
	 */
	private $adresse2_cheque_famille;
	
	/**
	 *	Code postal de l\"adresse (de paiement ou facturation) de la famille
	 *	@access private
	 *	@var String (5 - database field size)
	 */
	private $code_postal_cheque_famille;
	
	/**
	 *	Ville de r�sidence (de l\"adresse de paiement ou facturation) de la famille
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $ville_cheque_famille;
	
	/**
	 *	Nom de la famille (paiement ou facturation)
	 *	@access private
	 *	@var String (32 - database field size)
	 */
	private $nom_cheque_famille;
	
	/**
	 *	Num�ro de t�l�phone de la famille
	 *	@access private
	 *	@var String (14 - database field size)
	 */
	private $num_tel_famille;

        /**
	 *	mail de la famille
	 *	@access private
	 *	@var String (14 - database field size)
	 */
	private $mail_famille = 'famille@toto.net';
	
	/**
	 *	
	 *	@access private
	 *	@var String 
	 */
	private $indication_famille;
	
	/**
	 *	
	 *	@access private
	 *	@var String (1 - database field size)
	 */
	private $adherent_association;
	
	/**
	 *
	 *	@access private
	 *	@var String (1 - database field size)
	 */
	private $enlevettfrais;
	
		 
	 /****** COMENTARIOS *************/
	 
	 private $dossierDeDepot;
	 
	 private $dossierDAchat;
	 
	 /********************************/
	 
	 
	 
	 /**
     *  Constructeur de la classe Famille
     *
     *  fabrique un nouvel objet Famille vide
     */
	public function __construct(){
		// constructor logic
	}
	
	/**
   	 *  Fonction pour imprimer un objet Famille
     *
	 *  @access public
     *  @return String 
     */
    public function __toString() {
       	return "[Object:Famille] num_famille:   " . $this->num_famille . ":
			   nom_famille  " . $this->nom_famille . ":
			   prenom_famille " . $this->description . ":
			   adresse1_famille " . $this->adresse1_famille . ":
			   adresse2_famille " . $this->adresse2_famille . ":
			   code_postal_famille " . $this->code_postal_famille . ":
			   ville_famille " . $this->ville_famille . ":
			   adresse1_cheque_famille" . $this->adresse1_cheque_famille . ":
			   adresse2_cheque_famille" . $this->adresse2_cheque_famille . ":
			   code_postal_cheque_famille" . $this->code_postal_cheque_famille . ":
			   ville_cheque_famille" . $this->ville_cheque_famille . ":
			   nom_cheque_famille" . $this->nom_cheque_famille . ":
			   num_tel_famille " . $this->num_tel_famille . ":
			   indication_famille " . $this->indication_famille . ":
			   adherent_association " . $this->adherent_association . ":
			   enlevettfrais " . $this->enlevettfrais ;
    }
	
	
	/**
	 *	Getter Generique
	 *	
	 *	@access public
	 *	@param String $attributeName Le nom d\"attribut � obtenir
	 *	@return mixed
	 */
	public function getAttr($attributeName){
		return $this->$attributeName;
	}
	
	/**
	 *	Setter Generique
	 *	
	 *	@access public
	 *  @param String $attributeName Le nom d\"attribut � modifier
	 *  @param mixed $value Valeur � �tablir � l\"attribut
	 *	@return mixed
	 */
	public function setAttr($attributeName, $value){
		$this->$attributeName = $value;
		return $value;
	}

	/**
	 *   Finder par ID
	 *
	 *   Retrouve la ligne de la table correspondant � l\"ID pass� en param�tre,
	 *   retourne un objet Famille
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num_famille
	 *   @return Objet du type Famille
	 */
	public static function findById($num_famille) {
		$query = "SELECT * FROM famille WHERE num_famille=". $num_famille;
		try {
			$dbres = Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = '';
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Famille();
			$o->setAttr("num_famille", $row["num_famille"]);
			$o->setAttr("nom_famille", $row["nom_famille"]);
			$o->setAttr("prenom_famille", $row["prenom_famille"]);
			$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
			$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
			$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
			$o->setAttr("ville_famille", $row["ville_famille"]);			
			$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                        $o->setAttr("mail_famille", $row["mail_famille"]);
			$o->setAttr("indication_famille", $row["indication_famille"]);
			$o->setAttr("adherent_association", $row["adherent_association"]);
			$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
			
			
			// Chercher le dossier_depot et le dossier_achat
			$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
			$o->setAttr("dossierDeDepot", $depot);			
			
			$achat = DossierDAchat::findById($o->getAttr("num_famille"));			
			$o->setAttr("dossierDAchat", $achat);			
		} 
		return $o;
	}

	/**
	 *   Finder Par Nom
	 *
	 *   Renvoie toutes les lignes de la table famille qui ont le m�me nom de famille que le parametre $nom
	 *   sous la forme d\"un tableau d\"article
	 *  
	 *   @access public
	 *   @static
	 *   @param String $nom Nom de famille � chercher
	 *   @return Array renvoie un tableau d\"objets du type Famille
	 */	
	public static function findByNom($nom) {
		$query = "SELECT * FROM famille WHERE (nom_famille LIKE \"%" . $nom . "%\") ORDER BY nom_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = '';
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));				
				$o->setAttr("dossierDAchat", $achat);	
				
				$all[] = $o;
			}
		}
		return $all;
	}
	
	
	/**
	 *   Finder Par Nom et Prenom
	 *
	 *   @access public
	 *   @static
	 *   @param String $nom Nom de famille � chercher
	 *   @return Array renvoie un tableau d\"objets du type Famille
	 */	
	public static function findByNomPrenom($nom,$prenom) {
		$query = "SELECT * FROM famille WHERE nom_famille = \"" . $nom . "\" and prenom_famille = \"". $prenom ."\"";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = '';
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));				
				$o->setAttr("dossierDAchat", $achat);	
				
				$all[] = $o;
			}
		}
		return $all;
	}
	
	
	/**
	 *   Finder par NumDossier
	 *
	 *   Retrouve la ligne de la table correspondant � l\"ID pass� en param�tre,
	 *   retourne un objet Famille
	 *  
	 *   @access public
	 *   @static
	 *   @param integer $num_famille
	 *   @return Objet du type Famille
	 */
	public static function findByNumDossier($num) {
		$query = "SELECT * FROM famille WHERE num_famille=". $num ." ORDER BY nom_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = '';
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDAchat", $achat);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder Par Num�ro de T�l�phone
	 *
	 *   Renvoie toutes les lignes de la table famille qui ont le m�me Num�ro de T�l�phone que le parametre $num
	 *   sous la forme d\"un tableau d\"article
	 *  
	 *   @access public
	 *   @static
	 *   @param String $num Num�ro de T�l�phone � chercher
	 *   @return Array renvoie un tableau d\"objets du type Famille
	 */	
	public static function findByNumTelephone($num) {
		$query = "SELECT * FROM famille WHERE (num_tel_famille LIKE \"%" . $num . "%\") ORDER BY nom_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = '';
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDAchat", $achat);
				
				$all[] = $o;
			}
		}
		return $all;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table famille
	 *   sous la forme d\"un tableau d\"article
	 *  
	 *   @access public
	 *   @static
	 *   @return Array renvoie un tableau d\"objets du type Famille
	 */	
	public static function findAll() {
		$query = "SELECT * FROM famille ORDER BY nom_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null; $n=count($dbres);
		if(!$n == 0) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDAchat", $achat);
				$all[] = $o;
			}
			//$all['count']=$n; $all['fpcount']=$participe;
		}
		return $all;
	}
	
	/**
	 *   Finder AllParticipe
	 *
	 *   Renvoie toutes les lignes de la table famille
	 *   ayant particip� � la bourse (dossier d�pot ou achat non null)
	 *   sous la forme d\"un tableau de Famille	 *  
	 *   @access public
	 *   @static
	 *   @return Array renvoie un tableau d\"objets du type Famille
	 */	
	public static function findAllParticipe() {
		$query = "SELECT * FROM famille f
		          where exists (select num_dossier_depot from dossier_depot where num_dossier_depot=f.num_famille)
				     OR exists (select num_dossier_achat from dossier_d_achat where num_dossier_achat=f.num_famille)
				  ORDER BY nom_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null; $n=count($dbres);
		if(!$n == 0) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDAchat", $achat);
				$all[] = $o;
			}
			//$all['count']=$n; $all['fpcount']=$participe;
		}
		return $all;
	}	
	
	
	
	public static function findAllTrie() {
		$query = "SELECT * FROM famille ORDER BY num_famille";
		try{
			$dbres = Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = '';
		if(!(count($dbres) == 0)) {
			foreach ($dbres as $i=>$row) {
				$o = new Famille();

				$o->setAttr("num_famille", $row["num_famille"]);
				$o->setAttr("nom_famille", $row["nom_famille"]);
				$o->setAttr("prenom_famille", $row["prenom_famille"]);
				$o->setAttr("adresse1_famille", $row["adresse1_famille"]);
				$o->setAttr("adresse2_famille", $row["adresse2_famille"]);
				$o->setAttr("code_postal_famille", $row["code_postal_famille"]);
				$o->setAttr("ville_famille", $row["ville_famille"]);			
				$o->setAttr("num_tel_famille", $row["num_tel_famille"]);
                                $o->setAttr("mail_famille", $row["mail_famille"]);
				$o->setAttr("indication_famille", $row["indication_famille"]);
				$o->setAttr("adherent_association", $row["adherent_association"]);
				$o->setAttr("enlevettfrais", $row["enlevettfrais"]);
				
				// Chercher le dossier_depot et le dossier_achat
				$depot = DossierDeDepot::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDeDepot", $depot);			
				
				$achat = DossierDAchat::findById($o->getAttr("num_famille"));
				$o->setAttr("dossierDAchat", $achat);
				
				$all[] = $o;
			}
		}
		return $all;
	}
	
	/**
   	 *   Sauvegarde dans la base
     	 *
     	 *   Enregistre l\"�tat de l\"objet dans la table
     	 *   Si l\"objet poss�de un identifiant : mise � jour de la ligne correspondante
     	 *   Sinon : insertion dans une nouvelle ligne
     	 *
	 *   @access public
     	 *   @return int Le nombre de lignes touch�es
     	 */
	public function save() {
    	   if (!isset($this->num_famille)) {
      		  return $this->insert();
    	   } else {
      		  return $this->update();
    	   }
    	}
	
	/**
     	 *   Insertion dans la base
     	 *
     	 *   Ins�re l\"objet comme une nouvelle ligne dans la table
     	 *
	 *   @access private
     	 *   @return int nombre de lignes ins�r�es 
     	 */									
  	private function insert() { 
	        $save_query = "INSERT INTO famille (nom_famille, prenom_famille, adresse1_famille, adresse2_famille," .
												"code_postal_famille, ville_famille,  num_tel_famille, mail_famille, indication_famille " .
											    (isset($this->adherent_association) ? ", adherent_association" : "") . 
												(isset($this->enlevettfrais) ? " , enlevettfrais" : "") . ") 
						  VALUES (" .
                          (isset($this->nom_famille) ? "\"$this->nom_famille\"" : "''") . "," .
 			  (isset($this->prenom_famille) ? "\"$this->prenom_famille\"" : "''") . "," .
			  (isset($this->adresse1_famille) ? "\"$this->adresse1_famille\"" : "''") . "," .
			  (isset($this->adresse2_famille) ? "\"$this->adresse2_famille\"" : "''") . "," .
			  (isset($this->code_postal_famille) ? "\"$this->code_postal_famille\"" : "''") . "," .
			  (isset($this->ville_famille) ? "\"$this->ville_famille\"" : "''") . "," .
			  (isset($this->num_tel_famille) ? "\"$this->num_tel_famille\"" : "''") . "," .
                          (isset($this->mail_famille) ? "\"$this->mail_famille\"" : "''") . "," .
			  (isset($this->indication_famille) ? "\"$this->indication_famille\"" : "''") .
  	  		  (isset($this->adherent_association) ? " , \"$this->adherent_association\"" : "") .
                          (isset($this->enlevettfrais) ? " , \"$this->enlevettfrais\"" : "") .")"  ;
		//echo $save_query;
		$save_query = stripslashes($save_query); //echo $save_query ;
			//$save_query = str_replace("\\"", "", $save_query);			  
			
  		try{
      			$aff_rows = Base::doUpdate($save_query);
				$this->setAttr("num_famille", Base::getLastId("famille","num_famille"));
      			return $aff_rows;
    		}catch(BaseException $e){
      			echo "[Famille::insert] - ";
			echo $e->__toString();
			echo "<br>";
    		}

  	}

	/**
  	 *   Suppression dans la base
   	 * 
   	 *   Supprime la ligne dans la table corrsepondant � l\"objet courant
   	 *   L\"objet doit poss�der un OID
	 *   
	 *   @access public
	 *   @return int Le nombre de lignes touches (en cas de success)
   	 */
	public function delete(){
	   if(!isset($this->num_famille)){
		throw new FamilleException(__CLASS__ . "Primary Key undefined : can\"t delete");
	   }

	   $delete_query = "DELETE FROM famille WHERE num_famille = " . $this->num_famille;

	   try{
		return Base::doUpdate($delete_query);
	   }
	   catch(BaseException $e){
		echo "[Famille::delete] - ";
		echo $e->__toString();
		echo "<br>";
	   }
	}

	/**
	 *   Mise � jour de la ligne courante
	 *   
	 *   Sauvegarde la famille courant dans la base en faisant un update
	 *   l\"identifiant de la famille doit exister (insert obligatoire auparavant)
	 *   m�thode priv�e - la m�thode publique s\"appelle save
	 *   @acess private
	 *   @return int nombre de lignes mises � jour
	 */
	private function update(){
	   if(!isset($this->num_famille)){
		throw new FamilleException(__CLASS__ . ": Primary Key undefined : can\"t update");
	   }

	   $save_query = "UPDATE famille SET nom_famille= " . (isset($this->nom_famille) ? "\"$this->nom_famille\"" : "''") . ",
                 prenom_famille= " . (isset($this->prenom_famille) ? "\"$this->prenom_famille\"" : "''") . ",
				 adresse1_famille= " . (isset($this->adresse1_famille) ? "\"$this->adresse1_famille\"" : "''") . ",
				 adresse2_famille= " . (isset($this->adresse2_famille) ? "\"$this->adresse2_famille\"" : "''") . ",
				 code_postal_famille= " . (isset($this->code_postal_famille) ? "\"$this->code_postal_famille\"" : "''") . ",
				 ville_famille= " . (isset($this->ville_famille) ? "\"$this->ville_famille\"" : "''") . ",
				 num_tel_famille= " . (isset($this->num_tel_famille) ? "\"$this->num_tel_famille\"" : "''") . ",
                                 mail_famille= " . (isset($this->mail_famille) ? "\"$this->mail_famille\"" : "''") . ",
				 indication_famille= " . (isset($this->indication_famille) ? "\"$this->indication_famille\"" : "''") . 
				 (isset($this->adherent_association) ? ", adherent_association=" : "") .
 				 (isset($this->adherent_association) ? "\"$this->adherent_association\"" : "") . 
				 (isset($this->enlevettfrais) ? " , enlevettfrais=" : "") .
				 (isset($this->enlevettfrais) ? "\"$this->enlevettfrais\"" : "") . "
				 WHERE num_famille=$this->num_famille";
			 
						 	
	   try{
			$r = Base::doUpdate($save_query);

			// Mis � jour ses dossiers
			if(isset($this->dossierDeDepot)) {
				$dd = $this->dossierDeDepot; 
				$dd->calculerMontants(); 	
				$dd->save();	 
			} 
			if(isset($this->dossierDAchat)) {
				$da = $this->dossierDAchat;  
				$da->calculerMontants();	
				$da->save();
			}			
			return $r;
		
	   } catch(BaseException $e){
		echo "[Famille::update] - ";
		echo $e->__toString();
		echo "<br>";
		
		echo "<br/><br/>query: " . $save_query;
	   }
	}
	
 } // Fin de la classe Famille
?>
