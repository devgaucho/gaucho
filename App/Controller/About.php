<?php 
namespace App\Controller;

use Gaucho\Gaucho;

class About extends Gaucho{
	function GET(){
		$data=[
			'title'=>'Sobre'
		];
// 		TODO adicionar header
		$this->chaplin('about',$data);
// 		TODO adicionar footer
	}
}