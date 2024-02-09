<?php
namespace Gaucho;
use Gaucho\Controller;
class Route extends Controller{
	var $routes;
	function __construct($filename=''){
		if(file_exists($filename)){
			$mix=require $filename;
			if(is_array($mix)){
				$this->routes=$mix;
				$this->autoRun();
			}else{
				die('invalid '.$filename);
			}
		}elseif(!$this->isCli()){
			die($filename.' not found');
		}
	}
	function autoRun(){
		// identificar a rota
		$rota=$this->dir(1);
		// procurar no rotas.php
		$rotaAtual=@$this->routes[$rota];
		if(!$rotaAtual){
		// caso a rota não exista procurar dinamicas
			if(isset($this->routes['*'])){
				$rotaAtual=$this->routes['*'];
			}else{
				$this->fixServerBuiltIn();
			}
		}
		// se a rota existe encaminhar pro controller
		$this->controller($rotaAtual);
	}
	function controller($name){
		$name=$name.'Controller';
		$filename=ROOT.'/app/Controller/'.$name.'.php';
		if(file_exists($filename)){
			require_once $filename;
		}else{
			die("controller ".$filename.' notFound');
		}
		$nameWithNamespace='\App\Controller\\'.$name;
		if(!class_exists($nameWithNamespace)){
			die("class ".$nameWithNamespace.' not found');
		}
		$obj=new $nameWithNamespace();
		$method=$this->getMethod();
		if(method_exists($obj,$method)){
			return call_user_func_array([
				$obj,
				$method
			],[]);
		}else{
			die($name.'->'.$method.' not found');
		}
	}
	function fixServerBuiltIn(){
		$relativeUrl=implode('/',$this->dirs());
		$filename=ROOT.'/public/'.$relativeUrl;
		if(file_exists($filename)){
			$url=$_ENV['SITE_DOMAIN'];
			$url.='/'.$relativeUrl;
			$url.='?'.$_SERVER["QUERY_STRING"];
			$this->redirect($url);
		}
		$this->notFound();
	}
	function getMethod($raw=false){
		$method=@$_SERVER['REQUEST_METHOD'];
		if($raw){
			return $method;
		} elseif($method != 'POST'){
			$method='GET';
		}
		return $method;
	}
	function getRotasEViews(){
		$viewsList=glob(ROOT.'/view/*.html');
		if(count($viewsList) > 0){
			$rotas=[];
			foreach ($viewsList as $view){
				$filename=$view;
				$viewName=@explode(
					'.',basename($view)
				)[0];
				$str=file_get_contents($filename);
				$rotas[$viewName]=$str;
			}
			return $rotas;
		}else{
			die('views not found');
		}
	}
	function notFound(){
		http_response_code(404);
		if(isset($this->routes['404'])){
			$rotaAtual=$this->routes['404'];
			return $this->controller($rotaAtual);
		}else{
			die('not found');
		}
	}
	function salvarRotasEViews($filename,$rotasEViews){
		$data=json_encode($rotasEViews,JSON_PRETTY_PRINT);
		$data='var rotas='.$data.';'.PHP_EOL;
		$data.='var SITE_DOMAIN="'.$_ENV['SITE_DOMAIN'].'";';
		$data.=PHP_EOL;
		$data.='var SITE_NAME="'.$_ENV['SITE_NAME'].'";';
		$data.=PHP_EOL;
		$data.='var SITE_URL="'.$_ENV['SITE_URL'].'";';
		$data.=PHP_EOL;
		$data.='var SITE_VERSION="';
		$data.=$_ENV['SITE_VERSION'].'";'.PHP_EOL;
		if(file_put_contents($filename,$data)){
			$msg=$filename.' criado com sucesso!';
			$msg.=PHP_EOL;
			print $msg;
		}else{
			die("erro ao criar o ".$filename.PHP_EOL);
		}
	}
}
