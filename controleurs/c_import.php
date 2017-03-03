<?php

function importerUnFichierCSV($fileName, $idFichier,$dossier,$d) {
    $ilyaerreur = false;
    
    /* script upload d'après http://antoine-herault.developpez.com/tutoriels/php/upload/ */
    $fichier = basename($fileName);
    $extension = strrchr($fileName, '.');
    $extensions = ['.txt', '.csv', '.text']; // création de tableaux nouvelle syntaxe
    $erreur = "Vous devez uploader un fichier de type txt, csv ou text.";
    if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau  
        $ilyaerreur = true;
    }
    if (!tailleOk(filesize($idFichier))) {
        $erreur = "Le fichier est trop gros.";
        $ilyaerreur = true;
    }
    $rep = creerDossier($dossier);
    if (is_string($rep)) {
        $erreur = $rep;
        $ilyaerreur = true;
    }
    
    if (!$ilyaerreur) { //S'il n'y a pas d'erreur, on uploade
        if (move_uploaded_file($idFichier, $dossier . "/" . $d)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            $message = "Fichier : " . $fichier . " : Upload effectué avec succès ! Nouveau nom : " . $dossier . "/" . $d;
        } else { //Sinon (la fonction renvoie FALSE).
            $message = "Fichier : " . $fichier . " : Echec de l'upload !";
        }
    } else {
        $message = "Le téléchargement s'est mal passé car : " . $erreur;
    }
    return $message;
}

// paramètres 
$message = "";
$dest = "csv";
$delimiteurCSV=';'; // TODO demander à l'utilisateur quel délimiteur est utilisé 
$estEnISO8859 = false; // TODO vérifier que le fichier est en iso8859

if ('in' === $num) {
    // pas d'enregistrement dans la BD donc dernier paramètre à false
    $dossier = $DOSSIERUPLOAD .  "/csv";
    $nomCSV = date("Ymd") . ".txt";
    $message = importerUnFichierCSV($_FILES['mesFichiers']['name'], $_FILES['mesFichiers']['tmp_name'],$dossier,$nomCSV).EOL;
    
    /* lecture du fichier csv */
    $nbligne = 0;
    $handle = @fopen($dossier.'/'.$nomCSV, "r");
    if ($handle) {
        // entêtes de colonne
    
        if (($buffer = fgetCSV($handle, 4096,$delimiteurCSV)) !== false) {
            $nbCol=count($buffer);
            if ($nbCol>4) {
                $message .= "Le fichier comporte trop de colonnes (max = 4)".EOL;
            }
        }
        // autres lignes
        while (($buffer = fgetCSV($handle, 4096,$delimiteurCSV)) !== false) {
            $numCli=iso2utf8($buffer[0], $estEnISO8859);
            $prenomCli=iso2utf8($buffer[1], $estEnISO8859);
            $nomCli=iso2utf8($buffer[2], $estEnISO8859);
            $mdp=md5($GLOBALS['grainDeSel'].iso2utf8($buffer[3], $estEnISO8859));
            //list($nomEle, $prenomEle, $classeEle) = explode($delimiteurCSV, iso2utf8($buffer, $estEnISO8859));
            $message .=  $numCli.' '.$prenomCli.' '. $nomCli.EOL;
            $pdo->creerUnUtilisateurCompletement(array('id'=>$numCli,'prenom'=>$prenomCli,'nom'=>$nomCli,'nouveau'=>$mdp),0);
            
            $nbligne++;
        }
        if (!feof($handle)) {
            $message .= "Erreur: fgets() a échoué" . EOL;
        }
        fclose($handle);
        $message .= $nbligne . " lignes importées";
    }
} 
$textNav = $message;

include('controleurs/c_accueil.php');
