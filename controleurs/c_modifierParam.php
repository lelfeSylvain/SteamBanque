<?php

if ($pdo->isSuperUser($_SESSION['id'])) {// seulement le SU
    $lesParam = $pdo->getParam();
    if ("check" === $num) {// on récupère les POST
        $tabFiltre = array();
        foreach ($lesParam as list($key, $val, $monFiltre)) {
            if ("entier positif" === $monFiltre) {
                $filtre = array(
                    'filter' => FILTER_VALIDATE_INT, // entier
                    'options' => array(
                        'min_range' => 0 // positif
                    )
                );
            } elseif ("chaine" === $monFiltre || "chaîne" === $monFiltre) {
                $filtre = FILTER_SANITIZE_STRING;
            }
            $tabFiltre[$key] = $filtre;
        }
        $monFiltrePost = array('value' => $tabFiltre);
        
        $monPost = filter_input_array(INPUT_POST, $monFiltrePost);
    }
    $lesParam = $pdo->getParam();
    include("vues/v_modifierParam.php");
} else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}
    