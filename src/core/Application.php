<?php

namespace App\Core;
use App\Controllers\MainController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\ContactController;
use App\Controllers\ArticleController;
use App\Controllers\AdminArticleController;
use App\Controllers\CommentController;
use App\Controllers\ErrorController;
use App\Controllers\AdminCommentController;
use App\Controllers\AdminUserController;

class Application
{
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Check if URI is not empty and ends with a /
        if(!empty($uri) && $uri != '/' && $uri[-1] === "/"){
            $uri = substr($uri, 0, -1);

            // Redirect to URL with no /
            http_response_code(301);
            header('Location: '.$uri);
        }

        $controller = new MainController;
        $articleController = new ArticleController;
        $commentController = new CommentController;
        $userController = new UserController;
        $adminController = new AdminController;
        $contactController = new ContactController;
        $adminArticleController = new AdminArticleController;
        $adminCommentController = new AdminCommentController;
        $adminUserController = new AdminUserController;
        $errorController = new ErrorController;

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
                                $adminUserController->manageUser($params[2]);
                            } elseif ($params[3] === "delete"){
                                $userController->deleteUser($params[2]);
                            }
                        } elseif ($params[1] === "comments") {
                            if ($params[3] === "manage") {
                                $adminCommentController->manageComment($params[2]);
                            }
                        }
                    } elseif (key_exists('user', $_SESSION)) {
                        $errorController->showError();
                    } else {
                        $userController->redirect->redirectToLogin();
                    }
                    break;
                case "contact":
                    $contactController->contact();
                    break;
                default:
                $errorController->showNotFound();
            }
        } else {
            $controller->index();
        }
    }
}