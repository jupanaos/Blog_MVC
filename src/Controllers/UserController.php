<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Repositories\CommentRepository;
use App\Helpers\Security;
use App\Helpers\Validation;

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
            $tryLogin = $this->userRepository->tryLogin();
            
            if (is_object($tryLogin)){
                $this->addFlashMessage('success', 'Vous êtes bien connecté.');
                // $this->refreshPage();
                $this->redirectToDashboard();
            } else {
                $this->addFlashMessage('error', $tryLogin);
            }
        }

        $messageFlash = $this->getFlashMessage();
        $this->showTwig('pages/client/login.html.twig',
        ['messages' => $messageFlash]);
    }

    public function isLoggedIn()
    {
        if($_SESSION['logged']){
            return true;
        } else {
            return false;
        }
    }

    public function register()
    {
        $registerData = [];

        $registerData['last_name'] = Security::secureHTML($_POST['last_name']);
        $registerData['first_name'] = Security::secureHTML($_POST['first_name']);
        $registerData['username'] = Security::secureHTML($_POST['username']);
        $registerData['email'] = Security::validateEmail($_POST['email']);
        $registerData['password'] = Security::secureHTML($_POST['password']);
        $registerData['password-confirm'] = Security::secureHTML($_POST['password-confirm']);

        if(!empty($registerData['last_name'])){

            if (empty($registerData['last_name']) || empty($registerData['first_name']) || empty($registerData['username']) || empty($registerData['email']) || empty($registerData['password'])) {
                $this->addFlashMessage('error', 'Merci de remplir tous les champs d\'inscription.');
            } else {
                if (!empty($registerData['username'] ) && !$this->userRepository->usernameExists()){
                
                    if(Validation::checkPassword($registerData['password'])){
    
                        if($registerData['password'] === $registerData['password-confirm']){
                            $user = new User($registerData);
                            $user->setPasswordHash($user->getPassword());
                            $user->setDefaultRole();
    
                            $this->userRepository->add($user);
                            $this->addFlashMessage('success', 'Votre compte a bien été créé. Veuillez vous connecter.');
                        } else {
                            $this->addFlashMessage('error', 'Les mots de passe sont différents.');
                        }
                    } else {
                        $this->addFlashMessage('error', 'Votre mot de passe doit contenir au moins 8 caractères dont une majuscule, un chiffre et un caractère spécial.');
                    }
    
                }  elseif (Validation::checkUsername($registerData['username']) || $this->userRepository->usernameExists()){
                    $this->addFlashMessage('error', 'Pseudo déjà pris ou invalide. Seuls les lettres et les chiffres sont acceptés.');
                }
            }
        }

        $messageFlash = $this->getFlashMessage();
        $this->showTwig('pages/client/register.html.twig',
                        ['messages' => $messageFlash]);
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
        $messageFlash = $this->getFlashMessage();

        $this->showTwig('pages/client/dashboard.html.twig',
                        ['comments' => $comments,
                        'messages' => $messageFlash]);
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

            $this->addFlashMessage('success', 'Vos informations ont bien été mises à jour.');
        }

        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getCommentsByUser();
        $messageFlash = $this->getFlashMessage();

        $this->showTwig('pages/client/dashboard.html.twig',
                        ['comments' => $comments,
                        'messages' => $messageFlash]);
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
                $this->addFlashMessage('notice', 'Votre mot de passe a été mis à jour. Veuillez vous reconnecter.');
            } else {
                $this->addFlashMessage('error', 'Les nouveaux mots de passe ne sont pas les mêmes.');
            }

        } else {
            $this->addFlashMessage('error', 'L\'ancien mot de passe ne correspond pas à ce compte.');
        }

        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getCommentsByUser();
        $messageFlash = $this->getFlashMessage();

        $this->showTwig('pages/client/dashboard.html.twig',
                        ['comments' => $comments,
                        'messages' => $messageFlash]);
    }

    public function deleteUser(string $userId)
    {
        $this->userRepository->delete($userId);
        $this->redirectToPrevious();
    }

}