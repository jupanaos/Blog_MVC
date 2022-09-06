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

    public function showArticle($id){
        $articles = $this->articleRepository->getArticleById($id);
        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getComments();

        echo $this->twig->render('pages/client/article.html.twig',
            ['article' => $articles[0]],
            ['comments' => $comments]);
    }

    public function addArticle()
    {
        if (!empty($_POST)){
            $article = new Article($_POST);

            $article->setSlug($this->articleRepository->slugify($_POST['title']));
            $article->setDefaultStatus();
            $article->setUserId($_SESSION['user']->getId());

            $this->articleRepository->add($article);
                echo "l'article est ajouté";
            } else {
                echo "L'article n'est pas ajouté";
            }

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
}