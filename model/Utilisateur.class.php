<?php
/**
 * model.Utilisateur.class.php : classe qui represente les Utilisateurs d l'application
 *
 * @package model
 */

class Utilisateur {
	// D E S   A T T R I B U T S
	
	/**#@+
	 *  @access private
	 **/ 
	
	/**
	 *  identifiant d'utilisateur
	 *  @var $idUtilisateur
	 **/
	private $idUtilisateur; 
	
	/**
	 *  nom de l'utilisateur
	 *  @var $nom
	 **/
	private $nom; 
	
	/**
	 *  prenom de l'utilisateur
	 *  @var $nom
	 **/
	private $prenom; 
	
	/**
	 *  login de l'utilisateur
	 *  @var $login
	 **/
	private $login; 
	
	/**
	 *  mot de passe de l'utilisateur
	 *  @var $pwd
	 **/
	private $pwd;
	
	/**
	 *  niveau d'acces de l'utilisateur
	 *  @var $typeUtilisateur
	 **/
	private $typeUtilisateur;

	
	/**#@-*/
	
	
	// D E S   M E T H O D E S
	
	/**#@+
	*  @access public
	*/ 
	
	/**
	*  Constructeur d'adh�rent
	*
	*  fabrique un nouvel adh�rent vide
	*/
	public function __construct() {
		// Anything necessary to construct a new Utilisateur de ce classe
		$this->setAttr("typeUtilisateur",1); // Par defaut tout sont utilisateur
	}
	
