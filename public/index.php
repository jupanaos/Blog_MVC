<?php
use App\core\Application;

define('ROOT', dirname(__DIR__));
define('VIEWS_DIR', realpath(dirname(__DIR__)) . '/Views');
define('CONTROLLERS_DIR', realpath(dirname(__DIR__)) . '/src/Controllers');

// Import autoload
require_once ROOT.'/vendor/autoload.php';
session_start();

// New Application instance (router)
$app = new Application();

// Run application
$app->run();
