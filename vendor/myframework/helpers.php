<?php

if(!function_exists('pre')){
    function pre($var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

if(!function_exists('assets')){
    function assets($path){
        global $app;
       return $app->url->fullLink('/public/'.$path);
    }
}

if(!function_exists('url')){
function url($path){
    global $app;
    return $app->url->fullLink('index.php/'.trim($path,'/'));
}
}

if(!function_exists('route')){
    function route($name){
        global $app;
        $path = $app->route->get($name);
        return $app->url->fullLink('index.php/'.$path);
    }
}

if(!function_exists('randStr')){
    function randStr():string{
        return sha1(mt_rand(1,10000).time());
    }
}


if(!function_exists('seo')){
    function seo($str):string{

    }
}