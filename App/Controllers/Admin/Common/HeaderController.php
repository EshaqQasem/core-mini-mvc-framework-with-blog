<?php

namespace App\Controllers\Admin\Common;

class HeaderController extends \myframework\Controller
{

    public function index(){
        $params['title']=$this->html->getTitle();
        $params['user'] = $this->load->controller('Admin/Login')->isLogged();

        return $this->view->createView('admin/common/header',$params);
    }
}