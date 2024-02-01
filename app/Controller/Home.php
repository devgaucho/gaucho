<?php

namespace App\Controller;

use Gaucho\Gaucho;
class Home extends Gaucho
{
    function GET(){
        $data=[
          'name'=>'world'
        ];
        $this->chaplin('home',$data);
    }
}