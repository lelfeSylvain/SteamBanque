<?php


if (!$estSU) {//
    if (!isset($_SESSION['numCompte'])) {
        $_SESSION['numCompte'] = $pdo->getValDefaut("numCompteClient") + 1;
    }
    $lesDernieresOperations = $pdo->getDernieresOperations($_SESSION['id'], $_SESSION['numCompte']);

    $solde = $pdo->getSolde($_SESSION['id'], $_SESSION['numCompte']);
    $typeFormulaire = "formulaireCourt";
} else {
    $typeFormulaire = "formulaire";
}
include('vues/v_accueil.php');

