<?php

namespace App\Core;

use App\Core\Request;
use App\Core\Router;

class Application
{
    public Router $router;
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