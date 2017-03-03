<section name = 'import' id = 'import' class ='tous import'  >
    <form method="POST" action="index.php?uc=importer&num=in"  enctype="multipart/form-data" class="formulaireCourt">	
        <div class='formulaireLigneChamp'>Importer un fichier CSV <br />
            au format num;prenom;nom;codepin Attention la première ligne contient les entêtes de colonnes
        </div>
        <div class='formulaireLigneChamp'>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000">

            Fichier : <input id="uploadInput" type="file" name="mesFichiers" onchange="updateSize();">
            selected files: <span id="fileNum">0</span>; 
            total size: <span id="fileSize">0</span>

            <input type="submit" name="envoyer" value="Envoyer le fichier" class='bouton validation'>
        </div>
    </form> 
</section>    
<script>
    function updateSize() {
        var nBytes = 0,
                oFiles = document.getElementById("uploadInput").files,
                nFiles = oFiles.length;
        for (var nFileId = 0; nFileId < nFiles; nFileId++) {
            nBytes += oFiles[nFileId].size;
        }
        var sOutput = nBytes + " bytes";
        // optional code for multiples approximation
        for (var aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
            sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple] + " (" + nBytes + " bytes)";
        }
        // end of optional code
        document.getElementById("fileNum").innerHTML = nFiles;
        document.getElementById("fileSize").innerHTML = sOutput;
    }
</script>
