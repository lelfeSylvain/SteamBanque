<?php

function validerMontant($montant) {
    $retour = false;
    if (filter_var($montant, FILTER_VALIDATE_FLOAT) !== false) {
        $m = intval(filter_var($montant, FILTER_VALIDATE_FLOAT) * 100) / 100;
        if ($m >= 0) {
            $pdo = PDOSB::getPdoSB();
            $decouvert = $pdo->getDecouvert($_SESSION['id'], $_SESSION['numCompte']);
            $solde = $pdo->getSolde($_SESSION['id'], $_SESSION['numCompte']);
            if ($m < ($solde + $decouvert)) {
                $retour = $m;
            }
        }
    }
    return $retour;
}

function validerNumClient($numCli) {
    $retour = false;
    $pdo = PDOSB::getPdoSB();
    if ($pdo->getInfoUtil($numCli) !== null) {
        $retour = $numCli;
        $_SESSION['idTiers'] = $numCli;
    }
    return $retour;
}

function validerPWD($pwd) {
    $retour = false;
    $pdo = PDOSB::getPdoSB();
    if (1 === ((int) $pdo->verifierAncienMdP($_SESSION['id'], $pwd))) {
        $retour = $pwd;
    }
    return $retour;
}

function validerNumCompte($numCompte) {
    $retour = false;
    $pdo = PDOSB::getPdoSB();
    if (1 === ((int) $pdo->existe($_SESSION['idTiers'], $numCompte))) {
        $retour = $numCompte;
        unset($_SESSION['idTiers']);
    }
    return $retour;
}

if ("check" === $num) {// on récupère les POST des champs de saisie
    $decouvert = $pdo->getDecouvert($_SESSION['id'], $_SESSION['numCompte']);
    $solde = $pdo->getSolde($_SESSION['id'], $_SESSION['numCompte']);
    $tabFiltre = array('idTiers' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerNumClient'
        ), 'nouveau' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerPWD'
        ), 'numTiers' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerNumCompte'
        ), 'montant' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerMontant'
    ));

    $resultat = filter_input_array(INPUT_POST, $tabFiltre);
    if ($resultat != null) { //Si le formulaire a bien été posté.
//Enregistrer des messages d'erreur perso.
        $messageErreur = array(
            'idTiers' => "Le numéro de client n'existe pas.",
            'nouveau' => "Le mot de passe n'est pas valide.",
            'numTiers' => "Le numéro de compte n'existe pas pour ce Client",
            'montant' => "Le montant doit être positif et ne doit pas dépasser le solde (" . ($solde + $decouvert) . " " . $_SESSION['symbole'] . ")"
        );
        $nbrErreurs = 0;
        foreach ($tabFiltre as $cle => $valeur) { //Parcourir tous les champs voulus.
            if ($resultat[$cle] === null) { //Si le champ est vide.
                $textNav = 'Veuillez remplir le champ ' . $cle . EOL;
                $nbrErreurs++;
            } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
                $textNav = $messageErreur[$cle] . EOL;
                $nbrErreurs++;
            }
        }

        if ($nbrErreurs == 0) {
            if ($_SESSION['id'] == $resultat['idTiers'] and $_SESSION['numCompte'] == $resultat['numTiers']) {
                $textNav = "Le compte tiers est le même que le votre. Transaction annulée".EOL;
            } else {
                $pdo->mouvementCompteClient($_SESSION['id'], $_SESSION['numCompte'], -$resultat['montant'], $resultat['idTiers'], $resultat['numTiers']);
                $pdo->mouvementCompteClient($resultat['idTiers'], $resultat['numTiers'], $resultat['montant'], $_SESSION['id'], $_SESSION['numCompte']);
                $textNav = "Transaction effectué";
            }
        }
    } else {
        $textNav = "Vous n'avez rien posté.";
    }
}
include('vues/v_transaction.php');
