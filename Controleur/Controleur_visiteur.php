<?php

use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_ChoisirNouveauMdp;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Mail_ReinitMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

use PHPMailer\PHPMailer\PHPMailer;

//Ce contrôleur gère le formulaire de connexion pour les visiteurs

$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {

    case "reinitMdpToken":
        $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp("confirmMDPToken", $_GET["token"], ""));
        break;

    case "confirmMDPToken":
        if (isset($_GET["token"])) {
            $token = $_GET["token"];
        }
        if (isset($_POST["token"])) {
            $token = $_POST["token"];
        }
        if ($_POST["NouveauPassword"] != $_POST["ConfirmPassword"]) {
            $Vue->setEntete(new Vue_Structure_Entete());
            $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp(
                "confirmMDPToken", $token, "Les mots de passe ne correspondent pas !!!"));
        } else {
            if ($_POST["mdp1"] == $_POST["mdp2"]) {
                if (\App\Fonctions\calculComplexite($_POST["NouveauPassword"]) >= 90) {
                    Modele_Utilisateur::Utilisateur_Modifier_motDePasse($_SESSION["idUtilisateur"], $_POST["NouveauPassword"]);
                    MDPUserChange($_SESSION["idUtilisateur"]);
                    $Vue->setEntete(new Vue_Structure_Entete());
                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
                    // Dans ce cas les mots de passe sont bons, il est donc modifié
                } else {
                    $Vue->setEntete(new Vue_Structure_Entete());
                    $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp("confirmMDPToken", $token, "Le mot de passe est trop simple"));
                }
            }
        }
        break;

    case "reinitmdpconfirm":

        //comme un qqc qui manque... je dis ça ! je dis rien !
        if (\App\Fonctions\reinitmdp($_POST['email'])) {
            header("Location:index.php");
        }


        $Vue->addToCorps(new Vue_Mail_Confirme());

        break;
    case "reinitmdp":


        $Vue->addToCorps(new Vue_Mail_ReinitMdp());

        break;
    case "Se connecter" :
        if (isset($_REQUEST["compte"]) and isset($_REQUEST["password"])) {
            //Si tous les paramètres du formulaire sont bons

            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["compte"]);

            if ($utilisateur != null) {
                //error_log("utilisateur : " . $utilisateur["idUtilisateur"]);
                if ($utilisateur["desactiver"] == 0) {
                    if ($_REQUEST["password"] == $utilisateur["motDePasse"]) {
                        $_SESSION["idUtilisateur"] = $utilisateur["idUtilisateur"];
                        //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                        $_SESSION["idCategorie_utilisateur"] = $utilisateur["idCategorie_utilisateur"];
                        //error_log("idCategorie_utilisateur : " . $_SESSION["idCategorie_utilisateur"]);
                        switch ($utilisateur["idCategorie_utilisateur"]) {
                            case 1:
                                $_SESSION["typeConnexionBack"] = "administrateurLogiciel"; //Champ inutile, mais bien pour voir ce qu'il se passe avec des étudiants !
                                $typeConnexion = "administrateurLogiciel";
                                $Vue->setMenu(new Vue_Menu_Administration($typeConnexion));
                                break;
                            case 2:

                                $_SESSION["typeConnexionBack"] = "utilisateurCafe";
                                $Vue->setMenu(new Vue_Menu_Administration());
                                break;

                                break;
                            case 3:
                                $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                                //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                                $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                                include "./Controleur/Controleur_Gerer_Entreprise.php";
                                break;
                            case 4:
                                $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                                $_SESSION["idSalarie"] = $utilisateur["idUtilisateur"];
                                $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                                include "./Controleur/Controleur_Catalogue_client.php";
                                break;
                        }

                    } else {//mot de passe pas bon
                        $msgError = "Mot de passe erroné";

                        $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                    }
                } else {
                    $msgError = "Compte désactivé";

                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                }
            } else {
                $msgError = "Identification invalide";

                $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
            }
        } else {
            $msgError = "Identification incomplete";

            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
        }
        break;
    default:

        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());

        break;
}


$Vue->setBasDePage(new Vue_Structure_BasDePage());