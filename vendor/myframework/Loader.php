<?php

namespace myframework;

class Loader
{

    protected Application $app;

    /**
     * @var Controller[]
     */
    protected array $controllers = [];

    /**
     * @var Model[]
     */
    protected array $models = [];
    /**
     * @param Application $app
     */

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function controller($controller){
        $controller = str_replace('/','\\',$controller);
        $controller = ("App\\Controllers\\". $controller . "Controller");
        if(!array_key_exists($controller,$this->controllers)){
            $this->controllers[$controller] = new $controller($this->app);
        }
        return $this->controllers[$controller];
    }

    public function model($model){
        $model = str_replace('/','\\',$model);
        $model = ("App\\Models\\".$model."Model");
        if(!array_key_exists($model,$this->models)){
            $this->models[$model] = new $model($this->app);
        }
        return $this->models[$model];
    }
}