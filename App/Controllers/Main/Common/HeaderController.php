<?php

namespace App\Controllers\Main\Common;

class HeaderController extends \myframework\Controller
{

    public function index(){
        $params['title']=$this->html->getTitle();
        $params['user'] = $this->load->controller('Admin/Login')->isLogged();
        $params['categories'] = $this->model('Admin/Category')->getCategories();

        return $this->view->createView('main/common/header',$params);
    }
}