<?php

namespace App\Controllers;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Repositories\AdminRepository;

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
        
        echo $this->twig->render('pages/admin/admin.html.twig',
                                ['articles' => $articles,
                                'users' => $users]
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
                                ['user' => $user[0]]);
    }

    public function manageComment()
    {
        // TO DO
    }
}