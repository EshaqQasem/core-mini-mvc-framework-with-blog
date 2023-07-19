<?php

namespace myframework;
class AccessController extends \myframework\Controller
{

    protected  $user;

    public function index($urlPatern)
    {
        $loginController = $this->load->controller('Admin/Login');
        $this->user = $loginController->isLogged();
        if (!$this->user) {
            $this->url->redirectTo('/login');
        }

        if (!$this->hasAccess($urlPatern)) {
            $this->url->redirectTo('/home');
        }
    }

    private function hasAccess($route)
    {
        return $this->model('Admin/User')
            ->hasAccess($this->user->id, $route);
    }
}