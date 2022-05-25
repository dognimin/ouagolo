setInterval(function () {deconnexion_automatique(2);}, 120000);
jQuery(function () {
    $("#a_deconnexion").click(function () {
        deconnexion_manuelle(2);
        return false;
    });
});