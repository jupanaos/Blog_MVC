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
        var_dump($_POST);
        if (!empty($_POST)){
            $comment = new Comment($_POST);
            $articleRepository = new ArticleRepository();
            $article = $articleRepository->getArticleById($articleId);


            // $comment->setDefaultStatus();
            // $comment->setArticleId($article);
            

        }
    }
}