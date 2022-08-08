<?php

namespace App\Controllers;


class MainController extends AbstractController
{
    public function index()
    {
        // $template = $this->twig->load('home.html');
        // echo 'hey';
        $this->render('home.html.twig');
        // $this->twig->display('home.html.twig');
    }
}