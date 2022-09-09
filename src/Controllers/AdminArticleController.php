<?php


namespace App\Controllers;
use App\Models\Article;
use App\Repositories\ArticleRepository;

class AdminArticleController extends AbstractAdminController
{
    private $articleRepository;
    
    function __construct()
    {
        parent::__construct();
        $this->articleRepository = new ArticleRepository();
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
}