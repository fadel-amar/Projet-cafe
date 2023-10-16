<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;

class ComplexiteMotdepasseTest extends TestCase
{

    /**
     * @test
     */
    public function ComplexiteTestMotdePasse_aubry_Egale43() {
        $complexite = \App\Fonctions\calculComplexiteMdp('aubry');
        self::assertEquals(24, $complexite);
    }


    /**
     * @test
     */
    public function ComplexiteTestMotdePasse_Superaubry16156lkoa_Egale90() {
        $complexite = \App\Fonctions\calculComplexiteMdp('Superaubry16156lkoa');
        self::assertEquals(90, $complexite);
    }
}