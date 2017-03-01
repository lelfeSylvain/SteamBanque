/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function doChallengeResponse() {
    str = SEL + document.identification.password.value;
    document.identification.reponse.value = MD5(str);
    document.identification.mot_de_passe.value = "";

}

/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire de changement de mot de passe
 */
function encodeMDPenMD5() {
    var ancien = document.getElementById('ancien');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    ancien.value = MD5(SEL +ancien.value);
    nouveau.value = MD5(SEL +nouveau.value);
    confirmation.value = MD5(SEL +confirmation.value);

}

/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire de creation d'utilisateur
 */
function encodeMDPenMD5_NouveauUtil() {
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    nouveau.value = MD5(SEL +nouveau.value);
    confirmation.value = MD5(SEL +confirmation.value);

}