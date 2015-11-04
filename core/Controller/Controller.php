<?php

namespace Core\Controller;

class Controller
{

    protected $viewPath;
    protected $template;

    public function render($view, $variables = [])
    {
        ob_start();
        extract($variables);
        $view = $this->viewPath . str_replace('.', '/', $view) . '.php';
        $content = ob_get_clean();
        require($this->viewPath . $this->template . '.php');
    }

    protected function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable !');
    }
}