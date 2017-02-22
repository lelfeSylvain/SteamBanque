Accueil</div>

</header>
<p>
    <?php echo $textNav; ?>
</p>
<p>
    Bienvenue M. 
    <?php
        echo $_SESSION['pseudo'].EOL;
    ?>    
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
    include('vues/v_clientTransactionCourt.php');
    include('vues/v_clientHistorique.php');
    include('vues/v_clientDeconnexion.php');
  ?>  
   
<?php } 

