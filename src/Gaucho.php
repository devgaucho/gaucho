<?php

namespace Gaucho;

use Gaucho\Env;
use Gaucho\Route;

class Gaucho
{
    var $run;
    function __construct()
    {
        if(!isset($this->run)){
            $this->run=true;
            new Env(ROOT.'/.env');
            ini_set("memory_limit", $_ENV['SITE_MEMORY']);
            $this->showErrors($_ENV['SITE_ERRORS']);
            new Route(ROOT.'/routes.php');
        }
    }

    function chaplin($name,$data=[],$print=true){
        print $name;
    }
    function dir($dir){
        $dirs=$this->dirs();
        if(isset($dirs[$dir])){
            return $dirs[$dir];
        }else{
            return false;
        }
    }
    function dirs(){
        if($this->isCli()) {
            return false;
        }else{
            $uri=$_SERVER["REQUEST_URI"];
            $uri=explode('?',$uri)[0];
            $dirs=explode('/',$uri);
            return $dirs;
        }
    }
    function isCli(){
        if(php_sapi_name()=="cli"){
            return true;
        }else{
            return false;
        }
    }
    function showErrors($bool){
        if($bool){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }else{
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    }
}