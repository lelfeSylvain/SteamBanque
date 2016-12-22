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
        if (self::$moi === null) {
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
        $this->logSQL($sql.' ('.$name.')');
        $ligne = $sth->fetch();
        return $ligne;
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
        $this->logSQL($sql.' ('.$num.')');
    }

    /** insère un nouvel utilisateur dans la base
     * 
     */
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    public function setNouveauUtil($pseudo, $mdp) {
        $sql = "insert into " . self::$prefixe . "Client (id, mdp) values ('" . $pseudo . "','" . $mdp . "')";
        $this->logSQL($sql);
        $sql = "insert into " . self::$prefixe . "Client (id, mdp) values (?,?)";
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp));
        return $sth;
    }

   
    
    
     /*
      * Formulaire de changement de mot de passe
     * Vérifie que l'e'ancien mot de passe saisi est le bon
     */

    public function verifierAncienMdP($pseudo,$mdp) {
        $sql = "SELECT count(*) as nb FROM " . self::$prefixe . "Client where id= ? and mdp=?";
        $this->logSQL($sql." (".$pseudo.", ".$mdp.")");
        $sth = self::$monPdo->prepare($sql);
        $sth->execute(array($pseudo,$mdp));
        $result = $sth->fetch();
        $this->logSQL("===> ".$result['nb']);
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
