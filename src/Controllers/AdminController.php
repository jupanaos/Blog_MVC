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
                                'comments' => $comments]
                                );
    }

    public function manageArticle($id)
    {
        $articleRepository = new ArticleRepository;
        $article = $articleRepository->getArticleById($id);

        echo $this->twig->render('pages/admin/article/manage.html.twig',
                                ['article' => $article[0]]);
    }

    public function manageUser($id)
    {
        $userRepository = new UserRepository;
        $user = $userRepository->getUserById($id);

        echo $this->twig->render('pages/admin/user/manage.html.twig',
                                ['user' => $user]);
    }

    public function manageRole($id)
    {
        $userRepository = new UserRepository;
        $user = $userRepository->getUserById($id);

        if(!empty($_POST)){
            $user->setRole($_POST["role"]);

            $userRepository->updateRole($user);
            $this->redirectToAdmin();
        }
    }

    public function manageComment($id)
    {
        $commentRepository = new CommentRepository;
        $comment = $commentRepository->getCommentById($id);

        if(!empty($_POST)){
            $comment->setStatus($_POST["status"]);

            $commentRepository->updateStatus($comment);
            $this->redirectToAdmin();
        }

        echo $this->twig->render('pages/admin/comment/status.html.twig',
                                ['comment' => $comment]);
    }
}