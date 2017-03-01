<?php

include_once 'inc/class.MakeLog.php';

/**
 * Modèle du projet : permet d'accéder aux données de la BD
 * La classe est munie d'un outil pour logger les requêtes
 *
 * @author sylvain
 * @date janvier-février 2016
 */
class PDOSB {

    // paramètres d'accès au SGBD
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=sylvain';
    private static $user = 'sylvain';
    private static $mdp = 'sylvain';
    // préfixe de toutes les tables
    public static $prefixe = "SB_";
    // classe technique permettant d'accéder au SGBD
    private static $monPdo;
    // pointeur sur moi-même (pattern singleton)
    private static $moi = null;
    // active l'enregistrement des logs
    private $modeDebug = true;
    private $monLog;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {

        self::$monPdo = new PDO(self::$serveur . ';' . self::$bdd, self::$user, self::$mdp);
        self::$monPdo->query("SET CHARACTER SET utf8");
        // initialise le fichier log
        $this->monLog = new MakeLog("erreurSQL", "./log/", MakeLog::WRITE);
    }

    public function __destruct() {
        self::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoSB = PdoSB::getPdoSB();
     * @return l'unique objet de la classe PdoSB
     */
    public static function getPdoSB() {
        if (null === self::$moi) {
            self::$moi = new PDOSB();
        }
        return self::$moi;
    }

    // enregistre la dernière requête faite dans un fichier log
    private function logSQL($sql) {
        if ($this->modeDebug) {
            $this->monLog->ajouterLog($sql);
        }
    }

    /** renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
     * 
     * @param type $name : identifiant de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    public function getInfoUtil($name) {
        $sql = "select * from " . self::$prefixe . "Client  where id= ?";

        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($name));
        $this->logSQL($sql . ' (' . $name . ')');
        $ligne = $sth->fetch();
        return $ligne;
    }

    /** renvoie les id, nom et prenom de tous les clients
     * 
     * @param type $name : identifiant de l'utilisateur
     * @return id, nom et prenom de tous les clients
     */
    public function getLesClients($idSU = null) {
        if (null === $idSU) {
            $sql = "select id, nom ,prenom from " . self::$prefixe . "Client order by 2, 3 ";
        } else {
            $sql = "select id, nom ,prenom from " . self::$prefixe . "Client where id <> ? order by 2, 3 ";
        }
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idSU));
        $this->logSQL($sql);
        $ligne = $sth->fetchAll();
        return $ligne;
    }

    /** renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
     * 
     * @param type $name : identifiant de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    public function isSuperUser($name) {
        $sql = "select count(*) as nb from " . self::$prefixe . "Client  where id= ? and superUser=1";

        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($name));
        $this->logSQL($sql . ' (' . $name . ')');
        $ligne = $sth->fetch();
        if ($ligne['nb'] == 1) {
            return true;
        }
        return false;
    }

    /** met à jour la dernière connexion/activité d'un utilisateur
     * 
     * @param type $num : id de l'utilisateur
     */
    public function setDerniereCx($num) {
        $date = new DateTime();
        $sql = "update " . self::$prefixe . "Client set tsDerniereCx = ? where id= ?";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($date->format('Y-m-d H:i:s'), $num));
        $this->logSQL($sql . ' (' . $num . ')');
    }

    /** insère un nouvel utilisateur dans la base
     * par défaut ce n'est pas un super user
     */
    public function setNouveauUtil($pseudo, $mdp, $prenom, $nom, $estSU = 0) {
        $valDecouvert = $this->getValDefaut("decouvertAutoriseDefaut");
        if (1 === $estSU) {
            $sql = "insert into " . self::$prefixe . "Client (id, mdp, prenom, nom,superUser, maxDecouvert) values (?,?,?,?,1,?)";
        } else {
            $sql = "insert into " . self::$prefixe . "Client (id, mdp, prenom, nom, maxDecouvert) values (?,?,?,?,?)";
        }
        $this->logSQL($sql . " (" . $pseudo . ", " . $mdp . ", " . $prenom . ", " . $nom . ", " . $valDecouvert . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp, $prenom, $nom, $valDecouvert));
        return $sth;
    }

    /** modifie un utilisateur dans la base
     * par défaut ce n'est pas un super user
     */
    public function updateUtil($pseudo, $prenom, $nom, $estSU = 0) {
        if (1 === $estSU) {
            $sql = "update " . self::$prefixe . "Client set prenom = ?, nom= ?, superUser= 1 where id= ?";
        } else {
            $sql = "update " . self::$prefixe . "Client set prenom = ?, nom= ? where id= ?";
        }
        $this->logSQL($sql . " (" . $prenom . ", " . $nom . ", " . $pseudo . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($prenom, $nom, $pseudo));
        return $sth;
    }

    /*
     * Formulaire de changement de mot de passe
     * Vérifie que l'ancien mot de passe saisi est le bon
     */

    public function verifierAncienMdP($pseudo, $mdp) {
        $sql = "SELECT count(*) as nb FROM " . self::$prefixe . "Client where id= ? and mdp=?";
        $this->logSQL($sql . " (" . $pseudo . ", " . $mdp . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp));
        $result = $sth->fetch();
        $this->logSQL("===> " . $result['nb']);
        return $result['nb'];
    }

    /*
     * Formulaire de changement de mot de passe
     * modifie le mot de passe
     */

    public function setMdP($pseudo, $mdp, $ancien = null) {
        if (null === $ancien) {
            $sql = "UPDATE " . self::$prefixe . "Client set mdp= ? where id= ?";
            $parametres = array($mdp, $pseudo);
        } else {
            $sql = "UPDATE " . self::$prefixe . "Client set mdp= ? where id= ? and mdp=?";
            $parametres = array($mdp, $pseudo, $ancien);
        }
        $this->logSQL($sql . " (" . $mdp . ", " . $pseudo . ", " . $ancien . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute($parametres);
        return $sth;
    }

    /*
     * Formulaire de modification des paramètres des clients
     * récupère les paramètres
     */

    public function getParam() {
        $sql = "SELECT * FROM " . self::$prefixe . "Param order by rubrique, id";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array(null));
        $result = $sth->fetchAll();
        return $result;
    }

    /*
     * Formulaire de modification des paramètres des clients
     * modifie les paramètres
     */

    public function modifierLesParam($tab) {
        foreach ($tab as $key => $value) {
            $this->modifierParam($key, $value);
        }
    }

    /*
     * Formulaire de modification des paramètres des clients
     * modification d'un couple (key, value)
     */

    public function modifierParam($key, $value) {
        $sql = "UPDATE " . self::$prefixe . "Param set valeur=? where id=?";
        $this->logSQL($sql . "(" . $value . ", " . $key . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($value, $key));
        return $sth;
    }

    /*
     * Formulaire de création de nouveaux clients
     * Renvoie la valeur par défaut (cf. table param) d'un paramètre 
     */

    public function getValDefaut($idParam) {

        $sql = "SELECT valeur FROM " . self::$prefixe . "Param where `id`=?";
        $this->logSQL($sql . "(" . $idParam . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idParam));
        $ligne = $sth->fetch();
        return $ligne['valeur'];
    }

    /*
     * Formulaire de création de nouveaux clients
     * Initialisation d'un compte client 
     */

    public function initialiserCompteClient($idCli) {
        $montant = $this->getValDefaut("valInitialeCompteClient");
        $idTiers = $this->getValDefaut("clientTiersFictif");
        return $this->mouvementCompteClient($idCli, $montant, $idTiers, 0);
    }

    /*
     * Formulaire de création de nouveaux clients
     * Passer un mouvement entre compte
     */

    public function mouvementCompteClient($idCli, $montant, $idTiers, $numMouvement = null) {
        if (null === $numMouvement) {
            $numMouvement = $this->getProchainNumMouvement($idCli, $idCompte);
        }
        $sql = "insert into " . self::$prefixe . "Mouvement (idCli, num,montant,idTiers) value (?,?,?,?)";
        $this->logSQL($sql . "(" . $idCli . ", "  . $numMouvement . ", " . $montant . ", " . $idTiers  . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli,  $numMouvement, $montant, $idTiers));

        return $sth;
    }

    /*
     * Formulaire de création de nouveaux clients
     * Renvoie le prochain numéro du mouvement pour le compte ciblé
     */

    public function getProchainNumMouvement($idCli) {

        $sql = "SELECT max(num)+1 as n FROM " . self::$prefixe . "Mouvement where `idCli`=? ";
        $this->logSQL($sql . "(" . $idCli . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetch();
        if (null === $ligne['n'])
            $ligne['n'] = 0;
        return $ligne['n'];
    }

    /*
     * Formulaire de visualisation des  clients
     * Renvoie les nb dernières opérations du compte ciblé
     * NB renvoie les opérations triées à rebours
     */

    public function getDernieresOperationsDuClient($idCli, $nb = null) {
        if (null === $nb) {
            $nb = $this->getValDefaut("nbLigneAffiche");
        }
        $sql = "SELECT * FROM " . self::$prefixe . "Mouvement where `idCli`=? order by ts desc limit " . $nb;
        $this->logSQL($sql . "(" . $idCli . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetchAll();
        return $ligne;
    }

    /*
     * Formulaire de visualisation du SU
     * Renvoie les nb dernières opérations vers le compte ciblé
     * NB renvoie les opérations triées à rebours
     */

    public function getDernieresOperationsVersClient($idCli, $nb = null) {
        if (null === $nb) {
            $nb = $this->getValDefaut("nbLigneAffiche");
        }
        $sql = "SELECT * FROM " . self::$prefixe . "Mouvement where `idTiers`=? and  order by ts desc limit " . $nb;
        $this->logSQL($sql . "(" . $idCli .  ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetchAll();
        return $ligne;
    }

    /*
     * Formulaire de visualisation du SU
     * Renvoie les nb dernières opérations 
     * NB renvoie les opérations triées à rebours
     */

    public function getLesDernieresOperations($resultat, $nb = null) {
        if (null === $nb) {
            $nb = $this->getValDefaut("nbLigneAfficheAdmin");
        }
        $injection = array();
        if (null != $resultat["numCpt"]) { // on filtre sur le n° compte
            $tri = "where idCli = ? order by ts desc";
            $injection = array($resultat["numCpt"]);
            $this->logSQL($resultat["numCpt"]);
        } else if (null != $resultat["numCptTiers"]) {  // on filtre sur le n° compte tier
            $tri = "where idTiers = ? order by ts desc";
            $injection = array($resultat["numCptTiers"]);
            $this->logSQL($resultat["numCptTiers"]);
        } else  // on filtre sur le filtre choisi
            switch ($resultat["trier"]) {
                case 0: $tri = "order by ts desc";
                    break;
                case 1: $tri = "order by idCli ,ts desc";
                    break;
                case 2: $tri = "where montant <=0 order by ts desc";
                    break;
                case 3: $tri = "where montant >=0 order by ts desc";
                    break;
                case 4: $tri = "order by idTiers, ts";
                    break;
                case 5: $tri = "order by montant desc,ts desc";
                    break;
            }
        $sql = "SELECT * FROM " . self::$prefixe . "Mouvement   " . $tri . "  limit " . $nb;
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute($injection);
        $ligne = $sth->fetchAll();
        return $ligne;
    }

    /*
     * Formulaire de visualisation des  clients
     * Renvoie le solde du compte ciblé
     */

    public function getSolde($idCli) {
        $sql = "SELECT sum(montant) as solde FROM " . self::$prefixe . "Mouvement where `idCli`=? ";
        $this->logSQL($sql . "(" . $idCli .")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetch();
        return $ligne['solde'];
    }

    /*
     * Formulaire de visualisation des  clients
     * Renvoie le solde du compte ciblé
     */

    public function getLesSoldes() {
        $sql = "SELECT idCli, concat(C.prenom,' ',C.nom) as nomprenom,sum(montant) as solde FROM " . self::$prefixe . "Mouvement M, " . self::$prefixe . "Client C where C.id=idCli group by idCli, nomprenom";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array());
        return $sth->fetchAll();
    }

    /*
     * Formulaire de visualisation des  clients
     * Renvoie la valeur de l'autorisation de découvert du compte ciblé
     */

    public function getDecouvert($idCli) {
        $sql = "SELECT maxDecouvert FROM " . self::$prefixe . "Client where `idCli`=? ";
        $this->logSQL($sql . "(" . $idCli . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetch();
        return $ligne['maxDecouvert'];
    }

    /*
     * Formulaire de visualisation des  clients
     * Renvoie 1 si le compte ciblé existe
     */

    public function existe($idCli, $idCompte) {
        $sql = "SELECT count(*) as nb FROM " . self::$prefixe . "Client where `idCli`=? ";
        $this->logSQL($sql . "(" . $idCli . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($idCli));
        $ligne = $sth->fetch();
        return $ligne['nb'];
    }

    public function creerUnUtilisateurCompletement($mesPost, $estSu) {
        // on filtre la case à cocher
        if ($estSu) {
            $enregistrementOK = $this->setNouveauUtil($mesPost['id'], $mesPost['nouveau'], $mesPost['prenom'], $mesPost['nom'], 1);
        } else {
            $enregistrementOK = $this->setNouveauUtil($mesPost['id'], $mesPost['nouveau'], $mesPost['prenom'], $mesPost['nom']);
        }

        // 
        // $mesPost est un tableau associatif contenant les nouvelles valeurs filtrées
        if ($enregistrementOK !== null) { // on reporte ces modifications dans la BD
            $numCompte = $this->creerCompteClient($mesPost['id']);
            $res = $this->initialiserCompteClient($mesPost['id']);
            $textNav = "Nouveau client " . $mesPost['id'] . " créé.";
        } else {
            $textNav = "Problème avec la BD dans l'enregistrement du nouveau client. Le compte n'a pas été créé";
        }
        return $textNav;
    }

    public function effacerUnClient($num) {
        $sql = "DELETE FROM " . self::$prefixe . "Client where `idCli`=? ";
        $this->logSQL($sql . "(" . $num . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($num));
        return $sth;
    }

    public function effacerTousLesMouvementsDUnClient($num) {
        $sql = "DELETE FROM " . self::$prefixe . "Mouvement where `idCli`=? or idTiers = ?";
        $this->logSQL($sql . "(" . $num . ")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($num, $num));
        return $sth;
    }

    public function effacerCompletementUnClient($num) {
        return $this->effacerTousLesMouvementsDUnClient($num) and $this->effacerUnClient($num);
    }

    public function effacerLesClients($lesClient) {
        foreach ($lesClient as $value) {
            $this->effacerCompletementUnClient($value);
        }
    }

}