	/**
	*  Magic pour imprimer
	*
	*  Fonction Magic retournant une chaine de caract�res imprimable
	*  pour imprimer facilement un Utilisateur
	*
	*   @access public
	*   @return String
	*/
	public function __toString() {
		return __CLASS__ . " idUtilisateur:   ". $this->idUtilisateur .";";
	}	
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un utilisateur.
	*   Reçoit en paramètre le nom de l'attribut accédé
	*   et retourne sa valeur.
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
	*   fonction de modification des attributs d'un utilisateur.
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
	*   Retrouve la ligne de la table correspondant à l'ID passé en paramètre,
	*   retourne un Utilisateur
	*  
	*   @static
	*   @param integer $idUtilisateur OID to find
	*   @return utilisateur renvoie un utilisateur de type Utilisateur (sans son password)
	*/
	public static function findById($idUtilisateur) {
		$query = "select * from utilisateur where idUtilisateur=". $idUtilisateur;
		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
			$o = new Utilisateur();

                      

			$o->setAttr("idUtilisateur", $row["idUtilisateur"]);
			$o->setAttr("nom", $row["nom"]);
			$o->setAttr("prenom", $row["prenom"]);
			$o->setAttr("login", $row["login"]);
			$o->setAttr("pwd", $row["pwd"]);
			$o->setAttr("typeUtilisateur", $row["typeutilisateur"]);
		} 
		return $o;
	}
	
	/**
	*   Finder sur $login
	*
	*   Retrouve la ligne de la table correspondant à le login passé en paramètre,
	*   retourne un Utilisateur
	*  
	*   @static
	*   @param String $login to find
	*   @return utilisateur renvoie un utilisateur de type Utilisateur (sans son password)
	*/
	public static function findByLogin($login) {
		$query = "select * from utilisateur where login=". "'$login'";
                $dbres=null;
                

		try {
			$dbres=Base::doSelect($query); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$o = null;
		if(count($dbres) == 1) {
			$row= $dbres[0];
//var_dump($row);
			$o = new Utilisateur();
			$o->setAttr("idUtilisateur", $row["idUtilisateur"]);
			$o->setAttr("nom", $row["nom"]);
			$o->setAttr("prenom", $row["prenom"]);
			$o->setAttr("login", $row["login"]);
			$o->setAttr("pwd", $row["pwd"]);
			$o->setAttr("typeUtilisateur", $row['typeUtilisateur']);
		} 
		return $o;
	}
	
		
	/**
	*   Finder All
	*
	*   Renvoie toutes les lignes de la table utilisateur 
	*   sous la forme d'un tableau d'utilisateur
	*  
	*   @static
	*   @return Array renvoie un tableau d'utilisateur
	*/	
	public static function findAll() {
		$query = "select * from utilisateur";
		try{
			$dbres=Base::doSelect($query);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
		$all = null;
		if(!(count($dbres) == 0)) {
			foreach ( $dbres as $i=>$row) {
				$o = new Utilisateur();
				$o->setAttr("idUtilisateur", $row["idUtilisateur"]);
				$o->setAttr("nom", $row["nom"]);
				$o->setAttr("prenom", $row["prenom"]);
				$o->setAttr("login", $row["login"]);
				$o->setAttr("pwd", $row["pwd"]);
				$o->setAttr("typeUtilisateur", $row["typeutilisateur"]);
				$all[]=$o;
			}
		}
		return $all;
	}
	
	/**
	*   Insertion dans la base
	*
	*   Insére l'utilisateur comme une nouvelle ligne dans la table
	*   méme si l'utilisateur posséde déjà un ID
	*   @access public
	*   @return int nombre de lignes insérées
	*/				
	public function insert() {
	
		$newpw = (isset($this->pwd) ? "$this->pwd" : "null");
		$newpw = md5($newpw, false);
		
		$user = Utilisateur::findByLogin((isset($this->login)? "$this->login" : "null"));		
		if($user!=null) 
			return "ERREUR";
			
		$save_query = "insert into utilisateur (nom,prenom,login,pwd,typeUtilisateur) values ( " .
		(isset($this->nom)        ? "'$this->nom'" : "null").",".
		(isset($this->prenom)     ? "'$this->prenom'" : "null").",".
		(isset($this->login)      ? "'$this->login'" : "null").",'$newpw',".		
		(isset($this->typeUtilisateur)       ? "$this->typeUtilisateur" : "1").")" ;
		
		try {
			$aff_rows = Base::doUpdate($save_query);
			$this->setAttr("idUtilisateur", Base::getLastId("utilisateur","idUtilisateur"));
			return $aff_rows;
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}		
		
	/**
	*   mise à jour de la ligne courante
	*   
	*   Sauvegarde l'utilisateur courant dans la base en faisant un update
	*   l'identifiant de l'utilisateur doit exister (insert obligatoire auparavant)
	*   méthode privée - la méthode publique s'appelle save
	*   NE Modifie pas le password : doit étre fait avec la méthode spécifique
	*   @acess private
	*   @return int nombre de lignes mises à jour
	*/
	private function update() {	
		if (!isset($this->idUtilisateur)) {
			throw new UtilisateurException(__CLASS__ . ": Primary Key undefined : cannot update");
		} 
		$save_query = "update utilisateur set 
		nom = "        . (isset($this->nom)        ? "'$this->nom'" : "null")  . ", 
		prenom = "     . (isset($this->prenom)     ? "'$this->prenom'" : "null")   . ", 
		login = "      . (isset($this->login)      ? "'$this->login'" : "null")    . ",
		pwd = "   . (isset($this->pwd)   ? "'$this->pwd'" : "null")    . ",				
		typeUtilisateur = "       . (isset($this->typeUtilisateur)       ? "$this->typeUtilisateur" : "null") . "  							
		where idUtilisateur = $this->idUtilisateur;";
		
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
	*   Supprime la ligne dans la table corrsepondant à l'utilisateur courant
	*   L'utilisateur doit posséder un $ID
	*   @access public
	*/	
	public function delete() {
		if (!isset($this->idUtilisateur)) {
			throw new UtilisateurException(__CLASS__ . ": Primary Key undefined : cannot delete");
		} 
		$del_query = "delete from utilisateur where idUtilisateur= $this->idUtilisateur";
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
	*   Enregistre l'état de l'utilisateur dans la table
	*   Si l'utilisateur posséde un identifiant : mise à jour de l aligne correspondante
	*   sinon : insertion dans une nouvelle ligne
	*   @access public
	*/
	public function save() {
		if (!isset($this->idUtilisateur))
			return $this->insert();
		else
			return $this->update();
	}				
	
	/**#@-*/	
	
	
	/**
	*   Comparaison de mot de passe
	*
	*   Compare le mot de passe de l'adh�rent avec la valeur pass�e en param�tre
	*   et renvoie True si �gaux et False sinon
	*
	*   @access public
	*   @param String $pass passwd to check
	*   @return boolean
	*/
	
	public function checkPassword($passw){	
		
		$sql = "SELECT idutilisateur FROM utilisateur WHERE idUtilisateur = ";
		$sql .= $this->getAttr("idUtilisateur") . " and login = '" . $this->getAttr("login") . "' and pwd = '" . $passw . "'";
		
				
		try{
			$dbres=Base::doSelect($sql); 
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}		
		return (count($dbres) == 1);  
	}
	
	/**
	*   Changement du mot de passe
	*
	*   Change le mot de passe de l'utilisateur en v�rifiant l'ancien mot de passe
	*
	*   @access public
	*   @param String $oldpw ancien mot de passe
	*   @param String $newpw nouveau mot de passe
	*   @return boolean True si lemot de passe a �t� chang�
	*/
	
	public function changePassword($oldpw, $newpw) {	
		if (! $this->checkPassword($oldpw) ) 
			return False;
				
		$sql = "update utilisateur set pwd = '". $newpw . "' where idUtilisateur=". $this->idUtilisateur;
		try {
			return Base::doUpdate($sql);
		} catch(BaseException $e){
			echo $e->__toString();
			exit();
		}
	}
	
}
?>
