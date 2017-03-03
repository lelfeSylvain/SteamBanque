<?php

if ($pdo->isSuperUser($_SESSION['id'])) {// seulement le SU
    $lesPost = array('id', 'nouveau', 'nom', 'prenom');
    if ("check" === $num) {// on récupère les POST des champs de saisie
        $tabFiltre = array();
        foreach ($lesPost as $val) {
            $filtre = FILTER_SANITIZE_STRING;
            $tabFiltre[$val] = $filtre;
        }
        $mesPost = filter_input_array(INPUT_POST, $tabFiltre);
        
        $textNav = $pdo->creerUnUtilisateurCompletement($mesPost,filter_has_var(INPUT_POST, 'estSU'));
        
    }
    include("vues/v_ajouterClient.php");
} else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}

