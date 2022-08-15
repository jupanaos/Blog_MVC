<?php

namespace App\Controllers;

class BlogController extends AbstractController
{
    public function showBlog()
    {
        echo "Le blog";
    }

    public function showArticle(){
        echo $this->twig->display('article.html.twig');
    }
}