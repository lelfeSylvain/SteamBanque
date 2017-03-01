<section class='historique'><?php
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
        $couleur = "claire";
        foreach ($lesDernieresOperations as $uneOp) {
            if ($uneOp['idTiers'] === $_SESSION['fictif']) {
                $sens = " Solde initiale : ";
            } else {
                if (1 == $_SESSION['maxCompteParClient']) {
                    $numCptTiers = $uneOp['idTiers'];
                } else {
                    $numCptTiers = $uneOp['idTiers'] . "-" . $uneOp['numTiers'];
                }
                if (0 > $uneOp['montant']) {
                    $sens = " à destination du compte N° " . $numCptTiers;
                } else {
                    $sens = " en provenance du compte N° " . $numCptTiers;
                }
            }
            $ligne = "<tr class='t" . $couleur . "'><td class='tdate'>" . $uneOp['ts'] . "</td><td class='tlib'>" . $sens . "</td><td class='tmontant'>" . $uneOp['montant'] . " " . $_SESSION['symbole'] . "</td></tr>" . EL;
            if ($_SESSION['affichageChronologique']) {
                $text = $ligne . $text;
            } else {
                $text .= $ligne;
            }
            if ('claire' === $couleur) {
                $couleur = 'foncee';
            } else {
                $couleur = "claire";
            }
        }
        echo $text;
        unset($numCptTiers, $text, $ligne, $sens, $lesDernieresOperations, $uneOp, $couleur);
        ?>
    </table>
</section>