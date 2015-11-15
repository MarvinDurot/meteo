<?php 

namespace Core\Database;

/**
 * Class Database
 * Permet de se connecter à une base de données
 */
class Database
{
    /**
     * Driver PDO
     */
    private $pdo;
    
    private $host;
    private $database;    
    private $username;
    private $password;

    /**
     * Database constructor.
     * @param $host
     * @param $database
     * @param $username
     * @param $password
     */
    public function __construct($host, $database, $username, $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Retourne l'objet PDO de la base
     */
    public function getPDO()
    {
        if($this->pdo === null) {
            // Construction de la chaîne de connexion
            $dsn = 'mysql:host='.$this->host.'; dbname='.$this->database.';charset=utf8';

            // Création de l'objet PDO avec contrôle d'erreur
            try { $this->pdo = new \PDO($dsn, $this->username, $this->password); }
            catch(\PDOException $e) { throw new DatabaseException(); }

            // On affiche les erreurs SQL
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }
}
