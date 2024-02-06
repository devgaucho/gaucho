<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $Gaucho;
require __DIR__.'/../cfg.php';
$Gaucho->run(ROOT.'/routes.php');