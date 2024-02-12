<?php
namespace Gaucho;
use Medoo\Medoo;
use Gaucho\Mig;
use mysqli;
class DB{
	function createSQLiteDB($id){
		$prf='DB'.$id;
		$filename=$_ENV[$prf.'_DATABASE'];
		if(!file_exists($filename)){
			$dir=ROOT.'/db';
			// cria o diretório caso ele não exista
			if(!file_exists($dir)){
				if(mkdir($dir)){
					chmod($dir,0777);
					$msg='dir db criado com ';
					$msg.='sucesso';
					print $msg.PHP_EOL;
				}else{
					$msg='erro ao criar o ';
					$msg.='dir db';
					die($msg.PHP_EOL);
				}
			}
			// cria o banco caso ele não exista
			system('touch '.$filename);
			chmod($filename,0777);
			if(file_exists($filename)){
				$msg='db "'.$filename;
				$msg.='" criado com sucesso'.PHP_EOL;
				print $msg;
			}else{
				$msg='erro ao criar o db '.$filename;
				die($msg.PHP_EOL);
			}
		}
	}
	function db($id=false){
		if(!$id){
			$id=@$_ENV['DB_ID'];
		}
		$prf='DB'.$id;
		$type=@$_ENV[$prf.'_TYPE'];
		if($type=='mysql'){
			return new Medoo([
				'type'=>'mysql',
				'host'=>@$_ENV[$prf.'_HOST'],
				'database'=>@$_ENV[$prf.'_DATABASE'],
				'username'=>@$_ENV[$prf.'_USERNAME'],
				'password'=>@$_ENV[$prf.'_PASSWORD'],
				'charset'=>'utf8mb4',
				'collation'=>'utf8mb4_unicode_ci',
				'port'=>3306
			]);
		}
		if($type=='sqlite'){
			$database=@$_ENV[$prf.'_DATABASE'];
			$database=ROOT.'/'.$database;
			return new Medoo([
				'type'=>'sqlite',
				'database'=>$database
			]);
		}
		die('DB'.$id.' not found');
	}
	function createMysqlDB(mixed $id){
		$prf='DB'.$id;
		$host=$_ENV[$prf.'_HOST'];
		$user=$_ENV[$prf.'_USERNAME'];
		$password=$_ENV[$prf.'_PASSWORD'];
		$dbname=$_ENV[$prf.'_DATABASE'];
		if(
			!$this->dbMysqlExists(
				$host,$user,$password,$dbname
			)
		){
			$conn=new mysqli($host,$user,$password);
			$sql='CREATE DATABASE '.$dbname;
			$sql.=' CHARACTER SET utf8mb4 COLLATE ';
			$sql.='utf8mb4_unicode_ci;';
			if(mysqli_query($conn,$sql)){
				$msg='db "'.$dbname.'" criado com ';
				$msg.='sucesso'.PHP_EOL;
				print $msg;
			}
		}
	}
	function dbMysqlExists($host,$user,$password,$dbname){
		$conn=new mysqli($host,$user,$password);
		$sql="SHOW DATABASES LIKE '$dbname'";
		if(
			empty(
				mysqli_fetch_array(
					mysqli_query($conn,$sql)
				)
			)
		){
			return false;
		}else{
			return $conn;
		}
	}	
	function mig($id=false){
		$DB=new DB();
		$prefix='DB'.$id;
		$dbType=@$_ENV[$prefix.'_TYPE'];
		if($dbType=='mysql'){
			$DB->createMysqlDB($id);
		}
		if($dbType=='sqlite'){
			$DB->createSQLiteDB($id);
		}
		$db=$DB->db($id);
		$pdo=$db->pdo;
		$tableDirectory=glob(ROOT.'/table');
		$Mig=new Mig($pdo,$tableDirectory,$dbType);
		$Mig->mig();
	}
}