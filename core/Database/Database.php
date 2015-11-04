<?php 

namespace Core\Database;

/**
 * Class Database
 * Singleton de connexion à la base de données
 */
class Database
{
    // Instance de la classe
    private static $instance = null;
    
    // Objet PDO
    private $pdo;
    
    private $host;
    private $database;    
    private $username;
    private $password;
    
    /**
     * Constructeur
     */
    public function __construct($host, $database, $username, $password)
    {        
        $dsn = 'mysql:host='.$this->host.'; dbname='.$this->database.';charset=utf8';
        
        try{
            $this->pdo = new PDO($dsn, $this->username, $this->password);
        }
        catch(PDOException $e){
            throw new DatabaseException();
        }
    }
    
    /**
     * Retourne l'instance de la classe de la base
     * @return null|Database
     */
    static function getInstance()
    {       
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /**
     * Retourne l'objet PDO de la base
     */
    public function getPDO()
    {
        return $this->pdo;
    }   
}
