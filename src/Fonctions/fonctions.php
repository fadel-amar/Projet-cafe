<?php
namespace App\Fonctions;
    function Redirect_Self_URL():void{
        unset($_REQUEST);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

function GenereMDP($nbChar) :string{

    return "secret";
}

function calculComplexiteMdp($mdp): int {
    $Minuscules = false;
    $Majuscule = false;
    $Caracteres = false;
    $Chiffres = false;

    $tabminiscules = range('a', 'z');
    $tabmajuscules = range('A', 'Z');
    $tabcarcateres = ['!', '#', '$', '%', '*', '%', '?'];
    $tabcarcateresPlus = ['#', '$', '*', '%', '?', '&', '[', '|', ']', '@', '^', 'µ', '§', ':', '/', ';', '.', ',', '<', '>', '°'];

    for ($i = 0; $i < strlen($mdp)  ; $i++) {
        if (in_array($mdp[$i], $tabminiscules)) {
            $Minuscules = true;
        } elseif (in_array($mdp[$i], $tabmajuscules)) {
            $Majuscule = true;
        } elseif (is_numeric($mdp[$i])) {
            $Chiffres = true;
        } elseif (in_array($mdp[$i], $tabcarcateres) || in_array($mdp[$i], $tabcarcateresPlus)) {
            $Caracteres = true;
        }
    }


    $possibilite = 0;
    if ($Minuscules) {
        $possibilite += count($tabminiscules);
    } elseif ($Majuscule) {
        $possibilite += count($tabminiscules);
    } elseif ($Chiffres) {
        $possibilite += 10;
    } elseif ($Caracteres) {
        $possibilite += count($tabcarcateres);
    }

    $complexite = Log($possibilite**strlen($mdp))/ Log(2);



    return $complexite+1;

}