<?php

namespace App\Core;
use App\Controllers\MainController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\ContactController;
use App\Controllers\ArticleController;
use App\Controllers\AdminArticleController;
use App\Controllers\CommentController;

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

        $articleController = new ArticleController;
        $commentController = new CommentController;
        $userController = new UserController;
        $adminController = new AdminController;
        $contactController = new ContactController;
        $adminArticleController = new AdminArticleController;

        $params = explode("/", filter_var($_GET['p']), FILTER_SANITIZE_URL);
        
        if(isset($_GET['p'])){
            switch($params[0]){
                case "blog":
                    if(empty($params[1])){
                        $articleController->showBlog();
                    } elseif($params[1] === "article") {
                        $articleController->showArticle($params[2]);
                        if($params[3] === "add-comment"){
                            $commentController->addComment($params[2]);
                        }
                    }
                    break;
                case "account":
                    if((empty($params[1])) || ($params[1] === "login")){
                        $userController->login();
                    } elseif($params[1] === "register") {
                        $userController->register();
                    } elseif($params[1] === "logout") {
                        $userController->logout();
                    } elseif ($params[1] === "dashboard") {
                        $userController->showDashboard();
                    } elseif ($params[2] === "update-informations"){
                        $userController->updateUser($params[1]);
                    } elseif ($params[2] === "password-reset"){
                        $userController->resetPassword($params[1]);
                    }
                    break;
                case "admin":
                    if($adminController->getAdmin()){
                        // $UserController->logout();
                        if (empty($params[1]) || $params[1] === "dashboard") {
                            $adminController->showAdmin();
                        } elseif ($params[1] === "articles") {
                            if ($params[2] === "add") {
                                $adminArticleController->addArticle();
                            } elseif ($params[3] === "edit") {
                                $adminArticleController->editArticle($params[2]);
                            } elseif ($params[3] === "delete") {
                                $adminArticleController->deleteArticle($params[2]);
                            }
                        } elseif ($params[1] === "users") {
                            if ($params[3] === "manage") {
                                $adminController->manageUser($params[2]);
                            } elseif ($params[3] === "manage-role"){
                                $adminController->manageRole($params[2]);
                            } elseif ($params[3] === "delete"){
                                $userController->deleteUser($params[2]);
                            }
                        } elseif ($params[1] === "comments") {
                            if ($params[3] === "manage") {
                                $adminController->manageComment($params[2]);
                            }
                        }
                    } elseif (key_exists('user', $_SESSION) && !$adminController->getAdmin()){
                        echo "vous n'avez pas le droit d'accéder à cette page";
                    }else {
                        // $adminController->redirectToIndex();
                        $userController->redirectToLogin();
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