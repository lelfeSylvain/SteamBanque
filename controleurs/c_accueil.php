<?php


if (!$estSU) {// formulaire client
    
    $lesDernieresOperations = $pdo->getDernieresOperationsDuClient($_SESSION['id']);
    $estClient = 1;// pour gérer le formulaire abrégé des transactions
    $solde = $pdo->getSolde($_SESSION['id']);
    
} else {// formulaire admin
    $trier = filter_input(INPUT_POST,'trier', FILTER_SANITIZE_NUMBER_INT);
    $optionsFiltre = array(
        'numCpt' => FILTER_SANITIZE_STRING,
        'numCptTiers' => FILTER_SANITIZE_STRING,
        'trier' => FILTER_SANITIZE_NUMBER_INT
    );
    $resultat = filter_input_array(INPUT_POST, $optionsFiltre);
    $estClient = 0 ;// pour gérer le formulaire abrégé des transactions
    $lesDernieresOperations = $pdo->getLesDernieresOperations($resultat,20);//pour afficher les dernières opérations
    $lesSoldes= $pdo->getLesSoldes();// pour afficher tous les clients avec leurs soldes
}
include('vues/v_accueil.php');

