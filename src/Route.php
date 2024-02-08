<?php
namespace Gaucho;

use Gaucho\Gaucho;

class Route extends Gaucho{

    var $routes;

    function __construct($filename){
        if(file_exists($filename)){
            $mix=require $filename;
            if(is_array($mix)){
                $this->routes=$mix;
                $this->autoRun();
            }else{
                die('invalid '.$filename);
            }
        }else{
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
                $this->notFound();
            }
        }
        // se a rota existe encaminhar pro controller
        $this->controller($rotaAtual);
    }

    function controller($name){
        $filename=ROOT.'/app/Controller/'.$name;
        $filename.='Controller.php';
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

    function getMethod($raw=false){
        $method=@$_SERVER['REQUEST_METHOD'];
        if($raw){
            return $method;
        } elseif($method != 'POST'){
            $method='GET';
        }
        return $method;
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
}
