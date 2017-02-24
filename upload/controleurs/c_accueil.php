<?php
$estSU=$pdo->isSuperUser($_SESSION['id']);
if (! $estSU) {//
    if (! isset($_SESSION['numCompte'])) {
        $_SESSION['numCompte']= $pdo->getValDefaut("numCompteClient")+1;
    }
    $lesDernieresOperations = $pdo->getDernieresOperationsDuClient($_SESSION['id'],$_SESSION['numCompte']);
    
    $solde= $pdo->getSolde($_SESSION['id'],$_SESSION['numCompte']);
}
include('vues/v_accueil.php');

