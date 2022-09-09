<?php

namespace App\Core;
use App\Controllers\MainController;
use App\Controllers\AccountController;
use App\Controllers\AdminController;
use App\Controllers\ContactController;
use App\Controllers\ArticleController;
use App\Controllers\AdminArticleController;

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
        $accountController = new AccountController;
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
                    }
                    break;
                case "account":
                    if((empty($params[1])) || ($params[1] === "login")){
                        $accountController->login();
                    } elseif($params[1] === "register") {
                        $accountController->register();
                    } elseif($params[1] === "logout") {
                        $accountController->logout();
                    } elseif ($params[1] === "dashboard") {
                        $accountController->showDashboard();
                        // if ($params[2] === "edit-informations"){
                        //     $accountController->editUser();
                        // }
                    }
                    break;
                case "admin":
                    if($adminController->getAdmin()){
                        // $accountController->logout();
                        if (empty($params[1]) || $params[1] === "dashboard") {
                            $adminController->showAdmin();
                        } elseif ($params[1] === "articles") {
                            if ($params[2] === "add") {
                                $adminArticleController->addArticle();
                            } elseif ($params[2] === "edit") {
                                $articleController->editArticle($params[3]);
                            } elseif ($params[2] === "delete") {
                                $articleController->deleteArticle();
                            }
                        } elseif ($params[1] === "users") {
                            if ($params[2] === "manage") {
                                $adminController->manageUser($params[3]);
                            } elseif ($params[2] === "delete"){
                                $accountController->deleteUser($params[3]);
                            }
                        } elseif ($params[1] === "comments") {
                            if ($params[2] === "manage") {
                                $adminController->manageComment();
                            }
                        }
                    } elseif (!$adminController->getAdmin()){
                        echo "vous n'avez pas le droit d'accéder à cette page";
                    }else {
                        // $adminController->redirectToIndex();
                        $accountController->login();
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