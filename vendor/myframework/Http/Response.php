<?php

namespace myframework\Http;

use myframework\Application;

class Response
{

    private Application $app;

    protected $headers = [];

    protected $content = "";
    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function setHeader($key,$value){
        $this->headers[$key] = $value;
    }

    public function setOutput($output){
        $this->content = $output;
    }

    public function sendHeaders(){
        foreach ($this->headers as $key => $value){
            header( $key . ':' . $value);
        }
    }

    public function sendOutput(){
        echo $this->content;
    }

    public function send(){
        $this->sendHeaders();
        $this->sendOutput();
    }

}