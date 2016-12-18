<?php

/*
 * Controleur pour gérer la modification du mot de passe
 */
$texteNav = "";
if ($num === 'check') {// on récupère les données saisies
    $ancien = "";
    $nouveau = "";
    $confirmation = "";
    if (isset($_POST['ancien']) && isset($_POST['nouveau']) && isset($_POST['confirmation'])) {//on a tout
        $ancien = clean($_POST['ancien']);
        $nouveau = clean($_POST['nouveau']);
        $confirmation = clean($_POST['confirmation']);
        if ($nouveau === $confirmation) {// au cas ou le JS serait désactivé
            $pdo = PDOMenu::getPdoMenu();
            if (1 === ((int) $pdo->verifierAncienMdP($_SESSION['username'], $ancien))) {//le mot de passe saisi est le bon
                $pdo->setMdP($_SESSION['username'], $nouveau, $ancien);
                $texteNav = "Le mot de passe a été mis à jour.";
            } else { // ancien mdp saisi incorrecte
                $texteNav = "L'ancien mot de passe n'est pas le bon.";
            }
        } else {// JS serait désactivé
            header('Location: index.php?uc=lecture&num=actuelle');
        }
    } else {// formulaire incomplet ??? ou autre erreur d'aiguillage
        header('Location: index.php?uc=lecture&num=actuelle');
    }
}

include('vues/v_changerMDP.php');
