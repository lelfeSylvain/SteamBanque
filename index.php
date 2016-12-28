<!DOCTYPE html>
<?php
/* Projet SteamBanque
  sylvain 18 décembre 2016
 * temps écoulé = 11h30
 */
require_once 'inc/fonctions.php'; //appelle tous les 'include' et fonctions utilitaires


/*
 * examinons les paramètres get 
 */
$monFiltreGet = array('uc' => FILTER_SANITIZE_STRING, 'num' => FILTER_SANITIZE_STRING);
$monGet = filter_input_array(INPUT_GET, $monFiltreGet);

if ($monGet === null or $monGet['uc'] === false) {//s'il n'y a pas d'uc alors on initie le comportement par défaut
    $uc = 'defaut';
    $num = 'actuelle';
} else { // il y a un uc, on l'utilise après l'avoir nettoyé
    $uc = $monGet['uc'];
    if ($monGet['num'] === false) {// pas de num -> valeur par défaut
        $num = 'actuelle';
    } else {
        $num = $monGet['num'];
    }
}
unset($monFiltreGet);
unset($monGet);
if ($uc === 'login') {
    include('controleurs/c_login.php');
}
// si l'utilisateur n'est pas identifié, il doit le faire
elseif (!Session::isLogged()) {
    include('controleurs/c_login.php');
} else {// à partir d'ici, l'utilisateur est forcément connecté
    // justement on enregistre la dernière activité de l'utilisateur dans la BD
    $pdo->setDerniereCx($_SESSION['numUtil']);
//echo $uc.EOL;
    // gère le fil d'ariane : TODO à gérer
    //include_once 'controleurs/c_ariane.php';
    //aiguillage principal
    //echo '**************' . $uc . "  -  " . $num . EOL;
    switch ($uc) {
        /* case 'lecture': {// uc lecture du menu 
          include("controleurs/c_semaine.php");
          break;
          } */
        /* case 'ecrire': {// uc création d'un repas
          include("controleurs/c_creation.php");
          break;
          } */
        case 'ajouterClient':{ // créer un nouvel utilisateur (seulement SUser)
            include("controleurs/c_ajouterClient.php");
            break;
        }
        case 'modifierClient':{ // modifier un nouvel utilisateur (seulement SUser)
            include("controleurs/c_modifierClient.php");
            break;
        }
        case 'modifierParam':{ // modifier les paramètres de l'application (seulement SUser)
            include("controleurs/c_modifierParam.php");
            break;
        }
        case 'changer': {// uc modification du mot de passe
                include("controleurs/c_changerMDP.php");
                break;
            }
        case 'defaut' :;
        default :  // par défaut on consulte les posts
            include("controleurs/c_accueil.php");
    }
}
/*
 * une visite a lieu, mémorisons-la
 */
//include('controleurs/c_visite.php');
include('controleurs/c_navigation.php');


