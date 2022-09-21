<?php

namespace App\Repositories;
use App\Models\Article;
use PDO;
use App\Models\User;
use App\Models\Comment;

class ArticleRepository extends AbstractRepository
{
    protected $table = 'article';

    /**
     * Get and return all articles in article table
     *
     * @return $articles
     */
    public function getArticles()
    {
        $articles = [];
        $items = $this->findAll();

        foreach($items as $item) {
            $articles[] = $this->transform($item);
        }

        return $articles;
    }

    public function lastArticles()
    {
        $articles = [];

        $items = $this->findBy(['status' => Article::STATUS_PUBLISHED], ['created_at' => 'DESC'], 4);

        foreach($items as $item) {
            $articles[] = $this->transform($item);
        }

        return $articles;
    }

    public function getArticleBySlug($slug)
    {
        $articles = [];
        $query = $this->prepare('SELECT * FROM article WHERE slug =' . '"'.$slug.'"');
        $query->execute();

        $items = $query->fetchAll();
        
        //$items = $this->findBy(['slug' => $slug]);

        foreach($items as $item) {
            $articles[] = $this->transform($item);
        }

        return $articles;
    }

    public function getArticleById($id)
    {
        $articles = [];
        $query = $this->prepare('SELECT * FROM article WHERE id =' . '"'.$id.'"');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $articles[] = $this->transform($item);
        }

        return $articles;
    }

    public function pushUser() 
    {

    }

    public function getArticleWithComments($id)
    {

        $articles = [];
        $userRepository = new UserRepository;
        $commentRepository = new CommentRepository;

        $query = $this->prepare('SELECT * FROM article WHERE id =' . '"'.$id.'"');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $item['author'] = $userRepository->getUserByArticle($item);
            // $userDB = $userRepository->findBy(['id' => $item['user_id']]);
            // $user = new User($userDB[0]);
            // $item['author'] = $user;
            $item['comments']= $commentRepository->getCommentsByArticle($item);
            // $commentsDB = $commentRepository->findBy(['article_id' => $item['id']]);

            // foreach ($commentsDB as $commentDB) {
            //     $item['comments'][] = new Comment($commentDB);
            // }
                foreach ($item['comments'] as $comment) {
                    $comment->setAuthor($userRepository->getAuthorByComment($comment));
                }
            $articles[] = $this->transform($item);
        }
        // echo '<pre>' , var_dump($articles) , '</pre>';
        
        return $articles;

    }

    /**
     * Array to object
     *
     * @param array $articleArray
     * @return $article
     */
    public function transform(array $articleArray) {
        $article = new Article($articleArray);
        return $article;
    }


    public function add(Article $article)
    {
        $title = $article->getTitle();
        $slug = $article->getSlug();
        $content = $article->getContent();
        // $picture = $article->getPicture();
        $status = $article->getStatus();
        // $userId = $article->getUserId();
        $userId = $article->getAuthor()->getId();

        $queryString = 'INSERT INTO article (title, slug, content, status, user_id)
                        VALUES (:title, :slug, :content, :status, :userId)';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":slug", $slug, PDO::PARAM_STR);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        // $stmt->bindValue(":picture", $picture, PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            // return true;
            echo "article ajouté";
        } else {
            // return false;
            echo "échec ajout";
        }
    }

    public function edit(Article $article)
    {
        $title = $article->getTitle();
        $content = $article->getContent();
        // $picture = $article->getPicture();
        $slug = $article->getSlug();
        $status = $article->getStatus();
        // $userId = $article->getUserId();
        $userId = $article->getAuthor()->getId();
        $id = $article->getId();

        $queryString = 'UPDATE article SET title = :title,
                                        content = :content,
                                        slug = :slug,
                                        status = :status,
                                        user_id = :userId
                        WHERE id = :id';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        $stmt->bindValue(":slug", $slug, PDO::PARAM_STR);
        // $stmt->bindValue(":picture", $picture, PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(string $articleId)
    {
        $queryString = "DELETE FROM article WHERE id=:id";
        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(':id', $articleId, PDO::PARAM_STR);

        $stmt->execute();
        $stmt->closeCursor();
    }
    
}