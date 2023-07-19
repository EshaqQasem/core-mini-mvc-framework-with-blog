<?php

namespace App\Controllers\Main\Common;

class FooterController extends \myframework\Controller
{

    public function index(){
        return $this->view->createView('main/common/footer');
    }
}