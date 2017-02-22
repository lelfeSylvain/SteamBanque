<?php

/*
 * Controleur pour gérer la modification du mot de passe
 */
$textNav = "";
if ($num === 'check') {// on récupère les données saisies
    $ancien = "";
    $nouveau = "";
    $confirmation = "";
    $optionsFiltre = array(
        'ancien' => FILTER_SANITIZE_STRING,
        'nouveau' => FILTER_SANITIZE_STRING,
        'confirmation' => FILTER_SANITIZE_STRING
    );
    $resultat = filter_input_array(INPUT_POST, $optionsFiltre);
    if ($resultat != null) { //Si le formulaire a bien été posté.
        //Enregistrer des messages d'erreur perso.
        $messageErreur = array(
            'ancien' => 'L\'ancien mot de passe n\'est pas valide.',
            'nouveau' => 'Le nouveau mot de passe n\'est pas valide.',
            'confirmation' => 'La saisie de confirmation du mot de passe n\'est pas valide.'
        );
        $nbrErreurs = 0;
        foreach ($optionsFiltre as $cle => $valeur) { //Parcourir tous les champs voulus.
            if ($resultat[$cle] === null) { //Si le champ est vide.
                $textNav = 'Veuillez remplir le champ ' . $cle . EOL;
                $nbrErreurs++;
            } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
                $textNav = $messageErreur[$cle] . EOL;
                $nbrErreurs++;
            }
        }

        if ($nbrErreurs == 0) {
            if ($resultat['nouveau'] === $resultat['confirmation']) {// au cas où le JS serait désactivé
                if (1 === ((int) $pdo->verifierAncienMdP($_SESSION['id'], $resultat['ancien']))) {//le mot de passe saisi est le bon
                    $resultSetMdP = $pdo->setMdP($_SESSION['id'], $resultat['nouveau'], $resultat['ancien']);
                    if ($resultSetMdP === false) {
                        $textNav = "Problème BD : Le mot de passe n'a pas été mis à jour.";
                    } else {
                        $textNav = "Le mot de passe a été mis à jour.";
                    }
                } else { // ancien mdp saisi incorrecte
                    $textNav = "L'ancien mot de passe n'est pas le bon.";
                }
            }
        }
    } else {
        $textNav = 'Vous n\'avez rien posté.';
    }
}
$titre = "Changer votre mot de passe";
$cible = "changerMdP";

include('vues/v_changerMDP.php');
