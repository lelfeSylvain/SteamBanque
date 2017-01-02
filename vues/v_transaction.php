Transaction vers un tiers</div>

</header>
<p><?php
    if ("in2" === $num) {
var_dump($_POST);
        echo $textNav;
        echo "</p><p>";
    }
    ?>
<form method="post" action="index.php?uc=transaction&num=in2" name='transactionTiers' id='transactionTiers' class="formulaire" onsubmit="encodeMDPenMD5_NouveauUtil()">
    <div class='formulaireLigneRadio'>               
        Veuillez saisir les informations suivantes :
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">numéro Client destination du virement*  :</p>
        <input type="text" name="id" value="" id="id" size="30" class="mrp" required >        
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Numéro du compte destination*  :</p>
        <input type="text" name="num" value="" id="num" size="10" class="mrp" required >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">montant de la transaction*  :</p>
        <input type="text" name="montant" value="" id="montant" size="10" class="mrp" required >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Mot de passe*  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$<>]).{8,30}$">
        <input type="hidden" name="nouveau" value="" id="confirmation" size="30"  >
        <label class="">caractères autorisés (A-Z a-z 0-9 &#-_@=+*/?.!$><)</label>
    </div>
    
    <div class='formulaireLigneChamp'>
        <label>* : champs sont obligatoires.</label>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="reset" value="Effacer" id="btnAnnuler" class="boutonChanger">
        <input type="submit" value="Valider" id="btnCreer" class="boutonChanger">
        
    </div>
</form>

