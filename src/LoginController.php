<?php

namespace Tudublin;


class LoginController
{
    public function processLogin()
    {
        $username = filter_input(INPUT_POST, 'username');

        if('admin' == $username){
            print 'admin home page';
        } else {
            print 'error';
        }
    }

}