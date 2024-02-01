<?php

namespace app\controller;

use app\App;

class Home extends App
{
    function read(){
        print '<pre>';
        var_dump($this->dirs());
    }
}