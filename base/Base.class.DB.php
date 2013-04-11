<?php
/**
 * Base.DB.class.php : gateway DB vers la base ScolBourse
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package base
 */

require_once('DB.php');


/**
 *  La classe Base : gateway vers la base sql
 * 
 *  La classe base implante le pattern Gateway pour l'accés 
 *  à un sgbd relationnel
 *  Elle implante un singleton pour gérer le handler de connexion
 */

class Base {
	/**
	 *  variable statique stockant l'identifiant de connexion
	 *  réalisation du singleton
	 *  @static
	 *  @access private
	 *  @var DB
	*/ 
	private static $connect;
	
	public  function __construct() {
	}
	
	/**
	 *   connect() : etablissement d'une connexion
	 *
	 *   méthode interne pour l'établissement d'une connexion<b>
	 *   appelée lorsque $connect n'a pas de valeur <b>
	 *   Charge le fichier de configuration
	 *   @access private
	 *   @return DB un nouvel objet DB ou False en cas d'erreur
	 *   @static
	 **/  
	private static function connect() {
		include_once('config/config.db.php');
		$db = DB::connect("$dbtype://$user:$pass@$host/$dbname");
		if(PEAR::isError($db)) 
			throw new BaseException($db->getMessage());		
		return $db;
	}
	
	/**
	 *   getConnection() : récupèrer une connexion
	 *
	 *   méthode statique pour obtenir une connexion<b>
	 *   implantation du singleton : retourne $connect  <b>
	 *   ou appelle la méthode connect()
	 *   @return DB un nouvel objet DB ou False en cas d'erreur
	 *   @static
	 *   @access public
	 **/ 
	public static function getConnection() {
		if (!(isset(self::$connect))) {
			$db = self::connect();	
			self::$connect = $db;
		}
		return self::$connect;
	}	
	
	/**
	 *   doUpdate() : transmet une requète de mise à jour à la base
	 *
	 *   méthode statique pour transmettre une mise à jour à la base<b>
	 *   utilisée pour traiter INSERT, UPDATE, DELETE<b>
	 *
	 *   @param String $query requete SQL à transmettre (INSERT, UPDATE, DELETE)
	 *   @return nombre de lignes affectées par la mise à jour
	 *   @static
	 *   @access public
	 **/
	public static function doUpdate($query) {
		$db = self::getConnection();
		$dbres=$db->query($query);
		if (Pear::isError($dbres)) 
			throw new BaseException($dbres->getMessage());
		return $db->affectedRows();
	}

	/**
     *   doSelect() : transmet une requète de sélection à la base
	 *
	 *   méthode statique pour transmettre une sélectioné la base<b>
	 *    utilisée pour traiter les SELECT<b>
 	 *   Le résultat est renvoyé sous la forme d'un tableau de lignes <b>
	 *   dans lequel chaque ligne est un tableau associatif sur les noms <b>
	 *   de colonnes
	 *
	 *   @param String $query requete SQL à transmettre (SELECT)
	 *   @return Array un tableau contenant les lignes sélectionnées
	 *   @static
	 *   @access public
	 **/ 
	public static function doSelect($query) {
		$db = self::getConnection($conf_name);
		$dbres=$db->query($query);
		if (Pear::isError($dbres)) 
			throw new BaseException($dbres->getMessage() . ' '.$query);
		while ($row = $dbres->fetchRow(DB_FETCHMODE_ASSOC)) {
			if (Pear::isError($dbres)) 
				throw new BaseException($dbres->getMessage());
			$allrows[]=$row;
		}
		return $allrows;
	}
	
	/**
	*   getLastId() : retourne l'identifiant de la derniere ligne insere (AUTO_INCREMENT)
	*
	*   méthode statique pour obtenir l'identifiant de la dernire<b>
	*   ligne insere dans une table, lorsque cet identifiant est gr avec un<b>
	*   auto-incrment<b>
	*   Reçoit en parametre le nom de la table et le nom de la colonne <b>
	*
	*   @param String $tname nom de la table
	*   @param String $id nom de la colonne utilisée comme identifiant
	*   @return int un entier
	*   @static
	*   @access public
	**/  
	public static function getLastId($tname, $id) {

		$query = "SELECT MAX(" . $id .") as idMax FROM " . $tname . ";";						
		$allrows = self::doSelect($query);		
		if(count($allrows) != 1) 
			throw new BaseException("Erreur avec la basse de donnée...");			
			
		return $allrows[0]["idMax"];
	}
	
	
	// get numero de rows dans une table
	public static function getNumRows($tname, $id) {

		$query = "SELECT COUNT(" . $id .") as total FROM " . $tname . ";";						
		$allrows = self::doSelect($query);		
		if(count($allrows) != 1) 
			throw new BaseException("Erreur avec la basse de données...");			
			
		return $allrows[0]["total"];
	}
	
}

?>
