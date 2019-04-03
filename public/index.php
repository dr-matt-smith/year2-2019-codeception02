<?php
require_once __DIR__ . '/../vendor/autoload.php';

$action = filter_input(INPUT_GET, 'action');
if(empty($action)){
    $action = filter_input(INPUT_POST, 'action');
}

$loiginController = new \Tudublin\LoginController();
switch ($action){
    case 'processLogin':
        $loiginController->processLogin();
        break;

    case 'login':
        require_once __DIR__ . '/../templates/login.php';
        break;

    default:
        require_once __DIR__ . '/../templates/home.php';
}