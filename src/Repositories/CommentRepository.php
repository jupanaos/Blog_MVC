<?php

namespace App\Repositories;
use App\Models\Comment;
use PDO;

class CommentRepository extends AbstractRepository
{
    protected $table = 'comment';

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

    public function getCommentById($id)
    {
        $comments = [];
        $query = $this->prepare('SELECT * FROM comment WHERE id =' . '"'.$id.'"');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $comments[] = $this->transform($item);
        }

        return $comments;
    }

    /**
     * Array to Comment Object
     */
    public function transform(array $commentArray) {
        return new Comment($commentArray);
    }


    public function add(Comment $comment)
    {
        $userId = $comment->getUserId();
        $articleId = $comment->getArticleId();
        $content = $comment->getContent();
        $status = $comment->getStatus();

        $queryString = 'INSERT INTO comment (user_id, article_id, content, status)
                        VALUES (:userId, :articleId, :content, :status)';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":articleId", $articleId, PDO::PARAM_INT);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            // return true;
            echo "comment ajouté";
        } else {
            // return false;
            echo "échec ajout";
        }
    }
}