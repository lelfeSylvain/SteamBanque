<?php

$textNav = "";
// TODO ici il faut modifier le get et le check, check2.
if ($pdo->isSuperUser($_SESSION['id'])) {// seulement le SU
    $titre = "Changer le mot de passe d'un client";
    $cible = "modifierMdPClient";
    if ("choix" === $num) {// on vient de choisir le client à modifier
        $monIdChoisi = filter_input(INPUT_POST, 'choixClient', FILTER_SANITIZE_STRING);
        list($idClient, $nomClient, $prenomClient, $mdp, $ts, $estSUClient) = $pdo->getInfoUtil($monIdChoisi);

        include("vues/v_changerMDP.php");
    } elseif ("check" === $num) {
        $lesPost = array('nouveau', 'confirmation', 'id');
        $tabFiltre = array();
        foreach ($lesPost as $val) {
            $tabFiltre[$val] = FILTER_SANITIZE_STRING;
        }
        $mesPost = filter_input_array(INPUT_POST, $tabFiltre);

        $enregistrementOK = $pdo->setMdP($mesPost['id'], $mesPost['nouveau']);

        if ($enregistrementOK !== null) { // on reporte ces modifications dans la BD
            $textNav = "client mis à jour";
        } else {
            $textNav = "Problème avec la BD dans la modification du client.";
        }
    } else { // premier passage
        $lesClients = $pdo->getLesClients($_SESSION['id']);

        include("vues/v_choixClient.php");
    }
} else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}
