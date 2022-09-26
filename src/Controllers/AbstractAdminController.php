<?php

namespace App\Controllers;

use App\Helpers\TwigGlobals;

abstract class AbstractAdminController extends AbstractController
{
    protected $admin;

    public function __construct()
    {
        parent::__construct();
        $this->admin = $this->checkAdmin();
    }

    /**
     * Get session and check if user is admin
     */
    private function checkAdmin()
    {
        return key_exists('user', $_SESSION) && !empty($_SESSION['user']) && $_SESSION['user']->isAdmin();
    }

    /**
     * Get role admin
     *
     * @return $admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }
    
}