<?php
global $Gaucho;
require __DIR__.'/../cfg.php';
$Gaucho->run();
$rotasEView=$Gaucho->getRotasEViews();
$filename=ROOT.'/js/inc/rotas.js';
if(file_exists($filename)){
    unlink($filename);
}
$Gaucho->salvarRotasEViews($filename,$rotasEView);