<?php
const ROOT = __DIR__;
require ROOT.'/vendor/autoload.php';
use app\controller\Home;
$Home=new Home();
$Home->read();