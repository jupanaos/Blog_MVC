<?php

namespace App\Helpers;
use App\Repositories\AdminRepository;

class TwigGlobals
{
    public function getAdminRole()
    {
        return "admin";
    }

    public function getAdmin()
    {
        $adminRepository = new AdminRepository();
        return $adminRepository->findAdmin($this->getAdminRole());
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