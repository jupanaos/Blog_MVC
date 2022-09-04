<?php

namespace App\Controllers;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;

class AdminController extends AbstractController
{
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

    public function showCommentList(){
        echo "comment admin";
    }

    public function manageArticles(){
        echo "manage article";
    }

    public function addArticle(){
        echo "add a post";
    }
}