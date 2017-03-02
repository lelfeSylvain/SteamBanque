<!DOCTYPE html>
<?php
/* Projet SteamBanque
  sylvain 18 décembre 2016 - 2 mars 2017
 * temps écoulé = 38h00
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
    $estSU = $pdo->isSuperUser($_SESSION['id']);
//echo $uc.EOL;
    // gère le fil d'ariane : TODO à gérer
    //include_once 'controleurs/c_ariane.php';
    //aiguillage principal
    //echo '**************' . $uc . "  -  " . $num . EOL;
    switch ($uc) {
        case 'ajouterClient': { // créer un nouvel utilisateur (seulement SUser)
                include("controleurs/c_ajouterClient.php");
                break;
            }
        case 'modifierClient': { // modifier un nouvel utilisateur (seulement SUser)
                include("controleurs/c_modifierClient.php");
                break;
            }
        case 'modifierMdPClient': { // modifier un nouvel utilisateur (seulement SUser)
                include("controleurs/c_modifierMdPClient.php");
                break;
            }
        case 'modifierParam': { // modifier les paramètres de l'application (seulement SUser)
                include("controleurs/c_modifierParam.php");
                break;
            }
        case 'changerMdP': {// uc modification du mot de passe
                include("controleurs/c_changerMDP.php");
                break;
            }
        case 'transaction': { // transaction entre le client connecté et un tier
                include("controleurs/c_transaction.php");
                break;
            }
        case 'importer': { // modifier les paramètres de l'application (seulement SUser)
                include("controleurs/c_import.php");
                break;
            }
        case 'supprimer': { //supprimer un ou plusieurs utilisateurs
                include("controleurs/c_suppression.php");
                break;
            }
        case 'deconnexion': { // se déconnecter
                logout();
                include('controleurs/c_login.php');
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


