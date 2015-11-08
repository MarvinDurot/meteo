<?php

namespace App;


class App
{
    public $title;
    private $database;
    private $config;

    private static $_instance;

    public function __construct()
    {

    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getDb()
    {
        if ($this->database === null) {
            $this->database = new Database($config->get('db_host'), $config->get('db_name'), $config->get('db_user'), $config->get('db_password'));
        }
        return $this->database;
    }

}