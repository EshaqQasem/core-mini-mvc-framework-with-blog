<?php

namespace myframework\Http;
use myframework\Application;
class Request{

    private Application $app;

    protected string $url="";

    protected string $baseURL="";
    /**
     * @param Application $app
     */
    public function __construct(Application $app){
        $this->app = $app;
    }

    public function server($key){
        return $_SERVER[$key] ?? null;
    }

    public function referer()
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }

    public function request($key){
        if(isset($_REQUEST[$key]))
            return trim($_REQUEST[$key]);
        return  null;
    }

    public function get($key){
        return $_GET[$key] ?? null;
    }

    public function post($key){
        if(isset($_POST[$key]))
            return trim($_POST[$key]);
        return  null;
    }
    
    public function hasFile($key):bool{
        if(array_key_exists($key,$_FILES) and $_FILES[$key]['error'] == 0){
            return true;
        }
        return false;
    }

    public function file($key):File|null{
        if(array_key_exists($key,$_FILES
        )){
            return new File($key,$_FILES[$key]);
        }
        return null;
    }
    public function method(){

    }

    public function getURL(){
        if( empty($this->url) ){
            $this->prepareUrl();
        }
        return $this->url;
    }

    public function prepareUrl()
    {
        $scriptName = ($this->server('SCRIPT_NAME'));
        $reqestUri = $this->server('REQUEST_URI');

        if(strpos($reqestUri ,'?') !==false)
        {
            list($reqestUri,$queryString) = explode('?',$reqestUri);
        }

        $reqestUri = preg_replace('#^'.$scriptName.'#','',$reqestUri );
        $this->url = $_SERVER['PATH_INFO']??$reqestUri;
        //$this->url = rtrim($this->url,'/');
        $this->baseURL =  $this->server('REQUEST_SCHEME').'://'.$this->server('HTTP_HOST').'/'
            .dirname($scriptName).'/';
    }

    public function baseURL(){
        if(empty($this->baseURL))
            $this->prepareUrl();

        return $this->baseURL;
    }


}