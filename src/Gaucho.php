<?php

namespace Gaucho;

use Gaucho\Env;
use Gaucho\Route;

class Gaucho
{
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
            $uri=$this->getNormalUri();
            $dirs=explode('/',$uri);
            $dirs=array_filter($dirs);
            if(empty($dirs)){
                return ['1'=>'/'];
            }
            return $dirs;
        }
    }
    function getNormalUri(){
        $scheme=$_SERVER['REQUEST_SCHEME'];
        $host=$_SERVER['HTTP_HOST'];
        $uri=$_SERVER["REQUEST_URI"];
        $uri=explode('?',$uri)[0];
        $full=$scheme.'://'.$host.$uri;
        $env=@$_ENV['SITE_URL'];
        if($env){
            $uri=explode($env,$full)[1];
            if(empty($uri)){
                return '/';
            }else{
                return $uri;
            }
        }else{
            return $uri;
        }
    }
    function isCli(){
        if(php_sapi_name()=="cli"){
            return true;
        }else{
            return false;
        }
    }
    function run()
    {
        new Env(ROOT.'/.env');
        ini_set("memory_limit", $_ENV['SITE_MEMORY']);
        $this->showErrors($_ENV['SITE_ERRORS']);
        new Route(ROOT.'/routes.php');
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