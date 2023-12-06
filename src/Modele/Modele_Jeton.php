<?php

namespace App\Modele;



use App\Utilitaire\Singleton_ConnexionPDO;

class Modele_Jeton {

    static function Jeton_Creer($valeur,$idUser,$dateFin) {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'INSERT INTO `token` (`valeur`, `idUtilisateur` ,`dateFin`) 
         VALUES  (:valeur, :codeAction, :idUtilisateur, :paramdateFin );');

        $requetePreparee->bindParam('paramtoken', $valeur);
        $requetePreparee->bindParam('paramidUser', $idUser);
        $requetePreparee->bindParam('paramdateFin', $dateFin);

        $reponse = $requetePreparee->execute();
        if ($reponse) {
            return true;
        }
        return false;
    }







}