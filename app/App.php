<?php

namespace app;

class App
{
    function chaplin($name,$data=[],$print=true){
        print $name;
    }
    function dir($segment=null){
        // 1) pega os dados do header
        $host=$_SERVER['HTTP_HOST'];
        $uri=$_SERVER["REQUEST_URI"];
        // 2) pega os diretórios
        $uri=explode('?',$uri)[0];
        // 3) transforma os diretórios em array
        if($uri=='/'){
            $arr[1]='/';
        }else{
            $arr=explode('/',$uri);
            $arr=array_filter($arr);
            $arr=array_values($arr);
        }
        // 4) remove o primeiro diretório no localhost
        if($host=='localhost'){
            unset($arr[0]);
        }
        // remove o public
        if($host=='localhost' and @$arr[1]=='public'){
            unset($arr[1]);
        }
        if(count($arr)=='0'){
            $arr[]='/';
        }
        // 5) normaliza o array de saída
        $i=1;
        $out=null;
        foreach ($arr as $key => $value) {
            $out[$i]=$value;
            $i++;
        }
        $arr=$out;
        // 6) retorna o array ou o diretório específicado
        if(is_null($segment)){
            return $arr;
        }elseif(isset($arr[$segment])){
            return $arr[$segment];
        }else{
            return false;
        }
    }
    function dirs(){
        return $this->dir();
    }
}