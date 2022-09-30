<?php

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Repositories\AdminRepository;
use App\Repositories\CommentRepository;

class AdminController extends AbstractAdminController
{
    private $adminRepository;

    function __construct() {
        parent::__construct();
        $this->adminRepository = new AdminRepository();
    }

    public function showAdmin()
    {
        $articleRepository = new ArticleRepository;
        $articles = $articleRepository->getArticles();

        $userRepository = new UserRepository;
        $users = $userRepository->getUsers();

        $commentRepository = new CommentRepository;
        $comments = $commentRepository->getComments();
        
        $this->showTwig('pages/admin/admin.html.twig',
                                ['articles' => $articles,
                                'users' => $users,
                                'comments' => $comments
                                ]
                                );
    }

}