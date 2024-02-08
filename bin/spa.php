<?php
global $Gaucho;
require __DIR__.'/../cfg.php';
use Gaucho\Route;
$Gaucho->run();
$Route=new Route(ROOT.'/routes.php');
$rotasEView=$Route->getRotasEViews();
$filename=ROOT.'/js/inc/rotas.js';
if(file_exists($filename)){
    unlink($filename);
}
$Route->salvarRotasEViews($filename,$rotasEView);