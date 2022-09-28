<?php

namespace App\Controllers;

use App\Repositories\CommentRepository;
use App\Models\Comment;
use App\Repositories\ArticleRepository;
use App\Helpers\Security;

class CommentController extends AbstractController
{
    private $commentRepository;

    function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        
    }

    public function addComment($articleId)
    {
        $commentData['content'] = Security::secureHTML($_POST['content']);
        
        if (!empty($commentData['content'])){

            $comment = new Comment($commentData);
            
            $articleRepository = new ArticleRepository();
            $articleRepository->getArticleById($articleId);
            
            $comment->setArticleId($articleId);
            $comment->setAuthor($_SESSION['user']);
            $comment->setDefaultStatus();
            
            if ($this->commentRepository->add($comment)) {
                $this->flashMessage->addFlashMessage('success', 'Votre commentaire a bien été envoyé, il sera publié après validation.');
            } else {
                $this->flashMessage->addFlashMessage('error', 'Une erreur est survenue, veuillez réessayer.');
            }
        } else {
            $this->flashMessage->addFlashMessage('error', 'Votre commentaire n\'a pas pu être envoyé. Veuillez réessayer.');
        }
    }
}