<?php

namespace App\Controllers\Main\Common;

class SidebarController extends \myframework\Controller
{

    public function index(){
        $params['categories'] = $this->model('Admin/Category')->getCategories();
        $params['ads'] = [];
        return $this->view->createView('main/common/sidebar',$params);
    }
}