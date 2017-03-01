<?php

require_once 'inc/class.Session.php';
Session::init();
require_once 'inc/class.PDOSB.php';

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
$_SESSION['numMinCompteClient']  = $pdo->getValDefaut("numCompteClient");
$_SESSION['maxCompteParClient']  = $pdo->getValDefaut("maxCompteParClient");
$_SESSION['fictif']  = $pdo->getValDefaut("clientTiersFictif");
$_SESSION['affichageChronologique']  = $pdo->getValDefaut("affichageChronologique");
$filtreminmax  = array($pdo->getValDefaut("longueurMini"), $pdo->getValDefaut("longueurMaxi"));

$_SESSION['regex']  = str_replace(array("%min%","%max%"), $filtreminmax, $pdo->getValDefaut("regexMDP"));
$_SESSION['commentaireRegex']  = $pdo->getValDefaut("commentaireRegex");
unset($filtreminmax);
$DOSSIERUPLOAD = 'upload/';

$GLOBALS['titre']  = $pdo->getValDefaut("TitreApplication");
$GLOBALS['tailleMaxi'] = 10000; // On limite le fichier à 100Ko 
// Affichage de l'entete à tous les pages
include 'vues/v_entete.php';

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

function tailleOk($taille) {
    return $taille <= $GLOBALS['tailleMaxi'];
}
function creerDossier($dossier) {
    $erreur = "";
    $ilyaerreur = false;
    if (!file_exists($dossier)) {// le répertoire n'existe pas : on va le créer
        if (!mkdir($dossier, 0777, true)) {// erreur de création
            $erreur = "Impossible de créer le répertoire destination.";
            $ilyaerreur = true;
        }
    } elseif (is_file($dossier)) {// un fichier porte le même nom
        $erreur = "Le répertoire de destination existe déjà, mais ce n'est pas un répertoire.";
        $ilyaerreur = true;
    }
    if ($ilyaerreur) {
        return $erreur;
    } else {
        return true;
    }
}

/*
 * retourne la chaine convertit en UTF par défaut. sinon renvoie la chaine initiale
 */

function iso2utf8($str, $isISO = true) {
    if ($isISO)
        return utf8_encode($str);
    return $str;
}