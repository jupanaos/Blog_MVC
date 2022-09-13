<?php


namespace App\Controllers;
use App\Models\Article;
use App\Repositories\ArticleRepository;

class AdminArticleController extends AdminController
{
    private $articleRepository;
    
    function __construct()
    {
        parent::__construct();
        $this->articleRepository = new ArticleRepository();
    }

    public function addArticle()
    {
        if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['status'])){
            $article = new Article($_POST);

            $article->setSlug($this->articleRepository->slugify($_POST['title']));
            $article->setStatus($_POST['status']);
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
        
        if (!empty($_POST)){
            $article = new Article($_POST);

            $article->setId($id);
            $article->setSlug($this->articleRepository->slugify($_POST['title']));
            $article->setStatus($_POST['status']);
            $article->setUserId($_SESSION['user']->getId());

            $this->articleRepository->edit($article);
            $this->redirectToAdmin();
        } else {
            echo "erreur màj article";
        }

        echo $this->twig->render('pages/admin/blog/edit.html.twig',
                                ['article' => $article[0]]);
    }

    public function deleteArticle(string $articleId)
    {
        $this->articleRepository->delete($articleId);
        $this->redirectToPrevious();
    }
}