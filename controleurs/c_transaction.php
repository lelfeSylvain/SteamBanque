<?php

function validerMontant($montant) {
    $retour = false;
    if (filter_var($montant, FILTER_VALIDATE_FLOAT) !== false) {
        $retour = intval(filter_var($montant, FILTER_VALIDATE_FLOAT) * 100) / 100;
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


if ("check" === $num) {// on récupère les POST des champs de saisie
    $tabFiltre = array('idTiers' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerNumClient'
        ), 'nouveau' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerPWD'
        ), 'idSource' => array(
            'filter' => FILTER_CALLBACK, // procédure maison 
            'options' => 'validerNumClient'
        ),  'estClient' => array(
            'filter' => FILTER_SANITIZE_NUMBER_INT, // est un entier (en fait un booléen)
            'options' => null
        ), 'montant' => array(
            'filter' => FILTER_CALLBACK, // procédure maison
            'options' => 'validerMontant'
    ));

    $resultat = filter_input_array(INPUT_POST, $tabFiltre);

    if ($resultat != null) { //Si le formulaire a bien été posté.
        if (0 == $resultat['estClient']) {// formulaire admin
            $idSource = $resultat['idSource'];
            // Attention, pas de mot de passe si l'utilisateur est un admin
            $resultat['nouveau'] = 'ok';
        } else {// formulaire client
            $idSource = $_SESSION['id'];
            $resultat['idSource'] =$idSource;
        }
        // vérification si le mouvement est autorisé (ne dépasse pas le découvert autorisé
        $decouvert = $pdo->getDecouvert($idSource);
        $solde = $pdo->getSolde($idSource);
        if ($resultat['montant'] > ($solde + $decouvert)) {
            $resultat['montant'] = false;
        }
        // Attention, pas de mot de passe si l'utilisateur est un admin
     /*   if (! $estClient) {
            $resultat['nouveau'] = 'ok';
        } */
        //Enregistrer des messages d'erreur perso.
        $messageErreur = array(
            'idTiers' => "Le numéro du client tier n'existe pas.",
            'nouveau' => "Le mot de passe n'est pas valide.",
            'idSource' => "Le numéro du client source n'existe pas.",            
            'estClient' => "",
            'montant' => "Le montant doit être positif et ne doit pas dépasser le solde (" . ($solde + $decouvert) . " " . $_SESSION['symbole'] . ")"
        );
        $err = array (
            'idTiers' => "n°client destinataire",
            'nouveau' => "mot de passe",
            'idSource' => "numéro du client",            
            'estClient' => "estClient",
            'montant' => "montant");
        $nbrErreurs = 0;
        foreach ($tabFiltre as $cle => $valeur) { //Parcourir tous les champs voulus.
            if ($resultat[$cle] === null) { //Si le champ est vide.
                $textNav = 'Veuillez remplir le champ ' . $err[$cle] . EOL;
                $nbrErreurs++;
            } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
                $textNav = $messageErreur[$cle] . EOL;
                $nbrErreurs++;
            }
        }

        if ($nbrErreurs == 0) {
            if ($idSource == $resultat['idTiers'] ) {
                $textNav = "Le compte tiers est le même que le votre. Transaction annulée" . EOL;
            } else {
                $pdo->mouvementCompteClient($idSource,  -$resultat['montant'], $resultat['idTiers']);
                $pdo->mouvementCompteClient($resultat['idTiers'], $resultat['montant'], $idSource);
                $textNav = "Transaction effectué";
            }
        }
    } else {
        $textNav = "Vous n'avez rien posté.";
    }
}

include('controleurs/c_accueil.php');

