<?php

if ($pdo->isSuperUser($_SESSION['id'])) {// seulement le SU
    if ("choix" === $num) {// on vient de choisir le client à modifier
       $monIdChoisi = filter_input(INPUT_POST, 'choixClient' , FILTER_SANITIZE_STRING); 
       list($idClient, $nomClient, $prenomClient, $mdp, $ts, $estSUClient) = $pdo->getInfoUtil($monIdChoisi);
        include("vues/v_modifierClient.php");  
    }elseif ("check" === $num) {
        $lesPost = array('id', 'nom', 'prenom');
        $tabFiltre = array();
        foreach ($lesPost as $val) {
            $tabFiltre[$val] =  FILTER_SANITIZE_STRING;
        }
        $mesPost = filter_input_array(INPUT_POST, $tabFiltre);
        // on filtre la case à cocher
        if (filter_has_var(INPUT_POST, 'estSU')) {
            $enregistrementOK= $pdo->updateUtil($mesPost['id'], $mesPost['prenom'], $mesPost['nom'],1);
        }
        else {
            $enregistrementOK= $pdo->updateUtil($mesPost['id'], $mesPost['prenom'], $mesPost['nom']);
        }

        // 
        // $mesPost est un tableau associatif contenant les nouvelles valeurs filtrées
        if ($enregistrementOK !== null) { // on reporte ces modifications dans la BD
            $textNav = "client mis à jour";
        } else {
            $textNav = "Problème avec la BD dans la modification du client.";
        }
    }else { // premier passage
        $lesClients = $pdo->getLesClients();
        $titre = "Modifier un client";
        $cible = "modifierClient";
        include("vues/v_choixClient.php"); 
    }
    
              
}
else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}

