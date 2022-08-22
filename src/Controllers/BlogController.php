<?php

namespace App\Controllers;
use App\Repositories\ArticleRepository;

class BlogController extends AbstractController
{
    public function showBlog()
    {
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->getArticles();
        echo $this->twig->render('pages/blog.html.twig', ['articles' => $articles]);
    }

    public function showArticle($slug){
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->getArticleBySlug($slug);
        echo $this->twig->render('pages/article.html.twig', ['article' => $articles[0]]);
    }
}