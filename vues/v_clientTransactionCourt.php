<section class='transaction tous' >
    <div class='accueilTitre'>               
        Réaliser un virement :
    </div>
    <form method="post" action="index.php?uc=transaction&num=check" name='transactionTiers' id='transactionTiers' class="formulaire " onsubmit="encodeMDPenMD5_NouveauUtil()">

        <?php include('vues/v_transactionCourtFin.php') ?>
   

