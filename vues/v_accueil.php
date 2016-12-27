Accueil</div>

</header>
<p>
    <?php echo $_SESSION['pseudo']; ?>
    Bienvenue sur notre banque en ligne</p>
<?php
if ($estSU) {
    ?>
    <p> Vous pouvez : 
        <ul>
            <li><a href='index.php?uc=ajouterClient&num=in' >Ajouter un nouveau client</a></li>
            <li><a href='index.php?uc=modifierClient&num=in' >Modifier les paramètres d'un client</a></li>
            <li><a href='index.php?uc=modifierParam&num=in' >Modifier les paramètres par défaut des clients</a></li>
        </ul>
    <?php
}
?>
