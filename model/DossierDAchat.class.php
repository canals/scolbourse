<?php
/**
 * model.DossierDAchat.class.php : classe qui represente les Dossiers D'achats de l'application
 * @package model
 */

class DossierDAchat {
	// D E S   A T T R I B U T S
		
	/**
	 *  num_dossier_achat afin de retrouver le numero de dossier d'achat
	 *  @var $num_dossier_achat
	 **/
	private $num_dossier_achat; 
	
	/**
	 *  date_creation_achat afin de retrouver le jour d'achat
	 *  @var $date_creation_achat
	 **/
	private $date_creation_achat; 
	
	/**
	 *  date_dernier_achat afin de retrouver le jour du dernier achat
	 *  @var $date_dernier_achat
	 **/
	private $date_dernier_achat; 
	
	/**
	 *  frais_dossier_achat afin de retrouver les frais de dossier
	 *  @var $frais_dossier_achat
	 **/
	private $frais_dossier_achat; 


	/**
	 *  montant_livre_achete afin de retrouver le montant du livre achet�
	 *  @var $montant_livre_achete
	 **/
	private $montant_livre_achete; 

	
	/**
	 *  @var $etat_dossier_achat
	 **/
	private $etat_dossier_achat; 
	
	
	/**** COMENTARIOS ************************/

	private $exemplaires;
	
