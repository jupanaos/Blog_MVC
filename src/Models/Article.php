<?php

namespace App\Models;

// class ArticleModel extends Model
// {
//     public function __construct()
//     {
//         $this->table = 'post';
//     }

// }

class Article
{
    private $id;
    private $title;
    private $excerpt;
    private $content;
    private $createdAt;
    private $editedAt;
    private $user;
    private $userFirstname;
    private $userLastname;

    public function __construct($id, $title, $excerpt, $content, $createdAt, $editedAt, $user, $userFirstname, $userLastname)
    {
        $this->id = $id;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->EditedAt = $editedAt;
        $this->user = $user;
        $this->userFirstname = $userFirstname;
        $this->userLastname = $userLastname;
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

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

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

    public function getEditedAt()
    {
        return $this->editedAt;
    }

    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUserFirstname()
    {
        return $this->userFirstname;
    }

    public function setUserFirstname($userFirstname)
    {
        $this->userFirstname = $userFirstname;
    }

    public function getUserLastname()
    {
        return $this->userLastname;
    }

    public function setUserLastname($userLastname)
    {
        $this->userLastname = $userLastname;
    }

    public function getUserImage()
    {
        return $this->userImage;
    }

    public function setUserImage($userImage)
    {
        $this->userImage = $userImage;
    }
}