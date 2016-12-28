<?php
$texteNav="";
if ($num === 'in') {// on se connecte
    $login = "";
    $mdp = "";
    $monFiltrePost = array( 'login'=> FILTER_SANITIZE_STRING, 'reponse'=> FILTER_SANITIZE_STRING,'password'=> FILTER_SANITIZE_STRING);
    $monPost = filter_input_array(INPUT_POST,$monFiltrePost);
    //var_dump($monPost);
    if ($monPost !== null && $monPost['login'] !== false && $monPost['password'] !== false) {
    
        $login = $monPost['login'];
        $mdp =  $monPost['reponse'];
        
        
        if ($rep = $pdo->getInfoUtil($login)) {// si j'ai une réponse du modèle
            //echo "********************** ".$rep['id'].", ". $rep['mdp'].EOL;
            //echo "********************** ".$login.", ". $mdp.EOL;
            if (Session::login($login, $mdp, $rep['id'], $rep['mdp'])) {
                $_SESSION['pseudo'] = $rep['prenom']." ".$rep['nom'];
                if ($login === "debug") $_SESSION['debug'] = "text" ;
                $_SESSION['tsDerniereCx'] = $rep['tsDerniereCx'];
                $_SESSION['id'] = $rep['id'];
                $texteNav="Vous êtes connecté.".EOL;
                $pdo->setDerniereCx($rep['id']);
                header('Location: index.php?uc=lecture&num=actuelle');
            } else {// mauvais mot de passe ?
                $texteNav= "Connexion refusée".EOL;
            }
        } else {// utilisateur inconnu
                $texteNav=  "Connexion refusée".EOL;
            }
    } else {
        // première connexion
    }
}
else /*($num === 'out')*/ {
    logout();
    $texteNav="Vous n'êtes pas connecté.".EOL;
} 
include('vues/v_login.php');
