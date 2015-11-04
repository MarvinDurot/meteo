<?php

namespace App\Controllers;

use Core\Controller\Controller;
use Core\Database\Database;
use Core\Config;

class AppController extends Controller
{

    protected $viewPath;
    protected $template = 'default';

    public function __construct()
    {
        $this->viewPath = Config::get('dir.views');
    }

    public function loadModel($model)
    {
        $this->$model = new $model(Database::getInstance());
    }

}