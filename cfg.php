<?php

const ROOT = __DIR__;
require ROOT . '/vendor/autoload.php';

use Gaucho\Gaucho;

$Gaucho = new Gaucho();
if (! $Gaucho->isCli() and file_exists(ROOT . '/off')) {
    http_response_code(503);
    die("maintenance mode");
}