<?php
echo "<p> Solde ";
if ($solde < 0) {
    echo "débiteur de ";
} else {
    echo "créditeur de ";
}
echo $solde . " " . $_SESSION['symbole'] . EOL;
$text = "";
?>
<table>
    <tr> <th>date</th> <th>libellé</th> <th>valeurs</th> </tr>

    <?php
    foreach ($lesDernieresOperations as $uneOp) {
        if ($uneOp['idTiers'] === $_SESSION['fictif']) {
            $sens = " Solde initiale : ";
        } else {
            if (1 == $_SESSION['maxCompteParClient']) {
                $numCpt = $uneOp['idTiers'];
            } else {
                $numCpt = $uneOp['idTiers'] . "-" . $uneOp['numTiers'];
            }
            if (0 > $uneOp['montant']) {
                $sens = " à destination du compte N° " . $numCpt;
            } else {
                $sens = " en provenance du compte N° " . $numCpt;
            }
        }
        $ligne = "<tr><td class='tdate'>" . $uneOp['ts'] . "</td><td class='tlib'>" . $sens . "</td><td class='tmontant'>" . $uneOp['montant'] . " " . $_SESSION['symbole'] . "</td></tr>" . EL;
        if ($_SESSION['affichageChronologique']) {
            $text = $ligne . $text;
        } else {
            $text .= $ligne;
        }
    }
    echo $text;
    unset($nuCpt,$text,$ligne,$sens,$lesDernieresOperations,$uneOp);
    ?>
</table>