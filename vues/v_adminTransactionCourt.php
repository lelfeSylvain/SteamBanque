<section name = 'transaction' id = 'transaction'  class = 'tous transaction'>
    <form method="post" action="index.php?uc=transaction&num=check" name='transactionTiers' id='transactionTiers' class="formulaireCourt" onsubmit="encodeMDPenMD5_NouveauUtil()">
        <div class='formulaireLigneRadio'>               
            Réaliser un virement :
        </div>
        <div class='formulaireLigneChamp'>
            <p class="palibel large">n°client source*  :</p>
            <input type="text" name="idSource" value="" id="idSource" size="30" class="mrp" required >        
        </div>
       <?php
        include('vues/v_transactionCourtFin.php');
        ?>