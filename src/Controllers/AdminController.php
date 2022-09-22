<?php

namespace App\Controllers;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Repositories\AdminRepository;
use App\Models\User;
use App\Repositories\CommentRepository;

class AdminController extends AbstractAdminController
{
    private $adminRepository;

    function __construct() {
        parent::__construct();
        $this->adminRepository = new AdminRepository();
    }

    public function showAdmin()
    {
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->getArticles();

        $userRepository = new UserRepository;
        $users = $userRepository->getUsers();

        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getComments();
        
        echo $this->twig->render('pages/admin/admin.html.twig',
                                ['articles' => $articles,
                                'users' => $users,
                                'comments' => $comments
                                ]
                                );
    }

    public function manageUser($id)
    {
        $userRepository = new UserRepository;
        $user = $userRepository->getUserById($id);

        if(!empty($_POST)){
            $user->setRole($_POST["role"]);

            if($userRepository->updateRole($user)) {
                $this->addFlashMessage('success', 'Le rôle de cet utilisateur a bien été modifié.');
            } else {
                $this->addFlashMessage('error', 'Le rôle de cet utilisateur n\'a pas pu être modifié, veuillez réessayer.');
            }
        }

        $messageFlash = $this->getFlashMessage();
        echo $this->twig->render('pages/admin/user/manage.html.twig',
                                ['user' => $user,
                                'messages' => $messageFlash]);
    }

    public function manageComment($id)
    {
        $commentRepository = new CommentRepository;
        $comment = $commentRepository->getCommentById($id);

        if(!empty($_POST)){
            $comment->setStatus($_POST["status"]);

            if ($commentRepository->updateStatus($comment)) {
                $this->addFlashMessage('success', 'Le statut de ce commentaire a bien été mis à jour.');
            } else {
                $this->addFlashMessage('error', 'Le statut de ce commentaire n\'a pas pu être modifié, veuillez réessayer.');
            }
        }

        $messageFlash = $this->getFlashMessage();
        echo $this->twig->render('pages/admin/comment/status.html.twig',
                                ['comment' => $comment,
                                'messages' => $messageFlash]);
    }
}