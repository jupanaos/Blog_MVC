<?php

namespace App\Controllers;

class AdminController extends AbstractController
{
    public function showAdmin()
    {
        echo "Dashboard admin";
    }

    public function showCommentList(){
        echo "comment admin";
    }

    public function manageArticles(){
        echo "manage article";
    }

    public function addArticle(){
        echo "add a post";
    }
}