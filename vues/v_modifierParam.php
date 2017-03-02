Modifier les paramètres de l'applicaion</div>

</header>
<p><?php
    if ("check" === $num) {
        echo $textNav;
        echo "</p><p>";
    }
    ?>
<section class='tous'>
    <form method="post" action="index.php?uc=modifierParam&num=check" name='modifParam' class="formulaire">
        <div class='formulaireLigneRadio'>               
            Les Paramètres :
        </div>
        <table class='ttparam'>
            <tr></tr>
            <?php
            $ancienneRubrique = "";
            foreach ($lesParam as list($key, $value, $filtre, $comment, $rubrique)) {
                if ("entier positif" === $filtre) {
                    $type = "number";
                } else {
                    $type = "text";
                }

                if ($rubrique !== $ancienneRubrique) {
                    $ancienneRubrique = $rubrique;
                    ?>
                    <tr><td colspan="4" class='trubrique'>              
                            <?php echo $rubrique; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr><td class='tespace'></td><td class='tmotcle'>
                        <?php echo $key; ?>  :
                    </td><td class='tchamp'>
                        <input type="<?php echo $type; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" class='tchamp'>
                    </td><td class='tcommentaire'><?php echo $comment; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <div class='formulaireLigneChamp'>
            <input type="submit" value="Valider"  class="bouton validation">
        </div>
    </form>
</section>
