<?php

namespace App\Models;

class Article
{
    private $id;
    private $title;
    private $slug;
    private $content;
    private $picture;
    private $createdAt;
    private $updatedAt;
    private $status;
    private $userId;

    public function __construct($id, $title, $slug, $content, $picture, $createdAt, $updatedAt, $status, $userId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->picture = $picture;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->status = $status;
        $this->userId = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

}