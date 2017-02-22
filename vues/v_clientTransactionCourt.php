<form method="post" action="index.php?uc=transaction&num=check" name='transactionTiers' id='transactionTiers' class="<?php echo $typeFormulaire; ?>" onsubmit="encodeMDPenMD5_NouveauUtil()">
    <div class='formulaireLigneRadio'>               
        Réaliser un virement :
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">n°compte destinataire*  :</p>
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
        <p class="palibel large">montant *  :</p>
        <input type="number" name="montant" value="" id="montant" size="10" class="mrp" required min="0" >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Mot de passe*  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">
        <input type="hidden" name="confirmation" value="" id="confirmation" size="30"  >
    </div>

    <div class='formulaireLigneChamp'>
        <label>* : champs sont obligatoires.</label>
    </div>
    <div class='boutonChanger'>
        <input type="reset" value="Effacer" id="btnAnnuler" class="boutonChanger">
        <input type="submit" value="Valider" id="btnCreer" class="boutonChanger">

    </div>
</form>

