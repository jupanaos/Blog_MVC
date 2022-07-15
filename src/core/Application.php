<?php

namespace App\core;

use App\core\Request;
use App\core\Router;

class Application
{
    public Router $router; //typed property
    public Request $request;
    
    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        $this->router->resolve();
    }
}