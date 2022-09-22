<?php

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Models\Article;

class ArticleController extends AbstractController
{
    private $articleRepository;

    function __construct() {
        parent::__construct();
        $this->articleRepository = new ArticleRepository();
    }

    public function showBlog()
    {
        $articles = $this->articleRepository->getArticles();

        echo $this->twig->render('pages/client/blog.html.twig', ['articles' => $articles]);
    }

    public function showArticle($id)
    {
        $articles = $this->articleRepository->getArticleWithComments($id);

        $messageFlash = $this->getFlashMessage();
        echo $this->twig->render('pages/client/article.html.twig',
                                ['article' => $articles[0],
                                'messages' => $messageFlash]);
    }

}