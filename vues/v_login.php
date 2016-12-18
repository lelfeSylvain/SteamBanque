Connexion </div>

</header>
<?php
echo $texteNav;
?>
<form method="post" action="index.php?uc=login&num=in" name='identification' class="formulaire">
    <div class='formulaireLigneRadio'>               
        Pour se connecter :
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Identifiant  :</p>
        <input type="text" name="login" value="<?php echo $login; ?>">
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel2">Mot de passe : </p>
        <input type="password" name="password" value="<?php echo $mdp; ?>" >
        <input type="submit" value="Connexion" onClick="doChallengeResponse();" class="boutonConnexion">
    </div>

    
    <input type="hidden" name="reponse"  value="" size=32>
</form>

