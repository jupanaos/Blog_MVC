<?php

namespace App\Repositories;
use App\Models\Article;
use PDO;

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

        $items = $this->findBy([], ['created_at' => 'DESC'], 4);

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

    /**
     * Array to Article Object
     */
    public function transform(array $articleArray) {
        return new Article($articleArray);
    }

    public function add(Article $article)
    {
        $title = $article->getTitle();
        $slug = $article->getSlug();
        $content = $article->getContent();
        $picture = $article->getPicture();
        $status = $article->getStatus();
        $userId = $article->getUserId();

        $queryString = 'INSERT INTO article (title, slug, content, picture, status, userId)
                        VALUES (:title, :slug, :content, :picture, :status, :userId)';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":slug", $slug, PDO::PARAM_STR);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        $stmt->bindValue(":picture", $picture, PDO::PARAM_STR);
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
    
}