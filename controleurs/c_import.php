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

$tailleMaxi = 100000; // On limite le fichier à 100Ko 
$message = "";
$dest = "csv";
$delimiteurCSV=';'; // TODO demander à l'utilisateur quel délimiteur est utilisé 
$estEnISO8859 = false; // TODO vérifier que le fichier est en iso8859

if ('1' === $num) {
    // pas d'enregistrement dans la BD donc dernier paramètre à false
    $dossier = $DOSSIERUPLOAD . dec2hex($_SESSION['nc']) . "/csv";
    $nomCSV = date("Ymd") . ".txt";
    $message = importerUnFichierCSV($_FILES['mesFichiers']['name'], $_FILES['mesFichiers']['tmp_name'],$dossier,$nomCSV);
    $options = array(
        'default' => getYear(), // valeur à retourner si le filtre échoue
        // autres options ici...
        'min_range' => getYear(-10),
        'max_range' => getYear(10)
    );
    $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT, $options);
    $message .= EOL . "année : " . $annee . EOL;
    /* lecture du fichier csv */
    $nbligne = 0;
    $handle = @fopen($dossier.'/'.$nomCSV, "r");
    if ($handle) {
        // entêtes de colonne
    
        if (($buffer = fgetCSV($handle, 4096,$delimiteurCSV)) !== false) {
            $nbCol=count($buffer);
            if ($nbCol>3) {// attention le tableau $colonneSup commence à 3 d'indice
                for($i=3;$i<$nbCol;$i++){                    
                    $colonneSup[$i]=$pdo->addPropriete($_SESSION['nt'],$buffer[$i]);
                    $message .='Ajout de la proprieté : '.$buffer[$i].EOL;
                }
            }
        }
        // autres lignes
        while (($buffer = fgetCSV($handle, 4096,$delimiteurCSV)) !== false) {
            $nomEle=iso2utf8($buffer[0], $estEnISO8859);
            $prenomEle=iso2utf8($buffer[1], $estEnISO8859);
            $classeEle=iso2utf8($buffer[2], $estEnISO8859);
            //list($nomEle, $prenomEle, $classeEle) = explode($delimiteurCSV, iso2utf8($buffer, $estEnISO8859));
            $message .=  $nomEle.' '.$prenomEle.' '. $classeEle.EOL;
            $numClasse = $pdo->setClasseIfNotExist($classeEle, $_SESSION['nt']);
            $numEleve = $pdo->setEleveIfNotExist($nomEle, $prenomEle, $numClasse);
            for($i=3;$i<$nbCol;$i++){
                $pdo->setValeurPropriete($numEleve,$colonneSup[$i],$buffer[$i]);
            }
            $nbligne++;
        }
        if (!feof($handle)) {
            $message .= "Erreur: fgets() a échoué" . EOL;
        }
        fclose($handle);
        $message .= $nbligne . " lignes importées";
    }
} /* elseif ('Multi1' === $num) {// tout un sous-répertoire
  //$message = "Traitement non implémenté";
  foreach ($_FILES["mesFichiers"]["error"] as $key => $error) {
  if (UPLOAD_ERR_OK == $error) {
  $message .= importerUnFichier($_FILES['mesFichiers']['name'][$key], $_FILES['mesFichiers']['tmp_name'][$key], $dossier, $dest, $numEleve).EOL;
  }
  }
  } */
include('vues/v_import.php');
