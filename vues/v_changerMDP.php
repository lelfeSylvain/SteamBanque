<?php echo $titre; ?> </div>

</header>
<section class='corps'>
    <?php if ('' != $textNav) { ?>
        <section class='bilanoperation'>
            <p>
                <?php echo $textNav; ?>
            </p>
        </section>
    <?php } ?>
    <section class='tous' >
        <form method="post" action="index.php?uc=<?php echo $cible; ?>&num=check" id='chgMDP' class="formulaire" onsubmit="encodeMDPenMD5()" >
            <div class='formulaireLigneDesc'>  <p>             
                <?php
                if ("changerMdP" === $cible) {
                    echo ucwords($_SESSION['pseudo']) . " saisissez votre ancien mot de passe puis deux fois le nouveau.";
                } else {
                    // cette ligne pour récupérer l'ID du client à modifier
                    echo "<input type='hidden' name='id'  value='$idClient' size=32>";
                    // cette ligne pour la compatibilité avec le script JS qui encode en MD5
                    echo "<input type='hidden' name='ancien' value=''  id='ancien' size='30' >";
                    echo "Pour le client " . ucwords($prenomClient . " " . $nomClient) . ", saisissez deux fois le nouveau mot de passe. L'ancien sera écrasé.";
                }
                ?>
                </p><p>
                Un bon mot de passe comporte au moins 8 caractères, n'est ni une date, n'est ni un 
                nom commun, ni un nom propre. En outre, les caractères utilisés doivent appartenir à <?php echo $_SESSION['commentaireRegex']; ?>.
                </p>
            </div>
            <div class='formulaireLigneChamp'>
                <p class="palibel large">Nouveau mot de passe*  :</p>
                <input type="password" name="nouveau" value="" id="nouveau" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">
                <label class="">caractères autorisés (<?php echo $_SESSION['commentaireRegex']; ?>)</label>
            </div>
            <div class='formulaireLigneChamp'>
                <p class="palibel large">Confirmation* : </p>
                <input type="password" name="confirmation" value="" id="confirmation" size="30" class="mrp" required pattern="<?php echo $_SESSION['regex']; ?>">        
                <label id="msg"></label>
            </div>
            <?php if ("changerMdP" === $cible) { ?>
                <div class='formulaireLigneChamp'>
                    <p class="palibel large">Ancien mot de passe*  :</p>
                    <input type="password" name="ancien" value="" required id="ancien" size="30" class="mrp">
                </div>
            <?php } ?>
            <div class='formulaireLigneChamp'>
                <label>* Champs obligatoires.</label>
            </div>
            <div class='formulaireLigneChamp'>
                <input type="submit" value="Changer" id="btnChanger" class="bouton validation">
            </div>

        </form>
    </section>
</section>
<script>
    var reponse = true;
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