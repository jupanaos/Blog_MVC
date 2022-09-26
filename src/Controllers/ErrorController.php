<?php

namespace App\Controllers;

class ErrorController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showError() {
        $this->showTwig("pages/client/errors/error.html.twig", []);
    }

    public function showNotFound() {
        $this->showTwig("pages/client/errors/not-found.html.twig", [
            'message' => 'La page que vous recherchez n\'existe pas ! ¯\_(ツ)_/¯'
        ]);
    }
}