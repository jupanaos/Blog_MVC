<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Core\Auth;
use App\Models\User;

class AccountController extends AbstractController
{
    private $userRepository;
    private $userAuth;

    /**
     */
    function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userAuth = new Auth();
    }

    
    public function login()
    {
        if (!empty($_POST['username'])){
            $this->userRepository->tryLogin();
        }
        echo $this->twig->display('pages/login.html.twig');
    }

    public function register(){
        if (!empty($_POST['username'])){
            $user = new User($_POST);
            var_dump($user);
        }
        echo $this->twig->display('pages/register.html.twig');
    }

    public function logout(){
        echo "logout";
    }
}