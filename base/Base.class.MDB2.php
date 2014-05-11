<?php
  /**
   * Base.php : gateway mdb2 vers la base Biblio
   *
   * @author J�r�my Fix
   * @author G�r�me Canals
   * @package biblio
   */
require_once('MDB2.php');


/**
 *  La classe Base : gateway vers la base sql
 * 
 *  la classe base implante le pattern Gateway pour l'acc�s 
 *  � un sgbd relationnel
 *  Elle implante un singleton pour g�rer le handler de connexion
 */

class Base {

  /**
   *  variable statique stockant l'identifiant de connexion
   *  r�alisation du singleton
   *  @static
   *  @access private
   *  @var MDB2
   */ 
  private static $connect;
  
  public  function __construct()
  {
  }

  /**
   *   connect() : �tablissement d'une connexion
   *
   *   m�thode interne pour l'�tablissement d'une connexion<b>
   *   appel�e lorsque $connect n'a pas de valeur <b>
   *   Charge le fichier de configuration
   *   @access private
   *   @return MDB2 un nouvel objet MDB2 ou False en cas d'erreur
   *   @static
   **/  
  private static function connect($dsn=null) {
      if (is_null($dsn)) {
        $configpath = dirname(__FILE__).DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR.'config/config.db.php';
        require_once($configpath);
        $dsn="$dbtype://$user:$pass@$host:$port/$dbname";
      }
    //echo "connecting dsn: $dsn <br/>";
    $db = & MDB2::connect($dsn);
    if(PEAR::isError($db)) {
            
	    throw new BaseException("connection: $dsn ".$db->getMessage());
    }
    return $db;
  }


  /**
   *   getConnection() : r�cup�rer une connexion
   *
   *   m�thode statique pour obtenir une connexion<b>
   *   implantation du singleton : retourne $connect  <b>
   *   ou appelle la m�thode connect()
   *   @return MDB2 un nouvel objet MDB2 ou False en cas d'erreur
   *   @static
   *   @access public
   **/  
  public static function getConnection($dsn=null)
  {
    //echo "entering getConnection()<br/>";
    if (!(isset(self::$connect))) 
      {
        //echo "getConnection calls self::connect()<br/>";
        $db = self::connect($dsn);
	self::$connect = $db;
      }
    //echo "returning getConnection()<br/>";
    return self::$connect;
  }
  

  /**
   *   doUpdate() : transmet une requ�te de mise � jour � la base
   *
   *   m�thode statique pour transmettre une mise � jour � la base<b>
   *   utilis�e pour traiter INSERT, UPDATE, DELETE<b>
   *
   *   @param String $query requete SQL � transmettre (INSERT, UPDATE, DELETE)
   *   @return nombre de lignes affect�es par la mise � jour
   *   @static
   *   @access public
   **/  

  public static function doUpdate($query) 
  {		
    $db = self::getConnection();
    $dbres=& $db->exec($query);
    if (Pear::isError($dbres)) 
      {
	echo $query . "<br>";
	throw new BaseException($dbres->getMessage());
      } 
    return $dbres;
  }

  /**
   *   doSelect() : transmet une requ�te de s�lection � la base
   *
   *   m�thode statique pour transmettre une s�lection� la base<b>
   *   utilis�e pour traiter les SELECT<b>
   *   Le r�sultat est renvoy� sous la forme d'un tableau de lignes <b>
   *   dans lequel chaque ligne est un tableau associatif sur les noms <b>
   *   de colonnes
   *
   *   @param String $query requete SQL � transmettre (SELECT)
   *   @return Array un tableau contenant les lignes s�lectionn�es
   *   @static
   *   @access public
   **/  
  public static function doSelect($query) 
  {
    //echo "entering doSelect()<br/>";
    $db = self::getConnection();
    $dbres= & $db->query($query);
    if (Pear::isError($dbres)) 
      {	
	//echo $query . "<br>";
	throw new BaseException("Erreur query select : $query ".$dbres->getMessage());
      }
    $row = $dbres->fetchRow(MDB2_FETCHMODE_ASSOC);
    while ($row) 
      {
	if (Pear::isError($dbres)) 
	  { 
            //echo "il est passé par ici ..";
	    throw new BaseException("erreur fetch ". $dbres->getMessage());
	  }
	$allrows[]=$row;
        $row = $dbres->fetchRow(MDB2_FETCHMODE_ASSOC);
      }
    $dbres->free();
    return $allrows;
  }


  /**
   *   getLastId() : retourne l'identifiant de la derni�re ligne ins�r�e (AUTO_INCREMENT)
   *
   *   m�thode statique pour obtenir l'identifiant de la derni�re<b>
   *   ligne ins�r�e dans une table, lorsque cet identifiant est g�r� avec un<b>
   *   auto-incr�ment<b>
   *   Re�oit en param�tre le nom de la table et le nom de la colonne <b>
   *
   *   @param String $tname nom de la table
   *   @param String $id  nom de la colonne utilis�e comme identifiant
   *   @return int un entier
   *   @static
   *   @access public
   **/  
  public static function getLastId($tname, $id) {
    $db = self::getConnection();
    $lastId = $db->lastInsertID($tname,$id);
    if (Pear::isError($lastId)) 
      {	
	throw new BaseException($lastId->getMessage());
      } 
    return $lastId;
  }

	// get numero de rows dans une table
	public static function getNumRows($tname, $id) {

		$query = "SELECT COUNT(" . $id .") as total FROM " . $tname . ";";						
		$allrows = self::doSelect($query);		
		if(count($allrows) != 1) 
			throw new BaseException("Erreur avec la basse de donn�es...");			
			
		return $allrows[0]["total"];
	}    


}

?>
	


  
