<?php

require_once 'vendor/autoload.php';
require  'vendor/myframework/helpers.php';

use myframework\Application;
use myframework\Data\DataBase;
use myframework\File;


$root = new File(__DIR__);
$app = new Application($root);

require_once 'routes/web.php';
require_once 'routes/admin.php';

$app->run();
//$ret = $app->db->where('id = ?',[6])->fetch('category');

//var_dump($ret);
?>
