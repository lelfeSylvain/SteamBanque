Transaction vers un tiers</div>

</header>
<p><?php
    if ("check" === $num) {
        echo $textNav;
        echo "</p><p>";
    }
    ?>
<form method="post" action="index.php?uc=transaction&num=check" name='transactionTiers' id='transactionTiers' class="formulaire" onsubmit="encodeMDPenMD5_NouveauUtil()">
    <div class='formulaireLigneRadio'>               
        Veuillez saisir les informations suivantes :
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">numéro Client destination du virement*  :</p>
        <input type="text" name="idTiers" value="" id="idTiers" size="30" class="mrp" required >        
    </div>
    <?php if (1 != $_SESSION['maxCompteParClient']) { ?>
        <div class='formulaireLigneChamp'>
            <p class="palibel large">Numéro du compte destination*  :</p>
            <input type="text" name="numTiers" value="" id="numTiers" size="30" class="mrp" required >
        </div>
    <?php } else { ?>
        <input type="hidden" name="numTiers" value="<?php echo $_SESSION['numMinCompteClient'] + 1; ?>" id="numTiers" size="30"  >
    <?php } ?>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">montant de la transaction*  :</p>
        <input type="text" name="montant" value="" id="montant" size="10" class="mrp" required >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Mot de passe*  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">
        <input type="hidden" name="confirmation" value="" id="confirmation" size="30"  >
        <label class="">caractères autorisés (<?php echo $_SESSION['commentaireRegex']; ?>)</label>
    </div>

    <div class='formulaireLigneChamp'>
        <label>* : champs sont obligatoires.</label>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="reset" value="Effacer" id="btnAnnuler" class="boutonChanger">
        <input type="submit" value="Valider" id="btnCreer" class="boutonChanger">

    </div>
</form>

