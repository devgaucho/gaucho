<?php
namespace Gaucho;
use Gaucho\Chaplin;
class Controller{
	function chaplin($name,$data=[],$print=true){
		$Chaplin=new Chaplin();
		$filename=ROOT.'/view/'.$name.'.html';
		$data['SITE_DOMAIN']=$_ENV['SITE_DOMAIN'];
		$data['SITE_NAME']=$_ENV['SITE_NAME'];
		$data['SITE_URL']=$_ENV['SITE_URL'];
		$data['SITE_VERSION']=$_ENV['SITE_VERSION'];
		$rendered=$Chaplin->renderFromFile($filename,$data);
		if($print){
			if($this->isAjax()){
				$this->json($data);
			}else{
				return print $rendered;
			}
		}else{
			return $rendered;
		}
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
		if($this->isCli()){
			return false;
		}else{
			$uri=$this->getNormalUri();
			$dirs=explode('/',$uri);
			$dirs=array_filter($dirs);
			if(empty($dirs)){
				return [
					'1'=>'/'
				];
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
			$uri=@explode($env,$full)[1];
			if(empty($uri)){
				return '/';
			}else{
				return $uri;
			}
		}else{
			return $uri;
		}
	}
	function isAjax(){
		if(
			!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
		){
			$str=strtolower(
				$_SERVER['HTTP_X_REQUESTED_WITH']
			);
			if($str=='xmlhttprequest'){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function isCli(){
		if(php_sapi_name()=="cli"){
			return true;
		}else{
			return false;
		}
	}
	function json($mix){
		header('Content-Type:application/json');
		die(json_encode($mix,JSON_PRETTY_PRINT));
	}
	function redirect($url){
		header('Location: '.$url);
		die();
	}
}