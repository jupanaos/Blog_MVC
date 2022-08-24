<?php

namespace App\Controllers;
use App\Repositories\ArticleRepository;

class AdminController extends AbstractController
{
    public function showAdmin()
    {
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->getArticles();
        echo $this->twig->render('pages/admin.html.twig', ['articles' => $articles]);
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