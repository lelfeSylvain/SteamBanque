<?php
// saisir ici le nom de la BD, util et mdp
$temp = "trombi";

 // paramètres d'accès au SGBD
     $serveur = 'mysql:host=localhost';
     $bdd = 'dbname='.$temp;
     $user = $temp;
     $mdp = $temp;
    // préfixe de toutes les tables
    $prefixe = $temp.'_';
    
    // active l'enregistrement des logs
    $modeDebug = true;