<?php

namespace App\Controllers;
use App\Repositories\PostRepository;

class MainController extends AbstractController
{
    public function index()
    {
        $postRepository = new PostRepository;
        $data = $postRepository->findAll();
        var_dump($data);
        echo $this->twig->display('pages/home/home.html.twig');
    }
}