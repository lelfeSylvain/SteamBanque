        <div class='formulaireLigneChamp'>
            <p class="palibel large">n°client destinataire*  :</p>
            <input type="text" name="idTiers" value="" id="idTiers" size="30" class="mrp" required >        
        </div>
        
        <div class='formulaireLigneChamp'>
            <p class="palibel large">montant *  :</p>
            <input type="number" name="montant" value="" id="montant" size="10" class="mrp" required min="0" >
        </div>

        <div class='formulaireLigneChamp'>
            <?php if ($estClient) { ?>
                <p class="palibel large">Mot de passe*  :</p>
                <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>"> 
            <?php } ?>
            <input type="hidden" name="confirmation" value="" id="confirmation"  >
            <input type="hidden" name="estClient" value="<?php echo $estClient; ?>" id="estClient"   >
            <label>* : champs obligatoires</label>
        </div>
        <div class='boutonChanger'>
            <input type="reset" value="Effacer" id="btnAnnuler" class="boutonChanger">
            <input type="submit" value="Valider" id="btnCreer" class="boutonChanger">

        </div>
    </form>

</section>