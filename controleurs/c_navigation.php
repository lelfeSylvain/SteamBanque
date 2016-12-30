<?php
/* ********** navigation en pied de page ******* */
$texteNav = "";
if (Session::isLogged()) {
    $texteNav = "<a href='index.php?uc=changerMdP&num=in' >Changer le mot de passe</a> - ";
    $texteNav .= "<a href='index.php?uc=defaut&num=actuelle' >Retourner à l'accueil</a> - ";
    $texteNav .= "<a href='index.php?uc=login&num=out'>Déconnexion</a> \n";
} else {// non loggé : on propose de se connecter
    $texteNav = "<a href='index.php?uc=login&num=in'>Connexion</a> \n ";
}
/* ********** fin navigation en pied de page ******* */
include("vues/v_pied.php");
