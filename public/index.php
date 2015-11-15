<?php
require '../vendor/autoload.php';
use Core\Router\Router;
use \App\Controllers\ApiController;
use \App\Controllers\StationsController;

define('ROOT', dirname(__DIR__));

// Création du routeur
$router = new Router($_GET['url']);

/**
 * Routage Interface Web 
 */

$router->get('/', function () {
    $controller = new StationsController();
    $controller->index();
});

$router->get('/stations/:id', function ($id) {
    $controller = new StationsController();
    $controller->show($id);
});

$router->get('/releves/:station', function ($station) {
    // formulaire d'ajout
});

/**
 * Routage API
 */

$router->get('/api', function () {
    $controller = new ApiController();
    $controller->doc();
});

$router->get('/api/stations', function () {
    $controller = new ApiController();
    $controller->stations();
});

$router->get('/api/stations/:id', function ($id) {
    $controller =  new ApiController();
    $controller->station($id);
});

$router->get('/api/releves/:station', function ($station) {
    $controller =  new ApiController();
    $controller->releves($station);
});

$router->post('/api/releves/:station', function ($station) {
    $controller =  new ApiController();
    $controller->add($station);
});


$router->run();