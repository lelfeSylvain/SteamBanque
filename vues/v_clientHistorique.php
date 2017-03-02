<section class='historique tous'><?php
    echo "<p> Solde ";
    if ($solde < 0) {
        echo "débiteur de ";
    } else {
        echo "créditeur de ";
    }
    echo montant($solde)  . EOL;
    $text = "";
    ?>
    <table>
        <tr> <th>date</th> <th>libellé</th> <th>valeurs</th> </tr>

        <?php
        $couleur = "claire";
        foreach ($lesDernieresOperations as $uneOp) {
            $montant = $uneOp['montant']. " " . $_SESSION['symbole'];
            if ($uneOp['idTiers'] === $_SESSION['fictif']) {
                $sens = " solde initial : ";
                $montant = "<span class='positif'>".$montant . "</span>";
            } else {                
                $numCptTiers = numCompte($uneOp['idTiers'], $uneOp['prenom'],$uneOp['nom'],$uneOp['superUser']);
                // pour de meilleurs affichages
                if (0 > $uneOp['montant']) {
                    $sens = " à destination du compte N° " . $numCptTiers;
                    $montant = "<span class='negatif'>".$montant. "</span>";
                } else {
                    $sens = " en provenance du compte N° " . $numCptTiers;
                    $montant = "<span class='positif'>".$montant . "</span>";
                }
            }
            $ligne = "<tr class='t" . $couleur . "'><td class='tdate'>" . $uneOp['ts'] . "</td><td class='tlib'>" . $sens . "</td><td class='tmontant'>" . $montant . "</td></tr>" . EL;
            
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
        // on nettoie les variable inutile
        unset($numCptTiers, $text, $ligne, $sens, $lesDernieresOperations, $uneOp, $couleur);
        unset($montant,$identite);
        ?>
    </table>
</section>