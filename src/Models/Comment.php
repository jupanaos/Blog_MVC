<?php

namespace App\Models;

class Comment extends AbstractModel
{
    public const PUBLISHED = 'Published';
    public const UNPUBLISHED = 'Pending';

    private $userId;
    private $articleId;
    private $content;
    private $status;
    private User $author = null;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setDefaultStatus()
    {
        $this->setStatus(self::UNPUBLISHED);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

}