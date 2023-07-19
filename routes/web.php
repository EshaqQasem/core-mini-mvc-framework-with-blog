<?php

//$app = new \myframework\Application();

// admin
$app->route->add('','Main/Home','GET');
$app->route->add('/','Main/Home','GET');
$app->route->add('/home','Main/Home','GET');
$app->route->add('/register','Main/Register','GET');
$app->route->add('/register/submit','MainRegister@submit','POST');

//share
$app->register('adminLayout',new  App\Controllers\Admin\Common\LayoutController($app));

$app->route->add('/404',function (){
    global $app;
    return $app->view->createView('/404');
});