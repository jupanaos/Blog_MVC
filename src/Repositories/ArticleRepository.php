<?php

namespace App\Repositories;
use App\Models\Article;

class ArticleRepository extends AbstractRepository
{
    protected $table = 'article';
    private $articles;

    /**
     * Undocumented function
     *
     * @param $article
     */
    public function addArticle($article)
    {
        $this->articles[] = $article;
    }


    /**
     * Get and return all articles in post table
     *
     * @return $articles
     */
    public function getArticles()
    {
        $allArticles = $this->findAll();
        $this->setArticles($allArticles);
        return $this->articles;
    }

    public function lastArticles(){
        $query = $this->prepare('SELECT * FROM article ORDER BY created_at DESC LIMIT 4');
        $query->execute();
        $results = $query->fetchAll();
        $this->setArticles($results);
        return $this->articles;
    }

    public function getArticleBySlug($slug){
        $query = $this->prepare('SELECT * FROM article WHERE slug =' . '"'.$slug.'"');
        $query->execute();
        $results = $query->fetchAll();
        $this->setArticles($results);
        return $this->articles;
    }


    public function setArticles($articles)
    {
        foreach ($articles as $article) {
            $article = new Article($article['id'], $article['title'], $article['slug'], $article['content'], $article['picture'], $article['created_at'], $article['updated_at'], $article['status'], $article['user_id'] );

            $this->addArticle($article);
        }
    }


    
}