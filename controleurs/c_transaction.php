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

if ("check" === $num) {// on récupère les POST des champs de saisie
    $decouvert = $pdo->getDecouvert($_SESSION['id'], $_SESSION['numCompte']);
    $solde = $pdo->getSolde($_SESSION['id'], $_SESSION['numCompte']);
    $lesPost = array('idTiers', 'nouveau', 'numTiers', 'montant');
    $tabFiltre = array();
    $messageErreur = array();
    foreach ($lesPost as $val) {
        if ('montant' === $val) {
            $filtre = array(
                'filter' => FILTER_CALLBACK, // procédure maison
                'options' => 'validerMontant'
            );
        } else {
            $filtre = FILTER_SANITIZE_STRING;
        }
        $tabFiltre[$val] = $filtre;
    }
    $resultat = filter_input_array(INPUT_POST, $tabFiltre);
    if ($resultat != null) { //Si le formulaire a bien été posté.
        //Enregistrer des messages d'erreur perso.
        $messageErreur = array(
            'idTiers' => "Le numéro de client n'existe pas.",
            'nouveau' => "Le mot de passe n'est pas valide.",
            'numTiers' => "Le numéro de compte n'existe pas pour ce compte",
            'montant' => "Le montant doit être positif et ne doit pas dépasser le solde (" . ($solde+$decouvert) . " " . $_SESSION['symbole'] . ")"
        );
        $nbrErreurs = 0;
        foreach ($tabFiltre as $cle => $valeur) { //Parcourir tous les champs voulus.
            if ($resultat[$cle] === null) { //Si le champ est vide.
                $texteNav = 'Veuillez remplir le champ ' . $cle . EOL;
                $nbrErreurs++;
            } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
                $texteNav = $messageErreur[$cle] . EOL;
                $nbrErreurs++;
            }
        }

        if ($nbrErreurs == 0) {
            if (1 === ((int) $pdo->verifierAncienMdP($_SESSION['id'], $resultat['nouveau']))) {//le mot de passe saisi est le bon
                $pdo->mouvementCompteClient($_SESSION['id'], $_SESSION['numCompte'], -$resultat['montant'], $resultat['idTiers'], $resultat['numTiers']);
                $pdo->mouvementCompteClient($resultat['idTiers'], $resultat['numTiers'], $resultat['montant'], $_SESSION['id'], $_SESSION['numCompte']);
                $texteNav = "Transaction effectué";
            } else { // ancien mdp saisi incorrecte
                $texteNav = "Le mot de passe n'est pas le bon.";
            }
        }
    } else {
        $texteNav = "Vous n'avez rien posté.";
    }

    
}
include('vues/v_transaction.php');
