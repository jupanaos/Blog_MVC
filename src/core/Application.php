<?php

namespace App\Core;
use App\Controllers\MainController;
use App\Controllers\BlogController;
use App\Controllers\AccountController;
use App\Controllers\AdminController;
use App\Controllers\ContactController;

class Application
{
    public function run()
    {
        // Delete trailing slash
        // Get URL
        $uri = $_SERVER['REQUEST_URI'];
        // var_dump($uri);
        
        // Check if URI is not empty and ends with a /
        if(!empty($uri) && $uri != '/' && $uri[-1] === "/"){
            $uri = substr($uri, 0, -1);

            // Redirect to URL with no /
            http_response_code(301);
            header('Location: '.$uri);
        }

        // // Manage URL params in array
        // $params = explode('/', $_GET['']);
        // $params = [];
        // if(isset($_GET['p'])){
        //      $params = explode('/', $_GET['p']);
        //     //  var_dump($_GET);
        //  }

        // if($params[0] != ''){
        //     // We have at least one param
        //     // Get the controller name to instantiate
        // //$controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
        // $controller = "blabla";
        // var_dump($controller);
        // die;
            
        // }

        $blogController = new BlogController;
        $accountController = new AccountController;
        $adminController = new AdminController;
        $contactController = new ContactController;

        $params = explode("/", filter_var($_GET['p']), FILTER_SANITIZE_URL);
        
        if(isset($_GET['p'])){
            switch($params[0]){
                case "blog":
                    if(empty($params[1])){
                        $blogController->showBlog();
                    } elseif($params[1] === "article") {
                        $blogController->showArticle($params[2]);
                    }
                    break;
                case "account":
                    if((empty($params[1])) || ($params[1] === "login")){
                        $accountController->login();
                    } elseif($params[1] === "register") {
                        $accountController->register();
                    }
                    break;
                case "admin":
                    $accountController->logout();
                    if($params[1] === "login") {
                        $accountController->login();
                    } elseif ($params[1] === "dashboard") {
                        $adminController->showAdmin();
                    } elseif ($params[1] === "comments") {
                        $adminController->showCommentList();
                    } elseif ($params[1] === "articles") {
                        if (empty($params[2])) {
                            $adminController->manageArticles();
                        } elseif ($params[2] === "add") {
                            $adminController->addArticle();
                        }
                    }
                    break;
                case "contact":
                    $contactController->contact();

            }
            
        
        } else {
            // No param so we call default controller (MainController)
            $controller = new MainController;
            $controller->index();
        }

    }
}