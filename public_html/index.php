<?php
session_start();

use App\Controllers\MessageAdminController;
use App\Controllers\FrontController;

include __DIR__ . "\..\config.php";
include __DIR__ . "\..\src\models\Base.php";
include __DIR__ . "\..\src\models\User.php";
include __DIR__ . "\..\src\models\Message.php";
include __DIR__ . "\..\src\models\Auth.php";
include __DIR__ . "\..\src\models\Image.php";
include __DIR__ . "\..\src\controllers\BaseController.php";
include __DIR__ . "\..\src\controllers\MessageController.php";
include __DIR__ . "\..\src\controllers\FrontController.php";
include __DIR__ . "\..\src\controllers\MessageAdminController.php";

if (strpos($_SERVER['REQUEST_URI'], '/user/register') !== false) {
    $controller = new \App\Controllers\FrontController();
    $controller->register();
    return 0;
}

if (strpos($_SERVER['REQUEST_URI'], '/user/login') !== false) {
    $controller = new \App\Controllers\FrontController();
    $controller->login();
    return 0;
}

if (strpos($_SERVER['REQUEST_URI'], '/message/indexAdmin') !== false) {
    $controller = new MessageAdminController();
    $controller->index();
    return 0;
}

if (strpos($_SERVER['REQUEST_URI'], '/message/index') !== false) {
    $controller = new \App\Controllers\MessageController();
    $controller->index();
    return 0;
}

$controller = new FrontController();
$controller->index();