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
        if(!empty($_POST)){

            if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['status'])) {
                $article = new Article($_POST);

                $article->setSlug($this->articleRepository->slugify($_POST['title']));
                $article->setStatus($_POST['status']);
                $article->setAuthor($_SESSION['user']);

                if ($this->articleRepository->add($article)) {
                    $this->addFlashMessage('success', 'L\'article a bien été ajouté !');
                } else {
                    $this->addFlashMessage('error', 'L\'article n\'a pas pu être ajouté.');
                }

            } else {
                $this->addFlashMessage('error', 'Veuillez remplir tous les champs.');
            }
        }

        $messageFlash = $this->getFlashMessage();
        echo $this->twig->render('pages/admin/blog/add.html.twig',
                                ['messages' => $messageFlash]);
    }

    public function editArticle($id)
    {
        $articles = $this->articleRepository->getArticleById($id);
        
        if (!empty($_POST)){
            $article = new Article($_POST);

            $article->setId($id);
            $article->setSlug($this->articleRepository->slugify($_POST['title']));
            $article->setStatus($_POST['status']);
            $article->setAuthor($_SESSION['user']);

            if ($this->articleRepository->edit($article)) {
                $this->addFlashMessage('success', 'L\'article a bien été modifié !');
            } else {
                $this->addFlashMessage('error', 'L\'article n\'a pas pu être modifié, veuillez réessayer.');
            }
        }

        $messageFlash = $this->getFlashMessage();
        echo $this->twig->render('pages/admin/blog/edit.html.twig',
                                ['article' => $articles[0],
                                'messages' => $messageFlash]);
    }

    public function deleteArticle(string $articleId)
    {
        if ($this->articleRepository->delete($articleId)) {
            $this->addFlashMessage('success', 'L\'article a bien été supprimé');
        } else {
            $this->addFlashMessage('error', 'L\'article n\'a pas pu être supprimé, veuillez réessayer.');
        }
        $this->redirectToPrevious();
    }
}