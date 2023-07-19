<?php

namespace App\Controllers\Admin;

class LogoutController extends \myframework\Controller
{

    public function index(){
        $this->url->redirectTo('admin/login');
    }
}