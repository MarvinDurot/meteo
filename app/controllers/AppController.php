<?php

namespace App\Controllers;
use Core\Controller\Controller;
use App\App;

/**
 * Class AppController
 * @package App\Controllers
 */
class AppController extends Controller
{
    /**
     * Template par défaut
     * @var string
     */
    protected $template = 'default';

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->viewPath = ROOT . '/app/views/';
    }

    /**
     * Charge une table dans les attributs du controller
     * @param $class
     * @param $modelName
     * @throws \Core\Database\DatabaseException
     */
    public function loadTable($class, $modelName)
    {
        $this->$modelName = new $class(App::getInstance()->getDatabase()->getPDO());
    }

}