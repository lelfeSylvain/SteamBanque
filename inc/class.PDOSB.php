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
    private static $serveur='mysql:host=localhost';
    private static $bdd= 'dbname=sylvain'  ;
    private static $user = 'sylvain' ;
    private static $mdp= 'sylvain' ;
    // préfixe de toutes les tables
    public static $prefixe ="SB_";
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
        echo 'après le new PDO';
        self::$monPdo->query("SET CHARACTER SET utf8");
        echo 'efefe';
        // initialise le fichier log
        $this->monLog = new MakeLog("erreurSQL", "./log/", MakeLog::APPEND);
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
        echo 'toto';
        if (self::$moi === null) {
                        echo 'dans le if';
            
            self::$moi = new PDOSB();
            echo 'après';
        }
        echo 'titi';
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
     * @param type $name : pseudo de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    public function getInfoUtil($name) {
        //$sql="select num, pseudo,  mdp,  tsDerniereCx from ".PdoSB::$prefixe."user where pseudo='".$name."'";
        $sql = "select num, pseudo,  mdp,  tsDerniereCx from " . self::$prefixe . "user where pseudo= ?";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($name));
        $this->logSQL($sql);
        //$rs = PdoSB::$monPdo->query($sql);

        $ligne = $sth->fetch();
        return $ligne;
    }

    /** met à jour la dernière connexion/activité d'un utilisateur
     * 
     * @param type $num : id de l'utilisateur
     */
    public function setDerniereCx($num) {
        $date = new DateTime();
        //$sql="update ".PdoSB::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $sql = "update " . self::$prefixe . "util set tsDerniereCx = ? where num= ?";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($date->format('Y-m-d H:i:s'), $num));
        $this->logSQL($sql);
        //$rs =  PdoSB::$monPdo->exec($sql);
    }

    /** insère un nouvel utilisateur dans la base
     * 
     */
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    public function setNouveauUtil($pseudo, $mdp) {
        $sql = "insert into " . self::$prefixe . "util (pseudo, mdp) values ('" . $pseudo . "','" . $mdp . "')";
        $this->logSQL($sql);
        $sql = "insert into " . self::$prefixe . "util (pseudo, mdp) values (?,?)";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp));
        return $sth;
    }

   
    /*
     * récupère le nombre de connexion pour le jour en cours
     */

    public function getNbConnexionDuJour() {
        $jour = new DateTime();
        $sql = "SELECT nb FROM " . self::$prefixe . "log WHERE jour='" . $jour->format('Y-m-d') . "'";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result['nb'];
    }

    /*
     * Ajoute une journée dans les logs de la BD
     */

    public function setPremiereConnexion() {
        $jour = new DateTime();
        $sql = "INSERT INTO " . self::$prefixe . "log (jour,nb) VALUES ('" . $jour->format('Y-m-d') . "', '0')";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * compte le nombre d'IP $ip présent dans les logs (en principe 1 ou 0)
     */

    public function getNbIP($ip) {
        $sql = "SELECT COUNT(*) AS nb FROM " . self::$prefixe . "connexions WHERE ip='" . $ip . "'";
        $this->logSQL($sql);
        $sql = "SELECT COUNT(*) AS nb FROM " . self::$prefixe . "connexions WHERE ip=?";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($ip));
        $result = $sth->fetch();
        $this->logSQL($result['nb']);
        return $result['nb'];
    }

    /*
     * ajoute une nouvelle IP dans la table connexions
     */

    public function setNlleIP($ip) {
        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
        } else {
            $user = "";
        }
        $sql = "INSERT INTO " . self::$prefixe . "connexions (ip,time,pseudo) VALUES ('" . $ip . "', " . time() . ",'" . $user . "')";
        $this->logSQL($sql);
        $sql = "INSERT INTO " . self::$prefixe . "connexions (ip,time,pseudo) VALUES (?,?,?)";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($ip, time(), $user));
        return $sth;
    }

    /*
     * incrémente le nombre de log dans la table log pour aujourd'hui
     */

    public function incLog() {
        $jour = new DateTime();
        $sql = "UPDATE " . self::$prefixe . "log SET nb=nb+1 WHERE jour='" . $jour->format('Y-m-d') . "'";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * on met à jour le timestamp de l'IP
     */

    public function updateIP($ip) {
        $sql = "UPDATE " . self::$prefixe . "connexions SET time=" . time() . " WHERE ip='" . $ip . "'";
        $this->logSQL($sql);
        $sql = "UPDATE " . self::$prefixe . "connexions SET time=? WHERE ip=?";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array(time(), $ip));
        return $sth;
    }

    /*
     * efface les connexions plus vieille de 5 min de la table connexions
     */

    public function delOldTS() {
        $timestamp_5min = time() - 300; // 60 * 5 = nombre de secondes écoulées en 5 minutes
        $sql = "DELETE FROM " . self::$prefixe . "connexions WHERE time < " . $timestamp_5min;
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * renvoie le nombre de visiteurs actuellement connectés
     */

    public function getNbVisiteur() {
        $jour = new DateTime();
        $sql = "SELECT count(*) as nb FROM " . self::$prefixe . "connexions";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result['nb'];
    }

    /*
     * Renvoie la liste des pseudos connectés en ce moment.
     *       */

    public function getLesPseudosConnectes() {
        $sql = "SELECT pseudo  FROM " . self::$prefixe . "connexions ";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function getMaxConnexion() {
        $sql = "SELECT max(nb) as nbmax FROM " . self::$prefixe . "log ";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result["nbmax"];
    }
    
    public function getJourConnexion($jour){
        $sql = "SELECT jour FROM " . self::$prefixe . "log WHERE nb = ? order by 1 desc ";
        $this->logSQL($sql);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($jour));
        $result = $sth->fetch();
        return $result["jour"];
    }
    
     /*
      * Formulaire de changement de mot de passe
     * Vérifie que l'e'ancien mot de passe saisi est le bon
     */

    public function verifierAncienMdP($pseudo,$mdp) {
        $sql = "SELECT count(*) as nb FROM " . self::$prefixe . "user where pseudo= ? and mdp=?";
        $this->logSQL($sql." ".$pseudo." ".$mdp);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo,$mdp));
        $result = $sth->fetch();
        $this->logSQL($result['nb']);
        return $result['nb'];
    }
    
    /*
     * Formulaire de changement de mot de passe
     * modifie le mot de passe
     */

    public function setMdP($pseudo,$mdp,$ancien) {
        //$jour = new DateTime();
        $sql = "UPDATE " . self::$prefixe . "user set mdp= ? where pseudo= ? and mdp=?";
        $this->logSQL($sql.$pseudo." ".$mdp);
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($mdp,$pseudo,$ancien));
        $result = $sth->fetch();
        return $result;
    }
    
}
