<?php
global $Gaucho;
require __DIR__.'/../cfg.php';
$Gaucho->run();
$Gaucho->mig($_ENV['DB_ID']);