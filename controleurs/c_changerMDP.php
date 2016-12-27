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
/*   if (isset($_POST['ancien']) && isset($_POST['nouveau']) && isset($_POST['confirmation'])) {//on a tout
  $ancien = clean($_POST['ancien']);
  $nouveau = clean($_POST['nouveau']);
  $confirmation = clean($_POST['confirmation']);
  if ($nouveau === $confirmation) {// au cas ou le JS serait désactivé
  $pdo = PDOSB::getPdoSB();
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
  } */

include('vues/v_changerMDP.php');
