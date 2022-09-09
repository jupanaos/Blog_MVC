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
        echo $this->twig->display('pages/client/login.html.twig');
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
                $user->setDefaultRole();

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

        echo $this->twig->display('pages/client/register.html.twig');
    }

    public function logout()
    {
        session_destroy();
        $this->redirectToIndex();
    }

    public function showDashboard()
    {
        // $userRepository = new userRepository;
        // $user = $userRepository->getUserById($id);
        echo $this->twig->render('pages/client/dashboard.html.twig');
    }

    public function editUser(string $userId)
    {
        // Login: /login
        // Dashaboard admin : /admin => si logger => dashboard sinon visiteur => redirect to login
        // Liste : /admin/users
        // Create: /admin/users/create
        // Show 1 : /admin/users/14
        // Edit : /admin/users/14/edit  e=users&id=14&action=edit
        // Delete : /admin/users/14/delete


        // CRUD: LIST, SHOW, CREATE/EDIT, DELETE
        var_dump($_POST);

        if(!empty($_POST)){
            if (empty($_POST['password']) || ($_POST['password'] === $_POST['password-confirm']) && !empty($_POST['password'] )) {

                $user = new User($_POST);
                $user->setId($userId);

                if(!empty($_POST['password'])){
                    $user->setPasswordHash($_POST['password']);
                }
                $user->setDefaultRole();
                var_dump($user);
                
                // $this->userRepository->update($user);
                // var_dump($user);
            }
        }
    }

    public function deleteUser(string $userId)
    {
        // var_dump($user);
        $this->userRepository->delete($userId);
        $this->redirectToPrevious();
        // echo $this->twig->render('pages/admin/admin.html.twig');
    }

}