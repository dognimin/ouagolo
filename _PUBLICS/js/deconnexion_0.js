setInterval(function () {deconnexion_automatique(0);}, 120000);
jQuery(function () {
    $("#a_deconnexion").click(function () {
        deconnexion_manuelle(0);
        return false;
    });
});