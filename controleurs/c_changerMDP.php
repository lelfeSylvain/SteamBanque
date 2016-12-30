<?php

/*
 * Controleur pour gérer la modification du mot de passe
 */
$texteNav = "";
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
                $texteNav = 'Veuillez remplir le champ ' . $cle . '.<br/>';
                $nbrErreurs++;
            } elseif ($resultat[$cle] === false) { //S'il n'est pas valide.
                $texteNav = $messageErreur[$cle] . '<br/>';
                $nbrErreurs++;
            }
        }

        if ($nbrErreurs == 0) {
            if ($resultat['nouveau'] === $resultat['confirmation']) {// au cas où le JS serait désactivé
                if (1 === ((int) $pdo->verifierAncienMdP($_SESSION['id'], $resultat['ancien']))) {//le mot de passe saisi est le bon
                    $resultSetMdP = $pdo->setMdP($_SESSION['id'], $resultat['nouveau'], $resultat['ancien']);
                    if ($resultSetMdP === false) {
                        $texteNav = "Problème BD : Le mot de passe n'a pas été mis à jour.";
                    } else {
                        $texteNav = "Le mot de passe a été mis à jour.";
                    }
                } else { // ancien mdp saisi incorrecte
                    $texteNav = "L'ancien mot de passe n'est pas le bon.";
                }
            }
        }
    } else {
        $texteNav = 'Vous n\'avez rien posté.';
    }
}
$titre = "Changer votre mot de passe";
$cible = "changerMdP";

include('vues/v_changerMDP.php');
