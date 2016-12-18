Changer votre mot de passe </div>

</header>
<?php
echo $texteNav;
?>
<form method="post" action="index.php?uc=changer&num=check" id='chgMDP' class="formulaire" onsubmit="encodeMDPenMD5()" >
    <div class='formulaireLigneDesc'>               
        Saisissez votre ancien mot de passe puis deux fois le nouveau. Un bon mot de passe comporte au moins 8 caractères, n'est ni une date, n'est ni un 
        nom commun, ni un nom propre. En outre, il doit contenir au moins une majuscule, au moins un minuscule, au moins un chiffre et au moins un symbole.
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Nouveau mot de passe  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$<>]).{8,30}$">
        <label class="">caractères autorisés (A-Z a-z 0-9 &#-_@=+*/?.!$><)</label>
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Confirmation : </p>
        <input type="password" name="confirmation" value="" id="confirmation" size="30" class="mrp" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[&#-_@=+*/?.!$<>]).{8,30}$">        
        <label id="msg"></label>
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Ancien mot de passe  :</p>
        <input type="password" name="ancien" value="" required id="ancien" size="30" class="mrp">
    </div>
    <div class='formulaireLigneChamp'>
        <label>Tous les champs sont obligatoires.</label>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="submit" value="Changer" id="btnChanger" class="boutonChanger">
    </div>
    


    <input type="hidden" name="reponse"  value="" size=32>
</form>

<script>
    var reponse = true;
    var ancien = document.getElementById('ancien');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    var msg = document.getElementById('msg');
    var btnChanger = document.getElementById('btnChanger');
    var frm = document.getElementById('chgMDP');

    frm.addEventListener('change', function (e) {
        if (nouveau.value === confirmation.value) {
            btnChanger.disabled = false;
            msg.innerHTML = "";
        } else {
            msg.innerHTML = "Le nouveau mot de passe et sa confirmation sont différents.";
            btnChanger.disabled = true;
        }
    });
    

</script>