<?php
$texteNav="";
if ($num === 'in') {// on se connecte
    $login = "";
    $mdp = "";
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $mdp = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_STRING);
        $pdo = PDOSB::getPdoSB();
        
        if ($rep = $pdo->getInfoUtil($login)) {// si j'ai une réponse du modèle
            echo "********************** ".$rep['id'].", ". $rep['mdp'].EOL;
            echo "********************** ".$login.", ". $mdp.EOL;
            if (Session::login($login, $mdp, $rep['id'], $rep['mdp'])) {
                $_SESSION['pseudo'] = $rep['prenom']." ".$rep['nom'];
                echo "********************** ".$_SESSION['pseudo'].EOL;
                if ($login === "debug") $_SESSION['debug'] = "text" ;
                $_SESSION['tsDerniereCx'] = $rep['tsDerniereCx'];
                $_SESSION['numUtil'] = $rep['id'];
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
