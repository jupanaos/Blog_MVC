<?php

namespace App\Helpers;

class TwigGlobals
{
    public function getAdminId()
    {
        return 1;
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