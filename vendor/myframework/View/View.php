<?php

namespace myframework\View;

use myframework\Application;
use myframework\File;

class View implements IView
{

    protected $data = [];

    protected $viewPath;

    protected $output;

    protected File $appRoot;

    /**
     * @param array $data
     * @param $viewPath
     * @param File $appRoot
     */
    public function __construct( File $appRoot , $viewPath,$data)
    {
        $this->data = $data;
        $this->appRoot = $appRoot;
        $this->viewPath = $this->fullViewPath($viewPath);
        if(! file_exists($this->viewPath))
        {
           throw new \Exception($viewPath . ' View is not Exsist');
        }
    }


    public function getOutput(): string
    {
        if(is_null($this->output)) {
            ob_start();

            extract($this->data);

            require $this->viewPath;


            $this->output = ob_get_clean();
        }

        return $this->output;
    }

    public function __toString(): string
    {
        return $this->getOutput();
    }

    public function fullViewPath($viewPath){
        return $this->appRoot->concat('App/Views/'.$viewPath.'.php');
    }
}