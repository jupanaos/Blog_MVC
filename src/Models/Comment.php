<?php

namespace App\Models;

class Comment extends AbstractModel
{
    private $userId;
    private $articleId;
    private $content;
    private $createdAt;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // public function setUserId($userId)
    // {
    //     $this->userId = $userId;
    // }

    public function getArticleId()
    {
        return $this->articleId;
    }

    // public function setArticleId($articleId)
    // {
    //     $this->articleId = $articleId;
    // }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

}