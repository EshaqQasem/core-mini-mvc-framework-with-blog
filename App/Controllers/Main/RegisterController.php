<?php

namespace App\Controllers\Main;

use App\Controllers\Main\Common\LayoutController;
use myframework\Validator;
use mysql_xdevapi\CollectionFind;

class RegisterController extends \myframework\Controller
{

    public function  index($params=[]){
        $this->html->setTitle('Sign Up');

        $params['header'] = $this->load->controller('Main/Common/Header')->index();
        $params['footer'] = $this->load->controller('Main/Common/Footer')->index();
        return $this->view->createView('main/register',$params);
    }

    public function submit($params=[]){
        $errors = $this->isValidInput();
        if(empty($errors)){
            $this->model('Main/Register')->add();
            $this->url->redirectTo('/login');
            $json['success'] = 'User Has Been Created Successfully';

            $json['redirectTo'] = url('/');
        } else {
            // it means there are errors in form validation
            $params['errors'] = implode('<br>',$errors);
        }

        return $this->index($params);

    }

    private function isValidInput()
    {
        /**
         * @var $validator Validator
         */
        $validator=$this->validator;
        $validator->required('first_name')
            ->required('first_name')
            ->required('last_name')
            ->required('email')
            ->required('password')
            ->requiredFile('image')

            ->email('email')
            ->match('password','confirm_password')

            ->image('image')
            ->unique('email',['user','email']);
        return $validator->getErrors();
    }
}