<?php

namespace App\Repositories;
use App\Repositories\UserRepository;
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
        $userRepository = new UserRepository;

        $query = $this->prepare('SELECT * FROM comment WHERE id =' . '"'.$id.'"');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $item['author'] = $userRepository->getUserByItem($item);

            $comments[] = $this->transform($item);
        }

        return $comments[0];
    }

    public function getCommentsByUser()
    {
        $comments = [];
        $userId = $_SESSION['user']->getId();

        $items = $this->findBy(['user_id' => $userId], ['created_at' => 'DESC']);

        foreach($items as $item){
            $comments[] = $this->transform($item);
        }
        
        return $comments;
    }

    public function getCommentsByArticle($item)
    {
        $comments = [];
        $userRepository = new UserRepository;
        $commentsDB = $this->findBy(['article_id' => $item['id']]);

        foreach ($commentsDB as $commentDB) {
            $user = $userRepository->getAuthorByComment($commentDB);
            $comment = new Comment($commentDB);
            $comment->setAuthor($user);
            $comments[] = $comment;
        }

        return $comments;
    }


    /**
     * Array to Comment Object
     */
    public function transform(array $commentArray) {
        $comment = new Comment($commentArray);
        return $comment;
    }


    public function add(Comment $comment)
    {
        $userId = $comment->getAuthor()->getId();
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
            return true;
        } else {
            return false;
        }
    }

    public function updateStatus(Comment $comment)
    {
        $status = $comment->getStatus();
        $id = $comment->getId();

        $queryString = 'UPDATE comment SET status = :status
                        WHERE id = :id';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            return true;
        } else {
            return false;
        }

    }
}