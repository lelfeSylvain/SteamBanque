                
<footer  class="principal">
    <nav class='pied'>
        <div class='pied'>
            <?php
            echo $textNav . $phraseNbVisiteur . "<p>".$_GLOBAL['titre']." v0.0.1 alpha - <a href='http://etablissementbertrandeborn.net/'>Site de BdeB</a> - <img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' /></p>" . EL;
            ?>
        </div>
    </nav>    
    <?php
    if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === "debug" && $_SESSION['debug'] === "text") {
        phpinfo();
    }
    ?>

</footer>
</section>
</body>
</html>
