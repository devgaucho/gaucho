<?php
namespace App\Controller;

use Gaucho\Gaucho;

class Home extends Gaucho
{

    function GET()
    {
        $data = [
            'name' => 'world',
            'title' => 'Início'
        ];
//         TODO adicioar header
        $this->chaplin('home', $data);
        // TODO adicionar footer
    }
}