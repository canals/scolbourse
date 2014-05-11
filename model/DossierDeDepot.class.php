<?php
/**
 * model.DossierDeDepot.class.php : classe qui represente les Dossiers De D�pots
 * @package model
 */

class DossierDeDepot {
	// D E S   A T T R I B U T S
		
	/**
	 *  num_dossier_depot afin de retrouver le numero de dossier de depot
	 *  @var $num_dossier_depot
	 **/
	private $num_dossier_depot; 
	
	/**
	 *  date_creation_depot afin de retrouver le jour d'depot
	 *  @var $date_creation_depot
	 **/
	private $date_creation_depot; 
	
	/**
	 *  date_dernier_depot afin de retrouver le jour du dernier depot
	 *  @var $date_dernier_depot
	 **/
	private $date_dernier_depot; 
	
	/**
	 *  frais_dossier_depot afin de retrouver les frais de dossier
	 *  @var $frais_dossier_depot
	 **/
	private $frais_dossier_depot; 


	/**
	 *  frais_envoi_depot afin de retrouver les frais d'envoi
	 *  @var $frais_envoi_depot
	 **/
	private $frais_envoi_depot; 


	/**
	 *  montant_livre_achete afin de retrouver le montant du livre achet�
	 *  @var $montant_livre_achete
	 **/
	private $montant_livre_depose_vendu; 


