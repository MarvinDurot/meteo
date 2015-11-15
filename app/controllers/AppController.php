<?php

namespace App\Controllers;
use App\App;
use Core\Controller\Controller;

class AppController extends Controller
{

    protected $template = 'default';

    public function __construct()
    {
        $this->viewPath = ROOT . '/app/views/';
    }

    public function loadModel($class, $modelName)
    {
        $this->$modelName = new $class(App::getInstance()->getDatabase()->getPDO());
    }

}