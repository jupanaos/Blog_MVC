<?php

namespace App\Controllers;

use App\Repositories\CommentRepository;
use App\Models\Comment;
use App\Repositories\ArticleRepository;

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
        if (!empty($_POST)){

            
            $comment = new Comment($_POST);
            
            $articleRepository = new ArticleRepository();
            $articleRepository->getArticleById($articleId);
            
            $comment->setArticleId($articleId);
            $comment->setAuthor($_SESSION['user']);
            $comment->setDefaultStatus();
            
            if ($this->commentRepository->add($comment)) {
                $this->addFlashMessage('success', 'Votre commentaire a bien été envoyé, il sera publié après validation.');
            } else {
                echo 'une erreur est survenue, veuillez réessayer';
            }
        } else {
            $this->addFlashMessage('error', 'Votre commentaire n\'a pas pu être envoyé. Veuillez réessayer.');
        }
    }
}