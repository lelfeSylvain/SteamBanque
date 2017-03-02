        <div class='formulaireLigneChamp '>
            <p class="palibel large">n°client destinataire*  :</p>
            <input type="text" name="idTiers" value="" id="idTiers" size="30" required >        
        </div>
        
        <div class='formulaireLigneChamp'>
            <p class="palibel large">montant *  :</p>
            <input type="number" name="montant" value="" id="montant" size="10"  required min="0" >
             <label class='champobligatoire'> * : champs obligatoires</label>
        </div>

        <div class='formulaireLigneChamp'>
            <?php if ($estClient) { ?>
                <p class="palibel large">Mot de passe*  :</p>
                <input type="password" name="nouveau" value="" id="nouveau" size="30"  required pattern="<?php echo $_SESSION['regex']; ?>">                
            <?php } ?>
            <input type="hidden" name="confirmation" value="" id="confirmation"  >
            <input type="hidden" name="estClient" value="<?php echo $estClient; ?>" id="estClient"   >
            
        </div>
        <div class='bouton'>
            <input type="reset" value="Effacer" id="btnAnnuler" class="bouton validation">
            <input type="submit" value="Valider" id="btnCreer" class="bouton validation">

        </div>
    </form>

</section>