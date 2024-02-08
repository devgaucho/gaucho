<?php
namespace Gaucho;
use Gaucho\Env;
use Gaucho\Route;
class Gaucho{
	function run($routes=false){
		new Env(ROOT.'/.env');
		ini_set("memory_limit",$_ENV['SITE_MEMORY']);
		$this->showErrors($_ENV['SITE_ERRORS']);
		if($routes){
			new Route($routes);
		}
	}
	function showErrors($bool){
		if($bool){
			ini_set('display_errors',1);
			ini_set('display_startup_errors',1);
			error_reporting(E_ALL);
		}else{
			ini_set('display_errors',0);
			ini_set('display_startup_errors',0);
			error_reporting(0);
		}
	}
}
