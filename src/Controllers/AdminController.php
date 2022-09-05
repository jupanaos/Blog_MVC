<?php

namespace App\Controllers;

use App\Models\Article;
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

    public function addArticle()
    {
        echo $this->twig->render('pages/admin/blog/add.html.twig');
    }

    public function editArticle($id)
    {
        $articleRepository = new ArticleRepository;
        $article = $articleRepository->getArticleById($id);

        echo $this->twig->render('pages/admin/blog/edit.html.twig',
                                ['article' => $article[0]]);
    }

    public function deleteArticle()
    {
        // TO DO
    }

    public function manageUser()
    {
        //TO DO
    }

    public function manageComment()
    {
        // TO DO
    }
}