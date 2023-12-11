<?php

namespace App\Fonctions;
use App\Modele\Modele_Jeton;

function Redirect_Self_URL(): void
{
    unset($_REQUEST);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function GenereMDP($nbChar): string
{

    return "informations";
}

function calculComplexiteMdp($mdp): int
{
    $Minuscules = false;
    $Majuscule = false;
    $Caracteres = false;
    $Chiffres = false;

    $tabminiscules = range('a', 'z');
    $tabmajuscules = range('A', 'Z');
    $tabcarcateres = ['!', '#', '$', '%', '*', '%', '?'];
    $tabcarcateresPlus = ['#', '$', '*', '%', '?', '&', '[', '|', ']', '@', '^', 'µ', '§', ':', '/', ';', '.', ',', '<', '>', '°'];

    for ($i = 0; $i < strlen($mdp); $i++) {
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

    $complexite = Log($possibilite ** strlen($mdp)) / Log(2);


    return $complexite + 1;

}

function genererMDP($nbChar)
{
    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $pass = '';
    $len = strlen($chaine);
    for ($i = 0; $i < $nbChar; $i++) {
        $rnd = random_int(0, $len - 1);
        $char = $chaine[$rnd];
        $pass .= $char;
    }
    return mb_convert_encoding($pass, "UTF-8");
}


function reinitmdp($to)
{

    $entetes = [
        "from" => "no-reply-Cafe@cafe.fr",
        "content-type" => "text/html; charset=utf-8"
    ];
    $mdp = genererMDP(15);
    $message = "Voici votre nouveau mot de passe : " . $mdp;

    if (updateMdp($to, $mdp)) {
        if (mail($to, 'renouvellement mot de passe', $message, $entetes)) {
            return true;
        }
    }

}


function updateMdp($email, $mdp)
{
    $pdo = \App\Utilitaire\Singleton_ConnexionPDO::getInstance();
    $requetePreparee = $pdo->prepare(
        "UPDATE utilisateur
        SET motDePasse= :mdp, doitChangerMdp = 0
        WHERE login = :email");
    $requetePreparee->bindParam('email', $email);
    $requetePreparee->bindParam('mdp', $mdp);
    $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
    return $reponse;

}

function updateDoitChanger($email)
{
    $pdo = \App\Utilitaire\Singleton_ConnexionPDO::getInstance();
    $requetePreparee = $pdo->prepare(
        "UPDATE utilisateur
        SET  doitChangerMdp = 1
        WHERE login = :email");
    $requetePreparee->bindParam('email', $email);
    $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
    return $reponse;

}

function genererToken()
{
    $octetsAleatoires = openssl_random_pseudo_bytes(256);
    $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
    return $jeton;
}



/*function reinitmdpToken($to,$idUser, $dateFin , $ip) {
    $token = genererToken();
    $entetes = [
        "from" => "no-reply-Cafe@cafe.fr",
        "content-type" => "text/html; charset=utf-8"
    ];
    $message = " Veuillez cliquer ce lien pour changer votre mot de passe : <a href='http://localhost:8000/index.php?token=$token'</a> Cliquez ici";

    if (mail($to, 'renouvellement mot de passe', $message, $entetes)) {
       Modele_Jeton::Jeton_Creer($token,$idUser,  $dateFin, $ip);
        return true;
    }
}
*/

