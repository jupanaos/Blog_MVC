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
            $article = $articleRepository->getArticleById($articleId);
            
            $comment->setArticleId($articleId);
            $comment->setUserId($_SESSION['user']->getId());
            $comment->setDefaultStatus();
            
            $this->commentRepository->add($comment);
            $this->redirectToPrevious();
                echo "le comment est ajouté";
            } else {
                echo "Le comment n'est pas ajouté";
            }
    }
}