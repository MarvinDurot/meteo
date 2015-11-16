<?php
require '../vendor/autoload.php';
use Core\Router\Router;
use \App\Controllers\ApiController;
use \App\Controllers\StationsController;
use \App\Controllers\MesuresController;

// Racine de l'application
define('ROOT', dirname(__DIR__));

// Réglage du fuseau pour les timestamps
date_default_timezone_set('Europe/Paris');

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

$router->get('/mesures/:station', function ($station) {
    $controller = new MesuresController();
    $controller->create($station);
});

$router->post('/mesures/:station', function ($station) {
    $controller = new MesuresController();
    $controller->create($station);
});

$router->get('/mesures', function () {
    $controller = new MesuresController();
    $controller->upload();
});

$router->post('/mesures', function () {
    $controller = new MesuresController();
    $controller->upload();
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

$router->get('/api/mesures/:station', function ($station) {
    $controller =  new ApiController();
    $controller->mesures($station);
});

$router->post('/api/mesures', function () {
    $controller =  new ApiController();
    $controller->create();
});

$router->run();