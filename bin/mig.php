<?php
global $Gaucho;
require __DIR__.'/../cfg.php';
use Gaucho\DB;
$Gaucho->run();
$DB=new DB();
$DB->mig($_ENV['DB_ID']);