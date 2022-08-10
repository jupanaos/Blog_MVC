<?php

namespace App\Core;

use App\Core\Request;
use App\Controllers\MainController;

class Router
{
    public Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->get('/', [MainController::class, 'index']);
    }

    public function get($path, $callback) //when path value is something, callback is executed
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false)
        {
            echo 'Not Found';
            return "Not found";
        }
        if (is_string($callback))
        {
            echo 'Callback is string';
            return $this->renderView($callback);
        }
        echo 'Callback function';
        return call_user_func($callback);
    }

    public function renderView($view)
    {
        // include_once ROOT."/Views/$view.html.twig";
        return $this->get('/', []);
    }

}