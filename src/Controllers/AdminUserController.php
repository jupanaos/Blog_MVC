<?php

namespace App\Controllers;
use App\Repositories\UserRepository;

class AdminUserController extends AdminController
{
    function __construct() {
        parent::__construct();
    }
    
    public function manageUser($id)
    {
        $userRepository = new UserRepository;
        $user = $userRepository->getUserById($id);

        if(!empty($_POST)){
            $user->setRole($_POST["role"]);

            if($userRepository->updateRole($user)) {
                $this->flashMessage->addFlashMessage('success', 'Le rôle de cet utilisateur a bien été modifié.');
            } else {
                $this->flashMessage->addFlashMessage('error', 'Le rôle de cet utilisateur n\'a pas pu être modifié, veuillez réessayer.');
            }
        }

        $messageFlash = $this->flashMessage->getFlashMessage();
        $this->showTwig('pages/admin/user/manage.html.twig',
                                ['user' => $user,
                                'messages' => $messageFlash]);
    }
}