<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Repositories\CommentRepository;

class UserController extends AbstractController
{
    private $userRepository;

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
        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getCommentsByUser();
        
        echo $this->twig->render('pages/client/dashboard.html.twig',
                                ['comments' => $comments]);
    }

    public function updateUser($id)
    {
        $userRepository = new UserRepository;
        $userArray = $userRepository->getUserById($id);
        $userObject = $userArray;
        
        if (!empty($_POST)){
            $user = new User($_POST);
            
            $user->setId($id);
            
            if($userObject->getRole() === 'admin'){
                $user->setRole("admin");
            } else {
                $user->setDefaultRole();
            }

            $this->userRepository->update($user);
            $this->userRepository->userSession($user);
            
        }
            $this->redirectToDashboard();

    }
    
    public function resetPassword(string $userId)
    {        
        $oldPassword = strip_tags($_POST['old-password']);
        $newPassword = strip_tags($_POST['new-password']);
        $newPasswordConfirm = strip_tags($_POST['new-password-confirm']);

        $userRepository = new UserRepository;
        $user = $this->userRepository->getUserById($userId);
        $sessionPassword = $_SESSION['user']->getPassword();

        if(password_verify($oldPassword, $sessionPassword)){

            if($newPassword === $newPasswordConfirm){
                $user->setPasswordHash($newPassword);
                $userRepository->updatePassword($user);
                $this->logout();
                echo "veuillez vous reconnecter";
            } else {
                echo "les nouveaux mdp ne matchent pas";
            }

        } else {
            echo "l'ancien password n'existe pas";
        }
        
    }

    public function deleteUser(string $userId)
    {
        // var_dump($user);
        $this->userRepository->delete($userId);
        $this->redirectToPrevious();
    }

}