<?php

use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Mail_ReinitMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;
use App\Vue\Vue_ConsentementRGPD;


switch ($action) {
    case 'Se connecter';
        $Vue->setEntete(new Vue_Structure_Entete());
        $VueConsentement = (new Vue_ConsentementRGPD());
        $Vue->addToCorps($VueConsentement);
        break;
    case 'AccepterRGPD':
        // DB update --> à faire !
        $Vue->setEntete(new Vue_Structure_Entete());

        break;
    case 'RefuserRGPD':
        session_destroy();
        unset($_SESSION["idEntreprise"]);
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());


}

