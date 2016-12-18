<?php
// fonctions liées au téléchargement
function formaterNomFichier($fichier){
     //On formate le nom du fichier ici...
        $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        return preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
        
}



// paramètres 
$dossier = 'upload/';
$taille_maxi = 100000;
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$message='';
$ilyaerreur=false;
if ('1'=== $num) {

    /* script upload d'après http://antoine-herault.developpez.com/tutoriels/php/upload/ */
    $fichier = basename($_FILES['avatar']['name']);
    $taille = filesize($_FILES['avatar']['tmp_name']);
    $extension = strrchr($_FILES['avatar']['name'], '.');
//Début des vérifications de sécurité...
    if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
        $erreur = 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg';
        $ilyaerreur=true;
    }
    if ($taille > $taille_maxi) {
        $erreur = 'Le fichier est trop gros...';
        $ilyaerreur=true;
    }
    if (!$ilyaerreur) { //S'il n'y a pas d'erreur, on upload
        //On formate le nom du fichier ici...
        $fichier =  formaterNomFichier($fichier);
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            $message= 'Upload effectué avec succès !';
        } else { //Sinon (la fonction renvoie FALSE).
            $message= 'Echec de l\'upload !';
        }
    } else {
        $message= $erreur;
    }
}
elseif('all'===$num) {// tout un sous-répertoire
    $message= 'Traitement non implémenté';
}
include('vues/v_upload.php');

