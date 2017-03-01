<section name = 'soldes' id = 'soldes' class='soldes' >
    <form method="POST" id ='fsolde' action="index.php?uc=supprimer&num=in"  enctype="multipart/form-data" class="formulaireCourt" onsubmit="return verif();">	
    Soldes <table >
            <tr><th>num Compte</th><th>Nom Client</th><th>solde</th><th>sélection</th></tr>
            <?php
            $couleur = "claire";
            $i = 0;
            foreach ($lesSoldes as list($numCli, $nomCli, $leSolde)) {
                echo "<tr class='t" . $couleur . "'><td class='tnumcpt'>" . $numCli;
                echo "</td><td class='tlib'>" . $nomCli . "</td><td class='tmontant'>";
                echo $leSolde . " " . $_SESSION['symbole'] . " </td><td>";
                echo "<INPUT type='checkbox' id ='choix" . $i . "' name='choix[]' value='";
                echo $numCli . "' ></td></tr>" . EOL;
                if ('claire' === $couleur) {
                    $couleur = 'foncee';
                } else {
                    $couleur = "claire";
                }
            }
            ?>

        </table>
        <div class='formulaireLigneChamp'>
            <input type="submit" value="Supprimer" class='bouton valider'>
        </div>
    </form>

    <script>
        var inputs = document.getElementsByTagName('input');
        var form = document.getElementById("fsolde");

        function test() {
            var c = inputs.length;
            var n = 0;
            for (var i = 0; i < c; i++) {
                if (inputs[i].type === 'checkbox' && inputs[i].checked) {
                    n++;
                }
            }
            return n;
        }

        function verif() {
            var tot = test();
            var pluriel = "ce";
            if (tot > 1) {
                pluriel += 's ' + tot + ' clients';
            } else if (1 === tot) {
                pluriel = 'ce client';
            } else {
                return false;
            }
            return confirm('Etes-vous sur de vouloir effacer ' + pluriel);
        }



    </script>

</section>