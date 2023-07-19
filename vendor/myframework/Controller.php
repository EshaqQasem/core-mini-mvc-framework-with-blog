<?php

namespace myframework;

abstract class Controller
{

    protected Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    protected function model($model):Model{
        return $this->app->load->model($model);
    }

    public function __get($key){
        return $this->app->get($key);
    }

}