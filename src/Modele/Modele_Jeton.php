<?php

namespace App\Modele;


use App\Utilitaire\Singleton_ConnexionPDO;
use PhpParser\Node\Expr\New_;

class Modele_Jeton {



    static function Jeton_Creer($valeur, $idUtilisateur, $dateFin , $ip) {

        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'INSERT INTO `token` (`valeur`, `idUtilisateur`, `dateFin`, `ip`) 
         VALUES  (:valeur, :paramidUtilisateur, :paramdateFin, :paramip );');

        $requetePreparee->bindParam('paramtoken', $valeur);
        $requetePreparee->bindParam('paramidUtilisateur', $idUtilisateur);
        $requetePreparee->bindParam('paramdateFin', $dateFin);
        $requetePreparee->bindParam('paramip', $ip);

        $reponse = $requetePreparee->execute();
        if ($reponse) {
            return true;
        }
        return false;
    }





}