<?php

namespace App\Controllers;

class AccountController extends AbstractController
{
    public function login()
    {
        echo $this->twig->display('pages/login.html.twig');
    }

    public function register(){
        echo $this->twig->display('pages/login.html.twig');
    }

    public function logout(){
        echo "logout";
    }
}