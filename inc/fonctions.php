<?php

require_once 'inc/class.Session.php';
Session::init();
require_once 'inc/class.PDOSB.php';
$_GLOBAL['titre'] = "Steam-Banque";
include 'vues/v_entete.php';
// constantes 
define("EOL", "<br />\n"); // fin de ligne html et saut de ligne
define("EL", "\n"); //  saut de ligne 
// instanciation du modèle PDO
$pdo = PDOSB::getPdoSB();
$tabJour = array("lundi ", "mardi ", "mercredi ", "jeudi ", "vendredi ");
$tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
$_SESSION['debug'] = "hidden";
$_SESSION['symbole'] = $pdo->getValDefaut("symboleMonnaie");
$_SESSION['monnaie'] = $pdo->getValDefaut("libelleDeLaMonnaie");
$_SESSION['fictif']  = $pdo->getValDefaut("clientTiersFictif");


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
