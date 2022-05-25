setInterval(function () {deconnexion_automatique(1);}, 120000);
jQuery(function () {
    $("#a_deconnexion").click(function () {
        deconnexion_manuelle(1);
        return false;
    });
});