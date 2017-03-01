<?php
//var_dump($_POST);
// impossible de filtrer un tableau simple ???
//$mesPost = filter_input_array(INPUT_POST, array('choix' => array ('filter' =>  FILTER_SANITIZE_STRING)));

//if (null !== $mesPost) {
if (!empty($_POST['choix'] )){
   $pdo->effacerLesClients($_POST['choix'] );
}
include ('controleurs/c_accueil.php');