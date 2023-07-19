<?php

namespace myframework;

class Cookie
{
    private Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function set($key ,$value ,$time=24*30){
        setcookie($key,$value,time()+$time*60*60,'/');
    }

    public function get($key){
        return $_COOKIE[$key] ?? null;
    }

    public function exsist($key){
        return array_key_exists($key,$_COOKIE);
    }

    public function remove($key){
        setcookie($key,null,-1,'/');
        unset($_COOKIE[$key]);
    }

    public function removeAll(){
        foreach (array_keys($_COOKIE) as $key){
            $this->remove($key);
        }
        //unset($_COOKIE);
    }

}