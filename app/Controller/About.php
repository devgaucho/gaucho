<?php
namespace App\Controller;

use Gaucho\Gaucho;

class About extends Gaucho
{
	public function GET()
	{
		$data = [
			'title' => 'Sobre',
		];
		$this->chaplin('about', $data);
	}
}
