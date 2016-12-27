<?php

if ($pdo->isSuperUser($_SESSION['id'])) {// seulement le SU
      include("vues/v_ajouterClient.php");            
}
else {// erreur d'aiguillage
    include("controleurs/c_accueil.php");
}

