<?php

namespace App\Controller;

use Gaucho\Gaucho;
class Home extends Gaucho
{
    function read(){
        print '<pre>';
        print $_ENV['SITE_NAME'];
    }
}