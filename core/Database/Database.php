<?php 

namespace Core\Database;

/**
 * Class Database
 * Singleton de connexion à la base de données
 */
class Database
{
    private static $pdo = null; // Le singleton
    
    /**
     * Retourne l'objet PDO de la base
     * @return null|PDO
     */
    static function getInstance()
    {       
        if (self::$pdo == null) {
            $dsn = "mysql:host=".Config::get('database.host').";dbname=".Config::get('database.database').";charset=utf8";
            self::$pdo = new PDO($dsn, Config::get('database.username'), Config::get('database.password'));
        }
        return self::$pdo;
    }   
}
