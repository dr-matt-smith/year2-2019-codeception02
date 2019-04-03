<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Tudublin\MainController;
use Tudublin\AdminController;
use Tudublin\LoginController;

$action = filter_input(INPUT_GET, 'action');
if(empty($action)){
    $action = filter_input(INPUT_POST, 'action');
}

$loginController = new LoginController();
$mainController = new MainController();
$adminController = new AdminController();
switch ($action){
    case 'adminHome':
        $adminController->adminHome();
        break;

    case 'processLogin':
        $loginController->processLogin();
        break;

    case 'login':
        $mainController->loginForm();
        break;

    default:
        $mainController->home();
}