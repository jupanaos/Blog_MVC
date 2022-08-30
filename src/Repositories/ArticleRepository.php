<?php

namespace App\Repositories;
use App\Models\Article;

class ArticleRepository extends AbstractRepository
{
    protected $table = 'article';

    /**
     * Undocumented function
     *
     * @param $article
     */
    /*public function addArticle($article)
    {
        $this->articles[] = $article;
    }*/

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

    /**
     * Array to Article Object
     */
    public function transform(array $articleArray) {
        return new Article(
            $articleArray['id'],
            $articleArray['title'],
            $articleArray['slug'],
            $articleArray['content'],
            $articleArray['picture'],
            $articleArray['created_at'],
            $articleArray['updated_at'],
            $articleArray['status'],
            $articleArray['user_id']
        );
    }
    
}