<?php

namespace myframework;

class Session
{
    private Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function start()
    {
        ini_set('session.use_only_cookies',1);
        if(! session_id()){
            session_start();
        }
    }
    public function set($key,$value){
        $_SESSION[$key]=$value;
    }

    public function get($key){
        return  $_SESSION[$key] ?? null;
    }

    public function has($key){
        return isset($_SESSION[$key]);
    }

    public function gatAll()
    {
        return $_SESSION;
    }


    public function removeAll()
    {
        session_destroy();
        //unset($_SESSION);
    }

    public function remove($key){
        unset( $_SESSION[$key]);
    }

    public function pull($key){
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }


}