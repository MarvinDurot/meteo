<?php
require '../vendor/autoload.php';
use Core\Router\Router;
use App\Tables\Stations;
use App\Tables\Mesures;
use App\App;

$router = new Router($_GET['url']);

$router->get('/', function () {

});

$router->get('/stations', function () {
    $controller = new \App\Controllers\ApiController();
    $controller->stations();
});

$router->get('/stations/:id', function ($id) {
    $controller =  new \App\Controllers\ApiController();
    $controller->station($id);
});

$router->get('/releves/:station', function ($station) {

    var_dump($station);

    $controller =  new \App\Controllers\ApiController();
    $controller->releves($station);
});

$router->run();
