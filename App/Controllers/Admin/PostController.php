<?php

namespace App\Controllers\Admin;

use myframework\Validator;

class PostController extends \myframework\Controller
{

    public function index($params=[]){
        $this->html->setTitle('Posts');
        $params['posts'] = $this->model('Admin/Post')->getLatestPosts();
         $view = $this->view->createView('admin/posts/list',$params);
        return $this->adminLayout->render($view);
    }

    public function add($params = []){

        $data['target'] = 'add-post-form';

        $data['action'] = url('/admin/posts/submit');

        $data['heading'] = 'Add New Post';

        $data['title'] = '';
        $data['details'] = '';
        $data['status'] = '';
        $data['category_id'] ='';
        $data['tags'] = '';
        $data['categories'] = $this->model('Admin/Category')->getCategories();

        $data['posts'] = [];
        $data['related_posts'] ='' ;
        $data['image'] = '';
        return $this->view->createView('admin/posts/form', $data);
    }

    public function submit(){

        $json = [];
        if(($errors=$this->isValidInputs())===true)
        {
            $this->model('Admin/Post')->add();
            $json['success'] = 'User Has Been Created Successfully';
            $json['redirectTo'] = url('/admin/posts');
        }else
        {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>',$errors);
        }

        return json_encode($json);
    }

    private function isValidInputs():array|bool
    {
        /**
         * @var $validator Validator
         */
        $validator = $this->validator;
        $validator->required('title')
            ->required('tags')
            ->select('category_id')
            ->requiredFile('image')
            ->image('image');
        return $validator->validate()?true:$validator->getErrors();
    }
}