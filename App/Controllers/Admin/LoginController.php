<?php

namespace App\Controllers\Admin;

use App\Models\LoginModel;
use myframework\View\View;

class LoginController extends \myframework\Controller
{
    /**
     * display login form
     * @param $params
     * @return View
     */

    public $user;
    public function index($params =[])
    {
        $this->user = $this->isLogged();
//        var_dump($this->user);
//        die();
        if($this->user)
        {
            $this->app->url->redirectTo('/');
        }
        return $this->app->view->createView('admin/login',$params);
    }

    public function submit()
    {

        $errors = $this->isValidLoginInput();
        if(empty($errors))
        {
            $loginUser = $this->isValidLoginData();
            if($loginUser !== false)
            {
                $code = $loginUser->code;
                if ($this->isRememberLogin()) {
                    $this->app->cookie->set('login',$code);
                }
                    $this->app->session->set('login',$code);

                 $url = '/';
                 $this->app->url->redirectTo($url);
            }
            else{
                $errors []  = 'Invaled Login Data';
            }
        }

        return $this->index(['errors'=>$errors]);
    }

    public function logout(){
        $this->cookie->remove('login');
        $this->session->remove('login');

        $this->url->redirectTo('/login');

    }

    public function isValidLoginInput():array{
        $email = $this->app->request->post('email');
        $password = $this->app->request->post('password');
        $errors = array();
        if(!$email){
            $errors [] = 'Please Input Email';
        }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors [] = 'Please Input valid Email';
        }
        if(!$password){
            $errors [] = 'Please Input Password';
        }

        return ($errors);
    }

    protected function isValidLoginData()
    {
        $email = $this->app->request->post('email');
        $password = $this->app->request->post('password');

        /**
         * @psalm-var $loginModel LoginModel
         */
        $loginModel = $this->app->load->model('Admin\\Login');
        return $loginModel->isValidLogin($email, $password);
    }

    private function isRememberLogin():bool
    {
        return  !is_null($this->app->request->post('remember'));
    }

    public function isLogged()
    {

        $code = $this->app->cookie->get('login') ?? $this->app->session->get('login');
        if(!$code)
           return false;

        $this->user = $this->load->model('Admin\\Login')->isCorrectLoginCode($code);
        return  $this->user;
    }


}