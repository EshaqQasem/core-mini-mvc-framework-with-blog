<?php

namespace App\Controllers\Admin;

use myframework\Validator;

class UserController extends \myframework\Controller
{



    public function index()
    {
        $this->html->setTitle('Users');
        $users = $this->model('Admin/User')->getAll();

        $view = $this->view->createView('admin/users/list',['users'=>$users]);
        return $this->adminLayout->render($view);


    }

    public function add($params = []){

        $data['target'] = 'add-user-form';

        $data['action'] = url('/admin/users/submit');

        $data['heading'] = 'Add New User';

        $data['first_name'] = '';
        $data['last_name'] = '';
        $data['status'] = '';
        $data['users_group_id'] ='';
        $data['email'] = '';
        $data['gender'] = '';

        $data['birthday'] = '';
        $data['image'] = '';
         $data['users_groups'] = $this->model('Admin/UserGroup')->getAll();
        return $this->view->createView('admin/users/form', $data);
    }

    public function submit($params=[]){
        $errors = $this->isValidInput();
        if(empty($errors)){
            $this->model('Admin/User')->add();
            $json['success'] = 'User Has Been Created Successfully';

            $json['redirectTo'] = url('/admin/users');
        } else {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>',$errors);
        }

        return json_encode($json);

    }

    private function form($user = null)
    {
        if ($user) {
            // editing form
            $data['target'] = 'edit-user-' . $user->id;

            $data['action'] = url('/admin/users/save/' . $user->id);

            $data['heading'] = 'Edit ' . $user->first_name . ' ' . $user->last_name;
        } else {
            // adding form
            $data['target'] = 'add-user-form';

            $data['action'] = url('/admin/users/submit');

            $data['heading'] = 'Add New User';
        }

        $user = (array) $user;

        $data['first_name'] = $user['first_name']??null;
        $data['last_name'] = $user['last_name']??null;
        $data['status'] = $user['status']??null;
        $data['users_group_id'] = $user['users_group_id']??null;
        $data['email'] = $user['email']??null;
        $data['gender'] = $user['gender']??null;

        $data['birthday'] = '';
        $data['image'] = '';

        if (! empty($user['birthday'])) {
            $data['birthday'] = date('d-m-Y', $user['birthday']);
        }

        if (! empty($user['image'])) {
            // default path to upload user image : public/images
            $data['image'] = $this->url->link('public/images/' . $user['image']);
        }

        $data['users_groups'] = $this->load->model('UsersGroups')->all();

        return $this->view->render('admin/users/form', $data);
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
            ->required('birthday')
            ->email('email')
            ->match('password','confirm_password')
            ->select('users_group_id')
            ->image('image')
            ->unique('email',['user','email']);
        return $this->validator->getErrors();
    }

}