	/******************************************/


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
		return __CLASS__ . " num_dossier_achat:   ". $this->num_dossier_achat .";";
	}	

	/**
	*   Getter g�n�rique
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @return mixed
	*/
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	*   Setter g�n�rique
	*
	*   fonction de modification des attributs.
	*   Re�oit en param�tre le nom de l'attribut modifi� et la nouvelle valeur
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
	*   Retrouve la ligne de la table correspondant � l'ID pass� en param�tre
	*  
	*   @static
	*   @param integer $code_etat 
	*   @param String $code_manuel 
	*   @return determine renvoie le tarif correspondant au manuel en fonction de son �tat
	*/
	public static function findById($num_dossier_achat) {
		$query = "select * from dossier_d_achat where num_dossier_achat=". $num_dossier_achat ;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new DossierDAchat();
			$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
			$o->setAttr("date_creation_achat", $row["date_creation_achat"]);
			$o->setAttr("date_dernier_achat", $row["date_dernier_achat"]);
			$o->setAttr("frais_dossier_achat", $row["frais_dossier_achat"]);
			$o->setAttr("montant_livre_achete", $row["montant_livre_achete"]);
			$o->setAttr("etat_dossier_achat", $row["etat_dossier_achat"]);
					
			// Trouver les exemplaires du dossier		
			$allEx = Exemplaire::findByNumDossierAchat($o->getAttr("num_dossier_achat"));
			$o->setAttr("exemplaires",$allEx);		
											
		} 
		return $o;
	}
	
	/**
	*   Finder sur $date_creation_achat
	*  
	*   @static
	*   @param Date $date_creation_achat
	*   @return Array renvoie un tableau
	*/
	public static function findByDateCreation($date_creation_achat) {
		$query = "select * from dossier_d_achat where date_creation_achat='". $date_creation_achat ."'";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDAchat();
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("date_creation_achat", $row["date_creation_achat"]);
				$o->setAttr("date_dernier_achat", $row["date_dernier_achat"]);
				$o->setAttr("frais_dossier_achat", $row["frais_dossier_achat"]);
				$o->setAttr("montant_livre_achete", $row["montant_livre_achete"]);
				$o->setAttr("etat_dossier_achat", $row["etat_dossier_achat"]);
				
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierAchat($o->getAttr("num_dossier_achat"));
				$o->setAttr("exemplaires",$allEx);				
				
				$all[]=$o;
			}
		}
		return $all;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table dossier_d_achat 
	*   sous la forme d'un tableau
	*  
	*   @static
	*   @return Array renvoie un tableau
	*/	
	public static function findAll() {
		$query = "select * from dossier_d_achat";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null; $n=count($dbres);
		if(!$n == 0) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDAchat();
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("date_creation_achat", $row["date_creation_achat"]);
				$o->setAttr("date_dernier_achat", $row["date_dernier_achat"]);
				$o->setAttr("frais_dossier_achat", $row["frais_dossier_achat"]);
				$o->setAttr("montant_livre_achete", $row["montant_livre_achete"]);
				$o->setAttr("etat_dossier_achat", $row["etat_dossier_achat"]);	
				
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierAchat($o->getAttr("num_dossier_achat"));
				$o->setAttr("exemplaires",$allEx);				
										
				$all[]=$o;
			}
			$all['count']=$n;
		}
		return $all;
	}
	
	public static function findAllTrie() {
		$query = "select * from dossier_d_achat ORDER BY num_dossier_achat";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDAchat();
				$o->setAttr("num_dossier_achat", $row["num_dossier_achat"]);
				$o->setAttr("date_creation_achat", $row["date_creation_achat"]);
				$o->setAttr("date_dernier_achat", $row["date_dernier_achat"]);
				$o->setAttr("frais_dossier_achat", $row["frais_dossier_achat"]);
				$o->setAttr("montant_livre_achete", $row["montant_livre_achete"]);
				$o->setAttr("etat_dossier_achat", $row["etat_dossier_achat"]);	
				
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierAchat($o->getAttr("num_dossier_achat"));
				$o->setAttr("exemplaires",$allEx);				
										
				$all[]=$o;
			}
		}
		return $all;
	}
	
	/**
	*   Insertion dans la base
	*
	*   Ins�re une nouvelle ligne dans la table
	*   @access public
	*   @return int nombre de lignes ins�r�es
	*/				
	public function insert() {
	
		$save_query = "insert into dossier_d_achat (num_dossier_achat,date_creation_achat,date_dernier_achat,frais_dossier_achat,montant_livre_achete,etat_dossier_achat) values ( " . 	
		(isset($this->num_dossier_achat)     ? "'$this->num_dossier_achat'" : "null").",".
		(isset($this->date_creation_achat)   ? "'$this->date_creation_achat'" : "null").",".	
		(isset($this->date_dernier_achat)   ? "'$this->date_dernier_achat'" : "null").",".	
		(isset($this->frais_dossier_achat)   ? "'$this->frais_dossier_achat'" : "null").",".	
		(isset($this->montant_livre_achete)   ? "'$this->montant_livre_achete'" : "null").",".	
		(isset($this->etat_dossier_achat)         ? "$this->etat_dossier_achat" : "null").")" ;					
				
		try {
			$aff_rows = Base::doUpdate($save_query);			
			
			return $aff_rows;
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}		
		
	/**
	*   mise � jour de la ligne courante
	*   
	*   m�thode priv�e - la m�thode publique s'appelle save
	*   @acess private
	*   @return int nombre de lignes mises � jour
	*/
	private function update() {	
		if (!isset($this->num_dossier_achat)) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "update dossier_d_achat set 
		num_dossier_achat = "        . (isset($this->num_dossier_achat)        ? "'$this->num_dossier_achat'" : "null")  . ", 
		date_creation_achat = "     . (isset($this->date_creation_achat)     ? "'$this->date_creation_achat'" : "null")   . ",  
		date_dernier_achat = "     . (isset($this->date_dernier_achat)     ? "'$this->date_dernier_achat'" : "null")   . ",  
		frais_dossier_achat = "     . (isset($this->frais_dossier_achat)     ? "$this->frais_dossier_achat" : "null")   . ",  
		montant_livre_achete = "     . (isset($this->montant_livre_achete)     ? "$this->montant_livre_achete" : "null")   . ", 
		etat_dossier_achat = "       . (isset($this->etat_dossier_achat)       ? "$this->etat_dossier_achat" : "null") . "  							
		where num_dossier_achat = ". $this->num_dossier_achat;			
		
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
		if (!isset($this->num_dossier_achat)) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from dossier_d_achat where num_dossier_achat= ". $this->num_dossier_achat ;
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
		$dossier = DossierDAchat::findById($this->num_dossier_achat);				
		if ($dossier==null) 		
			return $this->insert();
		else
			return $this->update();
	}	
	
	

	public function calculerMontants() {					
		// Trouver les exemplaires du dossier		
		$allEx = Exemplaire::findByNumDossierAchat($this->getAttr("num_dossier_achat"));
		$this->setAttr("exemplaires",$allEx);
		
		$montantAchete = 0.0;
		if($allEx != null) {
			foreach($allEx as $ex) {			
				$man = Manuel::findById($ex->getAttr("code_manuel"));
				$etat = Etat::findById($ex->getAttr("code_etat"));
				$determine = Determine::findById($etat->getAttr("code_etat"), $man->getAttr("code_manuel"));
				$montantAchete += floatval($determine->getAttr("tarif"));		
			}
		}
		$this->setAttr("montant_livre_achete",$montantAchete);	
		
		// On determine le montant pour frais
		$taux = Taux::findById(1);
		$famille = Famille::findById($this->getAttr("num_dossier_achat"));
		$montantFrais = ($famille->getAttr("enlevettfrais")=="n")?($taux->getAttr("taux_frais")/100):0.0;		
		$montantFrais *= $montantAchete; $montantFrais = round($montantFrais,2);
		$this->setAttr("frais_dossier_achat", $montantFrais);		
		
		// On determine le montant d�j� pay�e							
		$totalPayee = 0.0;
		$regles = Regle::findByNumDossierAchat($this->getAttr("num_dossier_achat"));
		if($regles!=null) {	
			foreach($regles as $regle) {				
				$reglement = Reglement::findById($regle->getAttr("code_reglement"));						
				$totalPayee += round(floatval($regle->getAttr("montant")),2);
			}
		}			
		$etat = (($montantAchete+$montantFrais)==$totalPayee)?1:2;
		$this->setAttr("etat_dossier_achat",$etat);	
	}			
	
	public function montantTDB() {
		$ret = null;
		$rsum= "select sum(tarif) as `asum` from dossier_d_achat dd, exemplaire ex, determine de
                    where dd.num_dossier_achat=ex.num_dossier_achat
                       and ex.code_manuel=de.code_manuel
	                   and ex.code_etat=de.code_etat";
	    try {
			$dbres=Base::doSelect($rsum); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		if(count($dbres) == 1) 	$ret ['asum'] = $dbres[0]['asum'];
		$vfsum= "select sum(montant_livre_achete) as `vsum`, sum(frais_dossier_achat) as `fsum`
                  from dossier_d_achat dd";
	    try {
			$dbres=Base::doSelect($vfsum); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		if(count($dbres) == 1) 	{
			$ret ['vsum'] = $dbres[0]['vsum'];
			$ret ['fsum'] = $dbres[0]['fsum'];
		}
		return $ret;
	}
		
}
?>
