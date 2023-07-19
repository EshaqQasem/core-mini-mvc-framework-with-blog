<?php

namespace App\Controllers\Admin\Common;

class FooterController extends \myframework\Controller
{

    public function index(){
        return $this->view->createView('admin/common/footer');
    }
}