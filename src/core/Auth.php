<?php

namespace App\Core;
use App\Repositories\UserRepository;
use App\Models\User;

class Auth
{
    /**
     * Connection to users stored in db
     *
     * @var userManage;
     */
    private $userManage;
    private $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->userManage = new UserRepository();
    }

    public function isLogged()
    {
        if(empty($this->session->get('userId')) && empty($this->session->get('username'))){
            echo "il n'y a pas de user";
        } else {
            echo "il y a un user";
        }
    }

    // public function isAdmin(User $user)
    // {
    //     if($user->getRole() === false || $user->getRole() === 0){
    //         return false;
    //     }
    //     return true;
    // }
}