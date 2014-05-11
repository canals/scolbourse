<?php
/**
 * model.Regle.class.php : classe qui represente les Regles
 * @package model
 */

class Regle { 
 	 	 	 	 	
	// D E S   A T T R I B U T S
		
	/**
	 *  num_regle afin de retrouver le numero de regle
	 *  @var $num_regle
	 **/
	private $num_regle; 
	
	/**
	 *  num_dossier_achat afin de retrouver le numéro de dossier
	 *  @var $num_dossier_achat
	 **/
	private $num_dossier_achat; 
	
	/**
	 *  code_reglement afin de retrouver le code de reglement
	 *  @var $code_reglement
	 **/
	private $code_reglement; 
	
	/**
	 *  montant afin de retrouver le montant
	 *  @var $montant
	 **/
	private $montant; 


	/**
	 *  datereg afin de retrouver la date de reglement
	 *  @var $datereg
	 **/
	private $datereg; 

	
	/**
	 *  numero_cheque afin de retrouver le numéro du chèque
	 *  @var $numero_cheque
	 **/
	private $numero_cheque; 


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
		return __CLASS__ . " num_regle:   ". $this->num_regle .";";
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
	*   calcul des montants réglés
	*
	*   retourne la somme des montants réglés, et la somme par moyen de
	*   paiement
	*  
	*   @static
	*   @return Array 
	*/
	
	public static function montantTDB() {
		$ret = null;
		$rsum= "select sum(montant) as `rsum` from regle";
	    try {
			$dbres=Base::doSelect($rsum); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		if(count($dbres) == 1) 	$ret ['rsum'] = $dbres[0]['rsum'];
		$dsum= "select code_reglement, sum(montant) as `msum` from regle group by code_reglement";
		try {
			$dbres=Base::doSelect($dsum); 
		} catch(BaseException $e){
			echo $e->__toString(); echo 
			exit();
		}
		$det = null; $n = count($dbres);
		if(!( $n== 0)) {
			foreach ( $dbres as $i=>$row) $det[$row['code_reglement']]=$row['msum'];
			$ret['msum']=$det;
		}
		return $ret;
	}
	
		
	/**
	*   Finder sur $ID
	*
	*   Retrouve la ligne de la table correspondant à l'ID passé en paramètre
	*  
	*   @static
	*   @param integer $code_etat 
	*   @param String $code_manuel 
	*   @return determine renvoie le tarif correspondant au manuel en fonction de son état
	*/
	public static function findById($num_regle) {
		$query = "select * from regle where num_regle=". $num_regle ;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Regle();
			$o->setAttr("num_regle", $row["num_regle"]);
			$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
			$o->setAttr("code_reglement", $row["code_reglement"]);
			$o->setAttr("montant", $row["montant"]);
			$o->setAttr("datereg", $row["datereg"]);
			$o->setAttr("numero_cheque", $row["numero_cheque"]);			
		} 
		return $o;
	}
	
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table regle 
	*   sous la forme d'un tableau
	*  
	*   @static
	*   @return Array renvoie un tableau
	*/	
	public static function findByNumDossierAchat($num_dossier_achat) {
		$query = "select * from regle where num_dossier_achat=". $num_dossier_achat . " ORDER BY datereg, montant";
				
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Regle();
				$o->setAttr("num_regle", $row["num_regle"]);
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("code_reglement", $row["code_reglement"]);
				$o->setAttr("montant", $row["montant"]);
				$o->setAttr("datereg", $row["datereg"]);
				$o->setAttr("numero_cheque", $row["numero_cheque"]);		
				$all[]=$o;
			}
		}
		return $all;
	}
	
	
	
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table regle 
	*   sous la forme d'un tableau
	*  
	*   @static
	*   @return Array renvoie un tableau
	*/	
	public static function findAll() {
		$query = "select * from regle ORDER BY datereg, montant";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Regle();
				$o->setAttr("num_regle", $row["num_regle"]);
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("code_reglement", $row["code_reglement"]);
				$o->setAttr("montant", $row["montant"]);
				$o->setAttr("datereg", $row["datereg"]);
				$o->setAttr("numero_cheque", $row["numero_cheque"]);		
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
	
		$save_query = "insert into regle (num_dossier_achat,code_reglement,montant,datereg,numero_cheque) values ( " . 			
		(isset($this->num_dossier_achat) ? "'$this->num_dossier_achat'" : "null").",".	
		(isset($this->code_reglement)    ? "$this->code_reglement" : "null").",".	
		(isset($this->montant)           ? "$this->montant" : "null").",".	
		(isset($this->datereg)           ? "'$this->datereg'" : "null").",".	
		(isset($this->numero_cheque)     ? "'$this->numero_cheque'" : "null").")" ;
		
		
		
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			$this->setAttr("num_regle", Base::getLastId("regle","num_regle"));						
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
		if (!isset($this->num_regle)) {
			throw new RegleException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "update regle set 
		num_dossier_achat = "  . (isset($this->num_dossier_achat)? "'$this->num_dossier_achat'" : "null")   . ",  
		code_reglement = "     . (isset($this->code_reglement)   ? "$this->code_reglement" : "null")   . ",  
		montant = "            . (isset($this->montant)          ? "$this->montant" : "null")   . ",  
		datereg = "            . (isset($this->datereg)          ? "'$this->datereg'" : "null")   . ", 
		numero_cheque = "      . (isset($this->numero_cheque)    ? "'$this->numero_cheque'" : "null") . "  							
		where num_regle = ". $this->num_regle;
		
		
		
		
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
		if (!isset($this->num_regle)) {
			throw new RegleException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from regle where num_regle= ". $this->num_regle ;
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
		if (!isset($this->num_regle))
			return $this->insert();
		else
			return $this->update();
	}				
	
	
}
?>
