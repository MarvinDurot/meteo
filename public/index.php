<?php
require '../vendor/autoload.php';
use Core\Router\Router;

$router = new Router($_GET['url']);

$router->get('/', function() { echo 'Homepage.'; });
$router->get('/stations', function() { echo 'Toutes les stations.'; });
$router->get('/stations/:id', function($id) { echo "Afficher la station $id"; });

$router->run();