	/**
	 *  enlevefraisenv_depot  afin d'enlever les frais d'envoi
	 *  @var $enlevefraisenv_depot 
	 **/
	private $enlevefraisenv_depot ; 
	

	
	/**
	 *  @var $etat_dossier_depot
	 **/
	private $etat_dossier_depot; 
	
	
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
		return __CLASS__ . " num_dossier_depot:   ". $this->num_dossier_depot .";";
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
	public static function findById($num_dossier_depot) {
		$query = "select * from dossier_depot where num_dossier_depot=". $num_dossier_depot ;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new DossierDeDepot();
			$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
			$o->setAttr("date_creation_depot", $row["date_creation_depot"]);
			$o->setAttr("date_dernier_depot", $row["date_dernier_depot"]);
			$o->setAttr("frais_dossier_depot", $row["frais_dossier_depot"]);
			$o->setAttr("frais_envoi_depot", $row["frais_envoi_depot"]);
			$o->setAttr("montant_livre_depose_vendu", $row["montant_livre_depose_vendu"]);
			$o->setAttr("enlevefraisenv_depot", $row["enlevefraisenv_depot"]);
			$o->setAttr("etat_dossier_depot", $row["etat_dossier_depot"]);	
				
			// Trouver les exemplaires du dossier				
			$allEx = Exemplaire::findByNumDossierDepot($o->getAttr("num_dossier_depot"));
			$o->setAttr("exemplaires",$allEx);
			
			//$o->calculerMontants();
				
		} 
		return $o;
	}
	
	/**
	*   Finder sur $date_creation_depot
	*  
	*   @static
	*   @param Date $date_creation_depot
	*   @return Array renvoie un tableau
	*/
	public static function findByDateCreation($date_creation_depot) {
		$query = "select * from dossier_depot where date_creation_depot='". $date_creation_depot ."'";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDeDepot();
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("date_creation_depot", $row["date_creation_depot"]);
				$o->setAttr("date_dernier_depot", $row["date_dernier_depot"]);
				$o->setAttr("frais_dossier_depot", $row["frais_dossier_depot"]);
				$o->setAttr("frais_envoi_depot", $row["frais_envoi_depot"]);
				$o->setAttr("montant_livre_depose_vendu", $row["montant_livre_depose_vendu"]);
				$o->setAttr("enlevefraisenv_depot", $row["enlevefraisenv_depot"]);
				$o->setAttr("etat_dossier_depot", $row["etat_dossier_depot"]);
					
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierDepot($o->getAttr("num_dossier_depot"));
				$o->setAttr("exemplaires",$allEx);		
				
				//$o->calculerMontants();
				
				$all[]=$o;
			}
		}
		return $all;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table dossier_depot 
	*   sous la forme d'un tableau
	*  
	*   @static
	*   @return Array renvoie un tableau
	*/	
	public static function findAll() {
		$query = "select * from dossier_depot";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null; $n=count($dbres);
		if(! $n == 0) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDeDepot();
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("date_creation_depot", $row["date_creation_depot"]);
				$o->setAttr("date_dernier_depot", $row["date_dernier_depot"]);
				$o->setAttr("frais_dossier_depot", $row["frais_dossier_depot"]);
				$o->setAttr("frais_envoi_depot", $row["frais_envoi_depot"]);
				$o->setAttr("montant_livre_depose_vendu", $row["montant_livre_depose_vendu"]);
				$o->setAttr("enlevefraisenv_depot", $row["enlevefraisenv_depot"]);
				$o->setAttr("etat_dossier_depot", $row["etat_dossier_depot"]);
					
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierDepot($o->getAttr("num_dossier_depot"));
				$o->setAttr("exemplaires",$allEx);		
				
				//$o->calculerMontants();
											
				$all[]=$o;
			}
			$all['count']=$n;
		}
		return $all;
	}
	
	public static function findAllTrie() {
		$query = "select * from dossier_depot ORDER BY num_dossier_depot";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new DossierDeDepot();
				$o->setAttr("num_dossier_depot", $row["num_dossier_depot"]);
				$o->setAttr("date_creation_depot", $row["date_creation_depot"]);
				$o->setAttr("date_dernier_depot", $row["date_dernier_depot"]);
				$o->setAttr("frais_dossier_depot", $row["frais_dossier_depot"]);
				$o->setAttr("frais_envoi_depot", $row["frais_envoi_depot"]);
				$o->setAttr("montant_livre_depose_vendu", $row["montant_livre_depose_vendu"]);
				$o->setAttr("enlevefraisenv_depot", $row["enlevefraisenv_depot"]);
				$o->setAttr("etat_dossier_depot", $row["etat_dossier_depot"]);
					
				// Trouver les exemplaires du dossier		
				$allEx = Exemplaire::findByNumDossierDepot($o->getAttr("num_dossier_depot"));
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
	
		$this->calculerMontants();
	
		$save_query = "insert into dossier_depot (num_dossier_depot,date_creation_depot,date_dernier_depot,frais_dossier_depot,frais_envoi_depot,montant_livre_depose_vendu,enlevefraisenv_depot,etat_dossier_depot) values ( " . 	
		(isset($this->num_dossier_depot)     ? "$this->num_dossier_depot" : "null").",".
		(isset($this->date_creation_depot)   ? "'$this->date_creation_depot'" : "null").",".	
		(isset($this->date_dernier_depot)   ? "'$this->date_dernier_depot'" : "null").",".	
		
		(isset($this->frais_dossier_depot)  ? "$this->frais_dossier_depot" : "null").",".	
		(isset($this->frais_envoi_depot)    ? "$this->frais_envoi_depot" : "null").",".	
		
		 
		(isset($this->montant_livre_depose_vendu)   ? "$this->montant_livre_depose_vendu" : "null").",".	
		(isset($this->enlevefraisenv_depot)   ? "'$this->enlevefraisenv_depot'" : "'n'").",".	
		(isset($this->etat_dossier_depot)         ? "$this->etat_dossier_depot" : "null").")" ;
		
		try {
			$aff_rows = Base::doUpdate($save_query);			
			
			// Mis � jour de la table dossier montant
			$montant = $this->montant_livre_depose_vendu - $montantFrais - $fraisEnvoi;	
			$md = new DossiersMontant();
			$md->setAttr("num_dossier_depot",$this->num_dossier_depot);							
			$md->setAttr("montant",$montant);			
			$aff_rows = $md->save();
								
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
		if (!isset($this->num_dossier_depot)) {
			throw new DetermineException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		
		$this->calculerMontants();
					
		$save_query = "update dossier_depot set 
		num_dossier_depot = "        . (isset($this->num_dossier_depot)    ? "$this->num_dossier_depot" : "null")  . ", 
		date_creation_depot = "     . (isset($this->date_creation_depot)   ? "'$this->date_creation_depot'" : "null")   . ",  
		date_dernier_depot = "     . (isset($this->date_dernier_depot)     ? "'$this->date_dernier_depot'" : "null")   . ",  
		
		frais_dossier_depot = "     . (isset($this->frais_dossier_depot)     ? "$this->frais_dossier_depot" : "null")  . ",
		frais_envoi_depot = "     .   (isset($this->frais_envoi_depot)     ? "$this->frais_envoi_depot" : "null")   . ",  
		
		montant_livre_depose_vendu = "     . (isset($this->montant_livre_depose_vendu)     ? "$this->montant_livre_depose_vendu" : "null")   . ", 
		enlevefraisenv_depot = "     . (isset($this->enlevefraisenv_depot)     ? "'$this->enlevefraisenv_depot'" : "null")   . ", 
		etat_dossier_depot = "       . (isset($this->etat_dossier_depot)       ? "$this->etat_dossier_depot" : "null") . "  							
		where num_dossier_depot = ". $this->num_dossier_depot;		
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			
			// Mis � jour de la table dossier montant
			$montant = $this->montant_livre_depose_vendu - $montantFrais - $fraisEnvoi;	
			$md = DossiersMontant::findById($this->num_dossier_depot);			
			$md->setAttr("montant",$montant);			
			$aff_rows = $md->save();
				
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
		$del_query = "delete from dossier_depot where num_dossier_depot= ". $this->num_dossier_depot ;
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
		$dossier = DossierDeDepot::findById($this->num_dossier_depot);			
		if ($dossier==null) 
			return $this->insert();
		else
			return $this->update();
	}				
	
	
	public function calculerMontants() {			
		
		// Montant exemplaires vendys	
		$allEx = Exemplaire::findByNumDossierDepot($this->getAttr("num_dossier_depot"));
		$this->setAttr("exemplaires",$allEx);
		$montantVendu = 0.0;
		if($allEx != null) {
			foreach($allEx as $ex) {
				if($ex->getAttr("vendu")==1) {
					$man = Manuel::findById($ex->getAttr("code_manuel"));
					$etat = Etat::findById($ex->getAttr("code_etat"));
					$determine = Determine::findById($etat->getAttr("code_etat"), $man->getAttr("code_manuel"));
					$montantVendu += floatval($determine->getAttr("tarif"));
				}
			}
		}
		$this->setAttr("montant_livre_depose_vendu",$montantVendu);	
		
		// Calculer le frais de dossier
		$taux = Taux::findById(1);
		$famille = Famille::findById($this->getAttr("num_dossier_depot"));
		$montantFrais = ($famille->getAttr("enlevettfrais")=="n")?(floatval($taux->getAttr("taux_frais"))/100):0.0;		
		$montantFrais *= $montantVendu;		
		$this->setAttr("frais_dossier_depot", round($montantFrais, 2));
		
		// Calculer le fras d'envois du dossier
		$montantEnvoi = ($this->getAttr("enlevefraisenv_depot")=="n")?$taux->getAttr("montant_frais_envoi"):0.0;
		$this->setAttr("frais_envoi_depot", $montantEnvoi);		
	}				

	public function montantTDB() {
		$ret = null;
		$rsum= "select sum(tarif) as `dsum` from dossier_depot dd, exemplaire ex, determine de
                  where dd.num_dossier_depot=ex.num_dossier_depot
                  and ex.code_manuel=de.code_manuel
	              and ex.code_etat=de.code_etat";
	    try {
			$dbres=Base::doSelect($rsum); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		if(count($dbres) == 1) 	$ret ['dsum'] = $dbres[0]['dsum'];
		$vfsum= "select sum(montant_livre_depose_vendu) as `vsum`, sum(frais_dossier_depot) as `fsum` 
                 from dossier_depot";
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
