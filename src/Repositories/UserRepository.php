<?php

namespace App\Repositories;

use App\Core\Session;
use App\Models\User;

class UserRepository extends AbstractRepository
{
    protected $table = 'user';
    public function register()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'lastName' => trim($_POST['lastName']),
            'firstName' => trim($_POST['firstName']),
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
        ];

        if(empty($data['lastName']) || empty($data['firstName']) || empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            echo "Veuillez remplir tous les champs"; 
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])){
            echo "Pseudo invalide";
        }
    }

    public function tryLogin()
    {
        $password = $_POST['password'];
        $username = $_POST['username'];
        $user = $this->findItemBy(['username' => $username]);
        // var_dump($user);

        // if(isset($user)){
        //     if(password_verify($password, $user->getPassword())){
        //         // $user->setPassword();
        //         $session = new Session;
        //         $session->createSession();
        //         return $user;
        //     } else {
        //         return "le mot de passe ne correspond pas";
        //     }
        // } else {
        //     return "le compte n'existe pas";
        // }
    }

    // public function createSession(User $userInfos)
    // {
    //     $_SESSION['user'] = $userInfos;
    //     $_SESSION['loginDate'] = date('d-m-Y H:i:s');
    //     $_SESSION['logged'] = TRUE;
    // }
}