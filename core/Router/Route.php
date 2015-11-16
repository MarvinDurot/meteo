<?php
namespace Core\Router;

/**
 * Class Route
 * @package Core\Router
 */
class Route
{
    /**
     * Chemin
     * @var string
     */
    private $path;

    /**
     * Fonction callback
     * @var
     */
    private $callable;

    /**
     * Paramètres reconnus
     * @var
     */
    private $matches;

    /**
     * Construction
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * Teste si la route correspond à l'URL
     * @param $url
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * Exécute la fonction de callback en lui passant les paramètres reconnus
     * @return mixed
     */
    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }

}