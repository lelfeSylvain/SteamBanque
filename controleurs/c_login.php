<?php
$texteNav="";
if ($num === 'in') {// on se connecte
    $login = "";
    $mdp = "";
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = clean($_POST['login']);
        $mdp = clean($_POST['reponse']);
        $pdo = PDOMenu::getPdoMenu();
        if ($rep = $pdo->getInfoUtil($login)) {// si j'ai une réponse du modèle
            if (Session::login($login, $mdp, $rep['pseudo'], $rep['mdp'])) {
                $_SESSION['pseudo'] = $rep['pseudo'];
                if ($login === "debug") $_SESSION['debug'] = "text" ;
                $_SESSION['tsDerniereCx'] = $rep['tsDerniereCx'];
                $_SESSION['numUtil'] = $rep['num'];
                $texteNav="Vous êtes connecté.".EOL;
                $pdo->setDerniereCx($rep['num']);
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
    $texteNav="Vous êtes déconnecté.".EOL;
} 
include('vues/v_login.php');
