<section name = 'soldes' id = 'soldes' class='tous soldes' >
    Soldes
    <form method="post" id ='fsolde' action="index.php?uc=supprimer&num=in"  class="formulaire" >	
        <table class="ttparam">
            <tr><th>num Compte</th><th>Nom Client</th><th>solde</th><th>dernière connexion</th><th>sélection</th></tr>
            <?php
            $couleur = "claire";
            $i = 0;
            foreach ($lesSoldes as list($numCli, $nomCli, $leSolde, $su, $ts)) {
                echo "<tr class='t" . $couleur . "'><td class='tnumcpt'>" . $numCli;
                echo "</td><td class='tlib'>" . identite('', $nomCli, $su) . "</td><td class='tmontant'>";
                echo montant($leSolde) . " </td><td class='tdate'>";
                echo $ts . "</td><td class='tselection'>";
                echo "<INPUT type='checkbox' id ='choix" . $i . "' name='choix[]' value='";
                echo $numCli . "' ></td></tr>" . EL;
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

</section>
<script>
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

    var inputs = document.getElementsByTagName('input');
    var monformulaire = document.getElementById('fsolde');

    monformulaire.addEventListener('submit', function (e) {
        if (! verif())   {
            e.preventDefault();}
        
    });


</script>
