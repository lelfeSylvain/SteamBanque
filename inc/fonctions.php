<?php

require_once 'inc/class.Session.php';
Session::init();
require_once 'inc/class.PDOTrombi.php';
$_GLOBAL['titre'] = "Trombi";
include 'vues/v_entete.php';
// constantes 
define("EOL", "<br />\n"); // fin de ligne html et saut de ligne
define("EL", "\n"); //  saut de ligne 
// instanciation du modèle PDO
$pdo = PDOTrombi::getPdoTrombi();
$tabJour = array("lundi ", "mardi ", "mercredi ", "jeudi ", "vendredi ");
$tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
$_SESSION['debug'] = "hidden";

// TODO effacer le mode debug
//$_SESSION['debug']="text";
// instanciation de la fabrique de vue
//$vue = FabriqueVue::getFabrique();
//print_r ($_REQUEST);

function clean($texte) {
    return (htmlspecialchars(trim($texte)));
}

function cleanaff($texte) {//utf8_decode
    return stripslashes(htmlspecialchars(trim($texte)));
}

/*
 * déconnecte l'utilisateur et redirige le traitement sur la page menu
 */
function logout() {
    Session::logout();
    unset($_SESSION['pseudo']);
    $_SESSION['debug'] = "hidden";
    unset($_SESSION['tsDerniereCx']);
    unset($_SESSION['numUtil']);
    header('Location: index.php?uc=lecture&num=actuelle');
}

/*
 * Renvoie le mot $mot au pluriel s'il y a lieu de l'être
 */
function pluriel($n, $mot) {
    if ($n > 1) {
        return $mot . 's';
    }
    return $mot;
}


/*
 * renvoie la date $d au format jj mois-en-toutes-lettres aaaa en français
 * $d peut être de format string ou DateTime
 */
function dateFrancais($d) {
    if (get_class($d) !== "DateTime") {
        $uneDate = new DateTime($d);
    } else {
        $uneDate = $d;
    }
    $tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
    return $uneDate->format(" d ") . $tabMois[$uneDate->format("m") - 1] . $uneDate->format(" Y ");
}
