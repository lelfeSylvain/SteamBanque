<?php


if (!$estSU) {//
    if (!isset($_SESSION['numCompte'])) {
        $_SESSION['numCompte'] = $pdo->getValDefaut("numCompteClient") + 1;
    }
    $lesDernieresOperations = $pdo->getDernieresOperationsDuClient($_SESSION['id'], $_SESSION['numCompte']);

    $solde = $pdo->getSolde($_SESSION['id'], $_SESSION['numCompte']);
    $typeFormulaire = "formulaireCourt";
} else {
    $trier = filter_input(INPUT_POST,'trier', FILTER_SANITIZE_NUMBER_INT);
    $typeFormulaire = "formulaire";
    $lesDernieresOperations = $pdo->getLesDernieresOperations($trier,20);
    
}
include('vues/v_accueil.php');

