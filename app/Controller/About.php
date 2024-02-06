<?php 
namespace App\Controller;

use Gaucho\Gaucho;

class About extends Gaucho{
	function GET(){
		$data=[
			'title'=>'Sobre'
		];
		$this->chaplin('about',$data);
	}
}