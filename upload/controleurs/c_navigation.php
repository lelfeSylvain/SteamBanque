<?php
/* ********** navigation en pied de page ******* */
$textNav = "";
if (Session::isLogged()) {
    $textNav = "<a href='index.php?uc=changerMdP&num=in' >Changer le mot de passe</a> - ";
    $textNav .= "<a href='index.php?uc=defaut&num=actuelle' >Retourner à l'accueil</a> - ";
    $textNav .= "<a href='index.php?uc=login&num=out'>Déconnexion</a> \n";
} else {// non loggé : on propose de se connecter
    $textNav = "<a href='index.php?uc=login&num=in'>Connexion</a> \n ";
}
/* ********** fin navigation en pied de page ******* */
include("vues/v_pied.php");
