<?php echo $titre; ?></div>

</header>
<form method="post" action="index.php?uc=<?php echo $cible; ?>&num=choix" name='modifierClient' id='modifierClient' class="formulaire" onsubmit="encodeMDPenMD5_NouveauUtil()">
    <div class='formulaireLigneRadio'>               
        Veuillez choisir le client à modifier :
    </div>
    <div class='formulaireLigneChamp'>
        <select name="choixClient"> 
            <?php
            foreach ($lesClients as list($id, $nom, $prenom)) {
                ?>
                <option value="<?php echo $id; ?>"> <?php echo $prenom . " " . $nom; ?></option>
            <?php }
            ?>
        </select>
    </div>
    <div class='formulaireLigneChamp'>
        <input type="reset" value="Réinitialiser" id="btnAnnuler" class="boutonChanger">
        <input type="submit" value="Choisir" id="btnCreer" class="boutonChanger">

    </div>
</form>
