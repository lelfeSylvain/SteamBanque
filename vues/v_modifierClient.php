Modifier un client</div>

</header>
<section class='corps'>
    <?php if ('' != $textNav) { ?>
        <section class='bilanoperation'>
            <p>
                <?php echo $textNav; ?>
            </p>
        </section>
    <?php } ?>
    <section class='tous'>
            <form method="post" action="index.php?uc=modifierClient&num=check" name='modifierClient' id='modifierClient' class="formulaire" onsubmit="encodeMDPenMD5_NouveauUtil()">
                <div class='formulaireLigneRadio'>               
                    Veuillez saisir les informations suivantes :
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel large">numéro Client*  :</p>
                    <input type="text" name="id" value="<?php echo $idClient; ?>" id="id" size="10" class="mrp" readonly="true" >        
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel large">Nom du Client*  :</p>
                    <input type="text" name="nom" value="<?php echo $nomClient; ?>" id="nom" size="100" class="mrp" required >
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel large">Prenom du Client*  :</p>
                    <input type="text" name="prenom" value="<?php echo $prenomClient; ?>" id="prenom" size="100" class="mrp" required >
                </div>
                <div class='formulaireLigneChamp'>
                    <p class="palibel large">découvert autorisé  :</p>
                    <input type="text" name="decouvert" value="<?php echo $decouvert; ?>" id="decouvert" size="100" class="mrp"  >
                </div>
                <div class='formulaireLigneChamp'>
                    <input type="checkbox" name="estSU" id="estSU" value="1" <?php if ($estSUClient) echo "checked"; ?>>
                    <label>Super Utilisateur</label>
                </div>
                <div class='formulaireLigneChamp'>
                    <label>* : Champs obligatoires.</label>
                </div>
                <div class='formulaireLigneChamp'>
                    <input type="reset" value="Réinitialiser" id="btnAnnuler" class="bouton validation">
                    <input type="submit" value="Modifier" id="btnCreer" class="bouton validation">

                </div>
            </form>
        </section>
    </section>
    <script>
        var reponse = true;
        var estSU = document.getElementById('estSU');


        // gère l'avertissement sur la case à cocher
        estSU.addEventListener('click', function (e) {
            if (estSU.checked) {
                if (confirm("Vous allez créer un super Utilisateur ?") === false) {
                    estSU.checked = false;
                }
            }
        });
    </script>

