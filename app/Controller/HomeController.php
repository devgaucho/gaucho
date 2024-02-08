<?php
namespace App\Controller;
use Gaucho\Controller;
class HomeController extends Controller{
    function GET(){
        $data=[
            'name'=>'world',
            'title'=>$_ENV['SITE_NAME']
        ];
        $this->chaplin('inc/header',$data);
        $this->chaplin('home',$data);
        $this->chaplin('inc/footer',$data);
    }
}