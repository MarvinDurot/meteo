<?php
namespace Core\Router;

/**
 * Class Router
 * @package Core\Router
 */
class Router
{

    private $url;
    private $routes = [];

    /**
     * Constructeur
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Ajout d'une route GET
     * @param $path
     * @param $callable
     */
    public function get($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }

    /**
     * Ajout d'une route POST
     * @param $path
     * @param $callable
     */
    public function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    /**
     * Recherche et exécute la bonne route
     * @return mixed
     * @throws RouterException
     */
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('Bad request method!');
        }

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }

        throw new RouterException('No matching routes!');
    }
}