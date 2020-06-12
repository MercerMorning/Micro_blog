<?php
session_start();

use App\Controllers\AdminController;
use App\Controllers\FrontController;

include __DIR__ . "\..\config.php";
include __DIR__ . "\..\src\models\Base.php";
include __DIR__ . "\..\src\models\User.php";
include __DIR__ . "\..\src\models\Message.php";
include __DIR__ . "\..\src\controllers\BaseController.php";
include __DIR__ . "\..\src\controllers\FrontController.php";
include __DIR__ . "\..\src\controllers\AdminController.php";

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

if (strpos($_SERVER['REQUEST_URI'], '/user/message') !== false) {
    $controller = new \App\Controllers\FrontController();
    $controller->message();
    return 0;
}

if (strpos($_SERVER['REQUEST_URI'], '/admin/message') !== false) {
    $controller = new AdminController();
    $controller->message();
    return 0;
}

$controller = new FrontController();
$controller->index();