<?php

namespace App\Repositories;
use App\Models\Comment;

class CommentRepository extends AbstractRepository
{
    protected $table = 'comment';
    // private $comments;

    // /**
    //  * Undocumented function
    //  *
    //  * @param $comment
    //  */
    // public function addComment($comment)
    // {
    //     $this->comments[] = $comment;
    // }

    /**
     * Get and return all comments
     *
     * @return $comments
     */
    public function getComments()
    {
        $comments = [];
        $items = $this->findAll();

        foreach($items as $item) {
            $comments[] = $this->transform($item);
        }

        return $comments;
    }

    // public function setComments($comments)
    // {
    //     foreach ($comments as $comment) {
    //         $comment = new Comment($comment['id'], $comment['user_id'], $comment['article_id'], $comment['content'], $comment['created_at'], $comment['status']);

    //         $this->addComment($comment);
    //     }
    // }

    /**
     * Array to Article Object
     */
    public function transform(array $commentArray) {
        return new Comment($commentArray);
    }
}