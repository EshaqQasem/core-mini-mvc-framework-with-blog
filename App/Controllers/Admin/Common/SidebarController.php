<?php

namespace App\Controllers\Admin\Common;

class SidebarController extends \myframework\Controller
{

    public function index(){
        return $this->view->createView('admin/common/sidebar');
    }
}