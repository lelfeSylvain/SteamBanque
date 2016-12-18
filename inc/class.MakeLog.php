<?php

/**
 * Outil pour logger facilement des informations
 *
 * @author sylvain
 */
class MakeLog {
    private $filename;
    private $path;
    private $fullname;
    private $mode;
    private $msgErreur;
    private $CRLF="\r\n";
    private $format="Y-m-d H:i:s ";
    const APPEND = "a";
    const WRITE = "w";
/**
 * Constructeur 
 * un fichier log ouvert en mode "a" cumule les messages d'une éxécution sur l'autre
 * en mode "w" initialise à vide le fichier à chaque exécution
 * @param $name : le nom du fichier sans le suffixe .log qui sera ajouter
 * @param $path : le chemin du fichier si différent de "./" 
 * @param $mode : par défaut en mode 'a'ppend, peut être en mode re'w'rite
 * @param $msgErreur : affiche un préfixe au log pour distinguer la ligne en cas d'erreur
 */				
    public function __construct($name,$path="./log/",$mode="a",$msgErreur="### ERREUR"){
	$this->filename=$name;
        if (substr($path,-1)==='/') $this->path = $path;
        else $this->path = $path.'/';
        $this->fullname=$this->path.$this->filename.'.log';
        $this->mode=$mode;
        $this->msgErreur=$msgErreur;
        // initialise le fichier log
        fopen($this->fullname,  $this->mode); 
        chmod($this->fullname, 0777);
        
    }
    // destructeur
    public function __destruct(){
            
    }
    
    /**
     * ajoute une entrée dans le fichier log
     * 
     * @param type $message : message à enregistrer
     * @param type $estErreur : affiche le message '### ERREUR' si vrai
     */
	
    function ajouterLog($message, $estErreur=false){
        
        $date = new DateTime();
        $msg = $date->format($this->format);
        if ($estErreur) {// message en erreur
                $msg .=$this->msgErreur;
        }
        $msg .= $message;
        // on ouvre, écrit et on ferme
        $fp = fopen($this->fullname, 'a');
        $nouverr=$msg.$this->CRLF;
        fputs($fp,$nouverr);
        fclose($fp); 
        
    }
    
}
