<?php
  /**
   * PDO_DBGateway.php : gateway PDO vers la base SQL Biblio
   *
   * @author Gérome Canals
   * @package gateway
   */


/**
 *  La classe Base version PDO : gateway vers la base sql, réalisée avec PDO
 * 
 *  la classe base implante le pattern Gateway pour l'accès
 *  à un sgbd relationnel
 *  Elle est réalisée avec un singleton
 */

class Base {


  /**
   *  variable stockant l'iinstance - pattern singleton
   *  @access private
   *  @var PDO_DBGateway
   */

    private static $instance ;


  /**
   *  variable stockant l'identifiant de connexion
   *  @access private
   *  @var PDO
   */ 
  private static  $connect;
   /**
   *  chemin relatif du fichier de configuration
   *  @access private
   *  @var Sring
   */
  private static $path_config = 'config/db_config.ini';

  /*
   * __constructeur
   *
   * @access public
   * @return un nouvel objet MDB2_DBGateway
   */
  
  public  function __construct($file=null)
  {
        if (! is_null($file)) {$this->path_config = $file;}
        $this->connect = $this->connect();
  }
/*
  public function __destruct() {
      $this->connect=null;
  }
*/
  /**
   *   connect() : établissement d'une connexion
   *
   *   méthode interne pour l'établissement d'une connexion<b>
   *   appelée par le constructeur<b>
   *   Charge le fichier de configuration
   *   @access private
   *   @return MDB2 un nouvel objet MDB2 ou False en cas d'erreur
   **/  
  private  static function connect() {
    $configpath = dirname(__FILE__).DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. self::$path_config;
    $config = parse_ini_file($configpath,true);
    
    if (!$config) throw new BaseException("PDO_DBGateway::connect: could not parse config file $configpath <br/>");


    $dbtype=$config['db_driver'];$host=$config['host']; $dbname=$config['dbname'];
    $user=$config['db_user']; $pass=$config['db_password']; 
    try {
        $dsn="$dbtype:host=$host;dbname=$dbname";
        $db = new PDO($dsn, $user,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                                               PDO::ERRMODE_EXCEPTION=>true,
                                               PDO::ATTR_PERSISTENT=>true));
    } catch(PDOException $e) {
            
	    throw new BaseException("connection: $dsn  ".$e->getMessage(). '<br/>');
    }
    return $db;
  }


  /**
   *   getConnection() : récupérer une connexion
   *
   * : retourne $connect  <b>
   *   ou appelle la méthode connect()
   *   @return MDB2 un nouvel objet MDB2 ou False en cas d'erreur
   *   @access public
   **/  
  public static function getInstance()
  {
    //if (!(isset($this->connect)))
    if (!isset(self::$instance))
      {
	self::$instance = new PDO_DBGateway();
      }
    return self::$instance;
  }

    /**
   *   getConnection() : récupérer une connexion
   *
   * : retourne $this->connect  <b>
   *
   *   @return PDO un  objet PDO ou False en cas d'erreur
   *   @access public
   **/
  public function getConnection()
  {

    if (!(isset(self::$connect))) 
      {
        //echo "getConnection calls self::connect()<br/>";
        $db = self::connect();
	self::$connect = $db;
      }
    //echo "returning getConnection()<br/>";
    return self::$connect;
  }

  /**
   *   doUpdate() : transmet une requète de mise à jour à la base
   *
   *   méthode pour transmettre une mise à jour à la base<b>
   *   utilisée pour traiter INSERT, UPDATE, DELETE<b>
   *
   *   @param String $query requete SQL à transmettre (INSERT, UPDATE, DELETE)
   *   @return nombre de lignes affectées par la mise à jour
   *   @access public
   **/  

  public static function doUpdate( $query, Array $p=null)
  {		
    $db = self::getConnection();
    try {
    $dbres= $db->exec($query);
    } catch (PDOException $e)
      {
	echo $query . "<br>";
	throw new GatewayException($e->getMessage());
      } 
    return $dbres;
  }

  /**
   *   doSelect() : transmet une requète de sélection à la base
   *
   *   méthode  pour transmettre une sélection à la base<b>
   *   utilisée pour traiter les SELECT<b>
   *   Le résultat est renvoyé sous la forme d'un tableau de lignes <b>
   *   dans lequel chaque ligne est un tableau associatif sur les noms <b>
   *   de colonnes
   *
   *   @param String $query requete SQL � transmettre (SELECT)
   *   @return Array un tableau contenant les lignes s�lectionn�es
   *   @access public
   **/  
  public static function doSelect( $query, Array $p=null)
  {
    $db = self::getConnection();
    try {
    foreach ($db->query($query) as $row)
        $allrows[]=$row;
    } catch (PDOException $e)
      {	
	echo $query . "<br>";
	throw new GatewayException("Erreur query select ".$e->getMessage());
      } 
    return $allrows;
  }


  /**
   *   getLastId() : retourne l'identifiant de la derni�re ligne ins�r�e (AUTO_INCREMENT)
   *
   *   m�thode  pour obtenir l'identifiant de la derni�re<b>
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
  public static function getLastId( $tname=null, $id=null) {
    $db = self::getConnection();
    try {
    $lastId = $db->lastInsertID($tname);
    } catch (PDOException $e)
      {	
	throw new GatewayException($lastId->getMessage());
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
	


  
