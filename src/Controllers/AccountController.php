<?php

namespace App\Controllers;

class AccountController extends AbstractController
{
    public function login()
    {
        echo "Login";
    }

    public function register(){
        echo "register";
    }

    public function logout(){
        echo "logout";
    }
}