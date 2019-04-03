<?php
namespace Tudublin;


class LoginController
{
    public function processLogin()
    {
        $username = filter_input(INPUT_POST, 'username');

        if('admin' == $username){
            $adminController = new AdminController();
            $adminController->adminHome();
        } else {
            require_once __DIR__ . '/../templates/error.php';
        }
    }

    private function isValid($username)
    {
        if('admin' == $username)
            return true;

        return false;
    }

}