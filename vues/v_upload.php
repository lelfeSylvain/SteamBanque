Upload</div>

</header>
<?php 
if ('0'===$num) { ?>

<form method="POST" action="index.php?uc=upload&num=1" enctype="multipart/form-data">	
    <!-- On limite le fichier à 100Ko -->
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    Fichier : <input type="file" name="avatar">
    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form> 
<?php
} else {
    // affichage du résultat des traitements
echo $message;
}
    