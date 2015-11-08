<?php

namespace App;
use Core\Database\Database;
use Core\Config;

/**
 * Class App
 * @package App
 */
class App
{
    public $title = "API Météo";
    private $database;
    private static $_instance;

    /**
     * Retourne l'instance de l'application
     * @return App
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Retourne la Database de l'application
     * @return Database
     */
    public function getDatabase()
    {
        if ($this->database === null) {
            $this->database = new Database(
                Config::get('database.host'),
                Config::get('database.database'),
                Config::get('database.username'),
                Config::get('database.password')
            );
        }
        return $this->database;
    }
}