Ajouter un nouveau client</div>

</header>
<p><?php
    if ("check" === $num) {

        echo $textNav;
        echo "</p><p>";
    }
    ?>
<form method="post" action="index.php?uc=ajouterClient&num=check" name='ajouterClient' id='ajouterClient' class="formulaire" onsubmit="encodeMDPenMD5_NouveauUtil()">
    <div class='formulaireLigneRadio'>               
        Veuillez saisir les informations suivantes :
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">numéro Client*  :</p>
        <input type="text" name="id" value="" id="id" size="10" class="mrp" required >        
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Nom du Client*  :</p>
        <input type="text" name="nom" value="" id="nom" size="100" class="mrp" required >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Prenom du Client*  :</p>
        <input type="text" name="prenom" value="" id="prenom" size="100" class="mrp" required >
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Mot de passe*  :</p>
        <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">
        <label class="">caractères autorisés (<?php echo $_SESSION['commentaireRegex']; ?>)</label>
    </div>
    <div class='formulaireLigneChamp'>
        <p class="palibel large">Confirmation* : </p>
        <input type="password" name="confirmation" value="" id="confirmation" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">        
        <label id="msg"></label>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="checkbox" name="estSU" id="estSU" value="1">
        <label>Super Utilisateur</label>
    </div>
    <div class='formulaireLigneChamp'>
        <label>* : champs sont obligatoires.</label>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="reset" value="Effacer" id="btnAnnuler" class="boutonChanger">
        <input type="submit" value="Créer" id="btnCreer" class="boutonChanger">
        
    </div>
</form>

<script>
    var reponse = true;
    var estSU = document.getElementById('estSU');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    var msg = document.getElementById('msg');
    var btnCreer = document.getElementById('btnCreer');
    var frm = document.getElementById('ajouterClient');
    // gère la confirmation des deux mots de passe
    frm.addEventListener('change', function (e) {
        if (nouveau.value === confirmation.value) {
            btnCreer.disabled = false;
            msg.innerHTML = "";
        } else {
            msg.innerHTML = "Le mot de passe et sa confirmation sont différents.";
            btnCreer.disabled = true;
        }
    });
    // gère l'avertissement sur la case à cocher
    estSU.addEventListener('click', function (e) {
        if (estSU.checked) {
            if (confirm("Vous allez créer un super Utilisateur ?") === false) {
                estSU.checked = false;
            }
        }
    });
</script>