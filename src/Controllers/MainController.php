<?php

namespace App\Controllers;


class MainController extends AbstractController
{
    public function index()
    {
        $this->twig->display('main/index.html.twig');
    }
}