<?php
if (! isset($_SESSION['username'])) {
    $_SESSION['username'] = "visitor";
}


// ETAPE 0 : on récupère le nombre de connexion du jour
$nb_cx = $pdo->getNbConnexionDuJour();

if ($nb_cx === NULL) {// si il n'y en a pas on insère un enregistrement pour ce jour
    $r = $pdo->setPremiereConnexion();
}
// -------
// ETAPE 1 : on vérifie si l'IP se trouve déjà  dans la table
// Pour faire ça, on n'a qu'à  compter le nombre d'entrées dont le champ "ip" est l'adresse ip du visiteur
// on récupère l'IP du visiteur
$ip = $_SERVER['REMOTE_ADDR'];
$nb_ip = $pdo->getNbIP($ip);
if ($nb_ip == 0) { // L'ip ne se trouve pas dans la table, on va l'ajouter
    $r = $pdo->setNlleIP($ip);
    $r2 = $pdo->incLog();
} else { // L'ip se trouve déjà  dans la table, on met juste à  jour le timestamp
    $r = $pdo->updateIP($ip);

    /* traitement abandonné
      $sql = "SELECT pseudo FROM " . PdoMenu::$prefixe . "connexions WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
      if ($donnees = sqlexe($sql)) {
      if ($donnees['pseudo'] == NULL or $donnees['pseudo'] <> $_SESSION['user']) {
      $sql = "UPDATE " . PdoMenu::$prefixe . "connexions SET pseudo='" . $_SESSION['user'] . "' WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
      sqlexe($sql);
      }
      } */
}
// -------
// ETAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes
// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$r = $pdo->delOldTS();

// -------
// ETAPE 3 : on compte le nombre d'ip stockées dans la table. C'est le nombre de visiteurs connectés
$nb_visiteurs = $pdo->getNbVisiteur();
// On n'a plus qu'à  afficher le nombre de connectés !
$phraseNbVisiteur = " " . pluriel($nb_visiteurs, "visiteur") . " " . pluriel($nb_visiteurs, "connecté") . " ";
$phraseNbVisiteur = "<p>Il y a actuellement " . $nb_visiteurs . $phraseNbVisiteur . " : ";
// ETAPE 4 : on liste les pseudos des visiteurs connectés
if ($_SESSION['username'] !== "visitor") {
    $lesPseudos = $pdo->getLesPseudosConnectes();
    $r = "";
    foreach ($lesPseudos as $unPseudo) {
        if ($r == "") {
            $r = $unPseudo['pseudo'];
        } else {
            $r.=", " . $unPseudo['pseudo'];
        }
    }
    $nb_cx = $pdo->getNbConnexionDuJour();
    $phraseNbVisiteur.=$r . "</p><p> aujourd'hui : " . $nb_cx . " " . pluriel($nb_cx, "connexion");
    $nb_max_connexion = $pdo->getMaxConnexion();
    $jour_max = $pdo->getJourConnexion($nb_max_connexion);
    $jour_max = new DateTime($jour_max);
    $phraseNbVisiteur.=" - Il y a eu " . $nb_max_connexion . " connexions simultanées le " . dateFrancais($jour_max);
    /*
      $donnees = sqlexe("SELECT max(nb) as nbmax FROM " . PdoMenu::$prefixe . "log ");
      $r2.="</div><div>nombre max de connexion : " . $donnees['nbmax'];
      $donnees = sqlexe("SELECT jour FROM " . PdoMenu::$prefixe . "log WHERE nb = (SELECT max(nb) as nbmax FROM " . PdoMenu::$prefixe . "log)");
      $jourmax = new DateTime($donnees['jour']);
      $r2.=" le " . $jourmax->format('j/m/Y') . "</div>"; */
    //$phraseNbVisiteur.=$r;
}
$phraseNbVisiteur.="</p>";
// echo $phraseNbVisiteur;

/*
 * controleur qui gère les stats des visites, les connexions aussi
 * il est appelé pour appeler v_pied.php
 */
// ETAPE 0 : on récupère le nombre de connexion du jour
$nb_cx = $pdo->getNbConnexionDuJour();

if ($nb_cx === NULL) {// si il n'y en a pas on insère un enregistrement pour ce jour
    $r = $pdo->setPremiereConnexion();
}
// -------
// ETAPE 1 : on vérifie si l'IP se trouve déjà  dans la table
// Pour faire ça, on n'a qu'à  compter le nombre d'entrées dont le champ "ip" est l'adresse ip du visiteur
// on récupère l'IP du visiteur
$ip = $_SERVER['REMOTE_ADDR'];
$nb_ip = $pdo->getNbIP($ip);
if ($nb_ip == 0) { // L'ip ne se trouve pas dans la table, on va l'ajouter
    $r = $pdo->setNlleIP($ip);
    $r2 = $pdo->incLog();
} else { // L'ip se trouve déjà  dans la table, on met juste à  jour le timestamp
    $r = $pdo->updateIP($ip);

    /* traitement abandonné
      $sql = "SELECT pseudo FROM " . PdoMenu::$prefixe . "connexions WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
      if ($donnees = sqlexe($sql)) {
      if ($donnees['pseudo'] == NULL or $donnees['pseudo'] <> $_SESSION['user']) {
      $sql = "UPDATE " . PdoMenu::$prefixe . "connexions SET pseudo='" . $_SESSION['user'] . "' WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
      sqlexe($sql);
      }
      } */
}
// -------
// ETAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes
// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$r = $pdo->delOldTS();

// -------
// ETAPE 3 : on compte le nombre d'ip stockées dans la table. C'est le nombre de visiteurs connectés
$nb_visiteurs = $pdo->getNbVisiteur();
// On n'a plus qu'à  afficher le nombre de connectés !
$phraseNbVisiteur = " " . pluriel($nb_visiteurs, "visiteur") . " " . pluriel($nb_visiteurs, "connecté") . " ";
$phraseNbVisiteur = "<p>Il y a actuellement " . $nb_visiteurs . $phraseNbVisiteur;
// ETAPE 4 : on liste les pseudos des visiteurs connectés
if ($_SESSION['username'] !== "visitor") {
    $lesPseudos = $pdo->getLesPseudosConnectes();
    $r = "";
    foreach ($lesPseudos as $unPseudo) {
        if ($r == "") {
            $r = " : " . $unPseudo['pseudo'];
        } else {
            $r.=", " . $unPseudo['pseudo'];
        }
    }
    $nb_cx = $pdo->getNbConnexionDuJour();
    $phraseNbVisiteur.=$r . "</p><p> aujourd'hui : " . $nb_cx . " " . pluriel($nb_cx, "connexion");
    $nb_max_connexion = $pdo->getMaxConnexion();
    $jour_max = $pdo->getJourConnexion($nb_max_connexion);
    $jour_max = new DateTime($jour_max);
    $phraseNbVisiteur.=" - Il y a eu " . $nb_max_connexion . " connexions simultanées le " . dateFrancais($jour_max);
    /*
      $donnees = sqlexe("SELECT max(nb) as nbmax FROM " . PdoMenu::$prefixe . "log ");
      $r2.="</div><div>nombre max de connexion : " . $donnees['nbmax'];
      $donnees = sqlexe("SELECT jour FROM " . PdoMenu::$prefixe . "log WHERE nb = (SELECT max(nb) as nbmax FROM " . PdoMenu::$prefixe . "log)");
      $jourmax = new DateTime($donnees['jour']);
      $r2.=" le " . $jourmax->format('j/m/Y') . "</div>"; */
    //$phraseNbVisiteur.=$r;
}
$phraseNbVisiteur.="</p>";





