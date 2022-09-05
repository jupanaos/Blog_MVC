<?php

namespace App\Controllers;
use App\Repositories\ArticleRepository;

class MainController extends AbstractController
{
    public function index()
    {
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->lastArticles();
        // var_dump($articles);

        echo $this->twig->render('pages/client/home.html.twig', ['articles' => $articles]);
    }
}