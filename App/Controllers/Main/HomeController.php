<?php

namespace App\Controllers\Main;

use App\Controllers\Main\Common\LayoutController;

class HomeController extends \myframework\Controller
{

    public function index(){
        $this->html->setTitle('Home');
        $params['posts'] = $this->model('Admin/Post')->getAll();
        $view = $this->view->createView('main/home',$params);

        return (new LayoutController($this->app))->render($view);
    }
}