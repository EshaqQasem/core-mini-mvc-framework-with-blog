<?php

namespace myframework;


class Application
{
    private static Application $instance;

    private array $appMainObjects = [];

    /**
     * @param File $appRoute
     */
    public function __construct(File $appRoute)
    {
        $this->register('root',$appRoute);
    }

    public function run()
    {
        $this->session->start();

            //echo $this->request->getUrl();
            $route = $this->route->getRoute();

            if(!is_null($route)){

            $output = $this->exec($route);
            $this->response->setOutput($output);
            $this->response->send();
        }else{
                $output = $this->view->createView('/404');
                $this->response->setOutput($output);
                $this->response->send();
                echo '<br> from app'.$this->request->getUrl();
            //$this->url->redirectTo($this->route->getNotFoundPage());
        }

    }

    private function exec($route)
    {
        if($route[0] instanceof \Closure)
            return call_user_func($route[0],$route[1]);

        $controller = $this->load->controller($route[0]);
        return call_user_func([$controller,$route[1]],$route[2]);
    }

    /*public static function getInstance()
    {
        if(static::$instance)
            static::$instance = new Application();

        return static::$instance;
    }*/

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function register($key,$value)
    {
        if($value instanceof \Closure){
            $value = call_user_func($value,$this);
        }
        $this->appMainObjects[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if(!$this->isRegistered($key)) {
            if ($this->isCoreClass($key)) {
                $this->register($key, $this->createCoreClassObject($key));
            } else {
                throw new \Exception("$key is not registered and not core class, you have to register it. ");
            }
        }
        return $this->appMainObjects[$key] ;
    }

    public function isRegistered($key):bool
    {
        return isset($this->appMainObjects[$key]);
    }

    /**
     * Get Registed value dynamically (as property)
     * @param $key
     * @return mixed|null
     * @throws \Exception
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    private function getCoreClasses():array
    {
        return [
            'route'      => 'myframework\\Route',
            'request'    => 'myframework\\Http\\Request',
            'response'   => 'myframework\\Http\\Response',
            'url'        => 'myframework\\URL',
            'load'       => 'myframework\\Loader',
            'session'    => 'myframework\\Session',
            'cookie'     => 'myframework\\Cookie',
            'html'       => 'myframework\\View\\Html',
            'db'         => 'myframework\\Data\\DataBase',
            'view'       => 'myframework\\View\\ViewFactory',
            'validator'  => 'myframework\\Validator',
        ];
    }

    private function createCoreClassObject(string $key)
    {
        $classes = $this->getCoreClasses();
        $object = $classes[$key];
        return new $object($this);
    }

    private function isCoreClass(string $key)
    {
        return isset($this->getCoreClasses()[$key]);
    }




}