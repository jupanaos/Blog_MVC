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
    }

    public function login()
    {
        if (!empty($_POST['username'])){
            $this->userRepository->tryLogin();
            
            if (self::isLoggedIn()){
                echo "l'utilisateur est logged in";
                $this->redirectToIndex();
            }
        }
        echo $this->twig->display('pages/login.html.twig');
    }

    public function isLoggedIn()
    {
        if($_SESSION['logged']){
            echo "on est connecté";
            return true;
        } else {
            echo "pas de connexion";
            return false;
        }
    }

    public function register()
    {
        if (!empty($_POST['username'])){
            if($_POST['password'] === $_POST['password-confirm']){
                $user = new User($_POST);
                $user->setPasswordHash($user->getPassword());
                $user->setDefaultRole($user->getRole());

                $this->userRepository->add($user);
            } else {
                echo "Le mot de passe est différent";
            }
        }

        if(empty($data['lastName']) || empty($data['firstName']) || empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            echo "Veuillez remplir tous les champs"; 
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/", $_POST['username'])){
            echo "Pseudo invalide";
        }

        echo $this->twig->display('pages/register.html.twig');
    }

    public function logout(){
        session_destroy();
        $this->redirectToIndex();
    }

}