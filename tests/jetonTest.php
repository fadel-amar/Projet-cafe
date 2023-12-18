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

        $execute = \App\Modele\Modele_Jeton::Jeton_Creer("4654hfdhgfsgdshshhshdshhshsdh6487787868","19",(New \DateTime())->format("Y-m-d"),'::12');
        self::assertTrue($execute);

    }





}