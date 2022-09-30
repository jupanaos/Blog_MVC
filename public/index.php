<?php
use App\core\Application;

define('ROOT', dirname(__DIR__));
define('VIEWS_DIR', realpath(dirname(__DIR__)) . '/Views');
define('CONTROLLERS_DIR', realpath(dirname(__DIR__)) . '/src/Controllers');

require_once (ROOT.'/vendor/autoload.php');

session_start();

$app = new Application();

$app->run();
