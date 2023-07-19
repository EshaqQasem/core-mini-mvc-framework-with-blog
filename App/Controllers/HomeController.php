<?php

namespace App\Controllers;

use myframework\Controller;

class HomeController extends Controller
{

    public function index($params = []){
//        $mod = $this->model('Category');
//        $cats =  $mod->getAll();
//        $cats = ['cats'=>$cats,'gets'=>$params];
        return $this->app->view->createView('home');
    }
}