<?php

namespace App\Helpers;

use App\Repositories\AdminRepository;

class TwigGlobals
{
    public function getAdminRole()
    {
        return "admin";
    }

    public function getSession()
    {
        return $_SESSION;
    }

    public function isLoggedIn()
    {
        return $_SESSION['id'];
    }

}