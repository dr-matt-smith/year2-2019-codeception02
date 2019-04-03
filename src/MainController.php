<?php

namespace Tudublin;


class MainController
{
    public function home()
    {
        require_once __DIR__ . '/../templates/home.php';
    }

    public function loginForm()
    {
        require_once __DIR__ . '/../templates/login.php';
    }

}