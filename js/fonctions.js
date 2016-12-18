/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function doChallengeResponse() {
    str = "f4G4k2#e33&" + document.identification.password.value;
    document.identification.reponse.value = MD5(str);
    document.identification.mot_de_passe.value = "";

}

/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function encodeMDPenMD5() {
    var ancien = document.getElementById('ancien');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    ancien.value = MD5("f4G4k2#e33&" +ancien.value);
    nouveau.value = MD5("f4G4k2#e33&" +nouveau.value);
    confirmation.value = MD5("f4G4k2#e33&" +confirmation.value);

}