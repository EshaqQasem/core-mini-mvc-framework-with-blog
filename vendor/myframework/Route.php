<?php

namespace myframework;



class Route
{
    protected Application $app;

    public $routes = [];

    protected $notFoundPage;

    /**
     * @return mixed
     */
    public function getNotFoundPage()
    {
        return $this->notFoundPage;
    }

    /**
     * @param mixed $notFoundPage
     */
    public function setNotFoundPage($notFoundPage): void
    {
        $this->notFoundPage = $notFoundPage;
    }
    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function add($url ,$action ,$requestMethod = 'GET'){
        $route  = [
            'url' => $url,
            'pattern' => $this->generatePattern($url),
            'action'  =>$this->prepAction($action),
            'method'  =>$requestMethod
        ];

        $this->routes [] = $route;
        return $this;
    }

    public function name($name){
        $route = array_pop($this->routes);
        $this->routes[$name] = $route;
    }

    public function get($name){
        $route = $this->routes[$name] ?? null;
        if($route)
            return $route['url'];
        return 'roungUrl';
    }

    private function prepAction($action)
    {
        if($action instanceof \Closure)
            return $action;

        $action = str_replace('/','\\',$action);
        return str_contains($action, '@') ? $action:$action.'@index';
    }

    private function generatePattern($url)
    {
        $pattern  = '#^';
        $textRegx = '([a-zA-Z0-9-]+)';
        $idRegx = '(\d+)';
        $pattern.= str_replace([':text',':id'],[$textRegx,$idRegx],$url);
        return $pattern.'$#';
    }

    private function isMatches($pattern)
    {
        return preg_match($pattern,$this->app->request->getUrl());
    }

    public function getRoute(): ?array
    {
        foreach ($this->routes as $route){
            if($this->isMatches($route['pattern']) ){
                if(str_starts_with($this->app->request->getURL(), '/admin')) {
//die($this->app->request->getURL());
                    $access = new \myframework\AccessController($this->app);
                    $access->index($route['url']);
                }
                $args = $this->getArgumentOf($route['pattern']);
                if($route['action'] instanceof \Closure)
                    return  [$route['action']  ,$args];
                list($controller,$method) = explode('@',$route['action']);
                return [$controller , $method ,$args];
            }
        }
        return null;
    }

    private function getArgumentOf(mixed $pattern)
    {
        preg_match($pattern,$this->app->request->getUrl(),$args);
        array_shift($args);
        return $args;
    }

    public function getAdminPages(){
        $pages = [];
        foreach ($this->routes as $route){
            if(strpos($route['url'] ,'/admin' )=== 0){
                $pages [] = $route['url'];
            }
        }
        return $pages;
    }
}