<?php

namespace myframework;

class URL
{

    protected Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function fullLink($path){
        return $this->app->request->baseUrl($path).trim($path,'/'); ;
    }

    public function redirectTo($path){
        header('location:'.$this->fullLink('index.php'.$path));
        exit;
    }
}
