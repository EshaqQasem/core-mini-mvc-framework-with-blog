<?php

namespace myframework\View;

use myframework\Application;

class ViewFactory
{

    protected Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function createView($viewPath ,$passedParamsToView=[]){
        return new View($this->app->root,$viewPath,$passedParamsToView);
    }
}