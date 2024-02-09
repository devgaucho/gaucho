<?php
const ROOT = __DIR__;
require ROOT . '/vendor/autoload.php';
use Gaucho\Controller;
use Gaucho\Gaucho;
$Controller=new Controller();
$Gaucho=new Gaucho();
if (!$Controller->isCli() and file_exists(ROOT . '/off')){
    http_response_code(503);
    die("maintenance mode");
}