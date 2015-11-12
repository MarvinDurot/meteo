<?php

namespace App\Controllers;

use App\App;
use Core\Config;
use Core\Controller\Controller;

class AppController extends Controller
{

    protected $viewPath;
    protected $template = 'default';

    public function __construct()
    {
//        $this->viewPath = Config::get('dir.views');
    }

    public function loadModel($class, $modelName)
    {
        $this->$modelName = new $class(App::getInstance()->getDatabase()->getPDO());
    }

}