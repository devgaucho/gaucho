<?php
namespace App\Controller;
use Gaucho\Controller;
class AboutController extends Controller{
    function GET(){
        $data=[
            'title'=>'Sobre'
        ];
        $this->chaplin('inc/header',$data);
        $this->chaplin('about',$data);
        $this->chaplin('inc/footer',$data);
    }
}