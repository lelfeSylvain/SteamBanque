<?php
$text = "";
$lib = array("date", "compte", "<-- & date", "--> & date", "tiers", "valeurs");
?>
<section name = 'historique' id = 'historique'  >
    Mouvements
    <form name="frmTri" method="post" action="index.php?uc=defaut&num=actuel">
        <table>           
            <tr> <?php
                for ($i = 0; $i < 6; $i++) {
                    if (3 != $i)
                        echo "<th>";
                    echo "<input type='radio' name='trier' value='" . $i . "' ";
                    if ($i == $resultat["trier"])
                        echo "checked";
                    echo ">" . $lib[$i];
                    if (2 != $i)
                        echo "</th>";
                    echo EL;
                }
                ?>
            </tr>

            <?php
            $couleur = "claire";
            foreach ($lesDernieresOperations as $uneOp) {

                
                    $numCptTiers = $uneOp['idTiers'];
                    $numCpt = $uneOp['idCli'];
               
                if (0 > $uneOp['montant']) {
                    $sens = " à destination du compte N° ";
                } else {
                    $sens = " en provenance du compte N° ";
                }
                $ligne = "<tr class='t" . $couleur . "'><td class='tdate'>" . $uneOp['ts'] . "</td><td class='tnumcpt'>" . $numCpt . "</td><td class='tlib'>" . $sens . "</td><td class='tnumcpt'>" . $numCptTiers . "</td><td class='tmontant'>" . $uneOp['montant'] . " " . $_SESSION['symbole'] . "</td></tr>" . EL;
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
            unset($numCptTiers, $numCpt, $text, $ligne, $sens, $lesDernieresOperations, $uneOp, $couleur);
            ?>

            <tr><th>
                </th>
                <th>
                    <input type="text" name="numCpt" value="" id="numCpt" size="10" class="mrp"  >
                </th>
                <th></th>
                <th>
                    <input type="text" name="numCptTiers" value="" id="numCptTiers" size="10" class="mrp"  >
                </th><th><input type="submit" value="Trier - Filtrer">
                </th>
            </tr>
        </table>
    </form>
</section>
