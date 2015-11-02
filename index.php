<?php

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

$router->get('/stations', function() {
   echo 'Toutes les stations.';
});
$router->get('/stations/:id', function($id) {
    echo "Afficher la station $id";
});
$router->get('/releves', function() {
    echo 'Les relevés';
});
$router->post('/releves/:station', function($station) {
    echo 'Ajouter un relevé.';
});

$router->run();
