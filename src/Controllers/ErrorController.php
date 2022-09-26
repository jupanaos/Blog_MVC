<?php

namespace App\Controllers;

class ErrorController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showError() {
        echo $this->twig->render("pages/client/errors/error.html.twig", []);
    }

    public function showNotFound() {
        echo $this->twig->display("pages/client/errors/not-found.html.twig", [
            'message' => 'La page que vous recherchez n\'existe pas ! ¯\_(ツ)_/¯'
        ]);
    }
}