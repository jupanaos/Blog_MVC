<?php

define('ROOT', dirname(__DIR__));

require_once ROOT.'/vendor/autoload.php'; //import autoload
use App\core\Application;

//app
$app = new Application();

//router
$app->router->get('/', function()
{
    return 'Hello there';
});

$app->router->get('/contact', function()
{
    return 'contact us';
});

//handles all
$app->run();