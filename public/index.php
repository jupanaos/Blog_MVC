<?php
use App\core\Application;
use App\Controllers\MainController;
use App\Models\ArticleModel;

define('ROOT', dirname(__DIR__));
define('VIEWS_DIR', realpath(dirname(__DIR__)) . '/Views');

require_once ROOT.'/vendor/autoload.php'; //import autoload


//app
$app = new Application();

//router

// $app->router->get('/', [MainController::class, 'index']);
// $app->router->get('/contact', 'contact');
// $app->router->post('/contact', [MainController::class, 'postContact'] );

// $model = new ArticleModel;
// var_dump($model->findAll());

//handles all
$app->run();