<?php

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class jetonTest extends TestCase
{


    #[test]
    public function generJeton_taille344 (){

        $token = \App\Fonctions\genererToken();
        $TT = strlen($token);
        self::assertEquals($TT,344);

    }


    #[test]
    public function Jeton_Creer_Valeurs_Correctes_True() {

        self::assertTrue($execute);

    }





}