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
        // on filtre la case à cocher
        if (filter_has_var(INPUT_POST, 'estSU')) {
            $enregistrementOK= $pdo->setNouveauUtil($mesPost['id'], $mesPost['nouveau'], $mesPost['prenom'], $mesPost['nom'],1);
        }
        else {
            $enregistrementOK= $pdo->setNouveauUtil($mesPost['id'], $mesPost['nouveau'], $mesPost['prenom'], $mesPost['nom']);
        }

        // 
        // $mesPost est un tableau associatif contenant les nouvelles valeurs filtrées
        if ($enregistrementOK !== null) { // on reporte ces modifications dans la BD
            $numCompte=$pdo->creerCompteClient($mesPost['id']);
            $res=$pdo->initialiserCompteClient($mesPost['id'],$numCompte);
            $textNav = "Nouveau client ".$mesPost['id']." créé, avec le compte ".$mesPost['id']."-".$numCompte;
        } else {
            $textNav = "Problème avec la BD dans l'enregistrement du nouveau client. Le compte n'a pas été créé";
        }
    }
    include("vues/v_ajouterClient.php");
} else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}

