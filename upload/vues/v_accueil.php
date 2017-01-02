Accueil</div>

</header>
<p>
    <?php
    echo $textNav;
    echo "</p><p>";
    echo $_SESSION['pseudo'];
    ?>
    Bienvenue sur notre banque en ligne
</p>
<?php
if ($estSU) {// superUtilisateur
    ?>
    <p> Vous pouvez : 
    <ul>
        <li><a href='index.php?uc=ajouterClient&num=in' >Ajouter un nouveau client</a></li>
        <li><a href='index.php?uc=modifierMdPClient&num=in' >Réinitialiser le mot de passe d'un client</a></li>
        <li><a href='index.php?uc=modifierClient&num=in' >Modifier les paramètres d'un client</a></li>
        <li><a href='index.php?uc=modifierParam&num=in' >Modifier les paramètres par défaut des clients</a></li>
    </ul>
    </p>
    <?php
} else {// client 
    echo "<p> Votre solde est ";
    if ($solde < 0) {
        echo "débiteur de ";
    } else {
        echo "créditeur de ";
    }
    echo $solde . " " . $_SESSION['symbole'] . EOL;
    $text = "";
    foreach ($lesDernieresOperations as $uneOp) {
        if ($uneOp['idTiers'] === $_SESSION['fictif']) {
            $sens = " Solde initiale : ";
        } else {
            if (0 > $uneOp['montant']) {
                $sens = " à destination du compte N° " . $uneOp['idTiers'] . "-" . $uneOp['numTiers'];
            } else {
                $sens = " en provenance du compte N° " . $uneOp['idTiers'] . "-" . $uneOp['numTiers'];
            }
        }
        $ligne = $uneOp['ts'] . $sens . " " . $uneOp['montant'] . " " . $_SESSION['symbole'] . EOL;
        $text = $ligne . $text;
    }
    echo $text;
    ?>
    <p> Vous pouvez : 
        <ul>
            <li><a href='index.php?uc=transaction&num=in' >Effectuer une transaction vers un tiers</a></li>
        </ul>
    </p>
<?php } ?>

