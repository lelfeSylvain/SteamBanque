Modifier les paramètres des clients</div>

</header>
<p><?php
    if ("check" === $num) {
        /*var_dump($tabFiltre);
        echo EOL;
        var_dump($_POST);
        echo EOL;
        var_dump($mesPost);echo EOL;echo $mesPost[0].EOL;*/
        echo $textNav;
        echo "</p><p>";
    } 

?>
<form method="post" action="index.php?uc=modifierParam&num=check" name='modifParam' class="formulaire">
    <div class='formulaireLigneRadio'>               
        Les Paramètres :
    </div>
    <?php
    foreach($lesParam as list($key , $value, $filtre)) {
        ?>
        <div class='formulaireLigneChamp'>
            <p class="palibel3"><?php echo $key; ?>  :</p>
            <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
        </div>
        <?php 
        
    }
    ?><div class='formulaireLigneChamp'>
        <input type="submit" value="Valider"  class="boutonValider">
    </div>
</form>
<?php
