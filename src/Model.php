<?php
namespace Gaucho;
use Gaucho\DB;
class Model extends DB{
	var $table;
	function create($data){
		$data['created_at']=time();
		$this->db()->insert($this->table,$data);
		return $this->db->id();
	}
	function readAll(){
		$cols='*';
		return $this->db()->select($this->table,$cols);
	}
	function readById($id){
		$cols='*';
		$where=[
			'id'=>$id
		];
		return $this->db()->get($this->table,$cols,$where);
	}
}