<?php

namespace App\Controller;

use Gaucho\Gaucho;

class Home extends Gaucho
{
    public function GET()
    {
        $data = [
            'name' => 'world',
            'title' => 'Início',
        ];
        $this->chaplin('home', $data);
    }
}
