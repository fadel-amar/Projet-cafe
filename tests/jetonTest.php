<?php
use PHPUnit\Framework\TestCase;

class jetonTest extends TestCase
{

    public function generJeton_taille255 (){

        $token = \App\Fonctions\genererToken();
        $TT = strlen($token);

    }


}