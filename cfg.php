<?php
const ROOT = __DIR__;
require ROOT.'/vendor/autoload.php';

use App\Controller\Home;

$Home=new Home();
$Home->showErrors(true);
$Home->read();