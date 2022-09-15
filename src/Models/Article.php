<?php

namespace App\Models;

class Article extends AbstractModel
{
    public const STATUS_PUBLISHED = 'Published';
    public const STATUS_UNPUBLISHED = 'Pending';

    private $title;
    private $slug;
    private $content;
    // private $picture;
    private $status;
    // private $userId;

    private ?User $author = null;
    private array $comments = [];

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    // public function getPicture()
    // {
    //     return $this->picture;
    // }

    // public function setPicture($picture)
    // {
    //     $this->picture = $picture;
    // }


    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // public function setDefaultStatus()
    // {
    //     $this->setStatus(self::STATUS_UNPUBLISHED);
    // }

    // public function getUserId()
    // {
    //     return $this->userId;
    // }

    // public function setUserId($userId)
    // {
    //     $this->userId = $userId;
    // }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

}