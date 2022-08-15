<?php

namespace App\Controllers;

class MainController extends AbstractController
{
    public function index()
    {
        echo $this->twig->display('home.html.twig');
    }
}