<?php

namespace Core\Controller;

class Controller
{

    /**
     * Répertoire des vues
     * @var
     */
    protected $viewPath;

    /**
     * Template utilisé
     * @var
     */
    protected $template;

    /**
     * Charge le contenu d'une vue et l'affiche
     * @param $view
     * @param array $variables
     */
    public function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . '/templates/' . $this->template . '.php');
    }

    /**
     * Not found
     */
    protected function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable !');
    }
}