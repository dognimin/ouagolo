jQuery(function () {
    $("#form_securite_mdp").submit(function () {
        let longueur_minimale = $("#longueur_minimale_input").val().trim();
        if($("#caracteres_speciaux_input").is(':checked')){let caracteres_speciaux = 1;}else {let caracteres_speciaux = 0;}
        if($("#minuscules_input").is(':checked')){let minuscules = 1;}else {let minuscules = 0;}
        if($("#majuscules_input").is(':checked')){let majuscules = 1;}else {let majuscules = 0;}
        if($("#chiffres_input").is(':checked')){let chiffres = 1;}else {let chiffres = 0;}
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Parametres/Securite/submit_securite_mdp.php',
            type: 'POST',
            data: {
                'longueur_minimale': longueur_minimale,
                'caracteres_speciaux': caracteres_speciaux,
                'minuscules': minuscules,
                'majuscules': majuscules,
                'chiffres': chiffres
            },
            dataType: 'json',
            success: function (data) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                if (data['success'] === true) {
                    $("#form_securite_mdp").hide();
                    $("#p_securite_mdp_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
                }else {
                    $("#p_securite_mdp_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });

        return false;
    });

    $("#form_securite_compte").submit(function () {
        let donnee = $("#duree_mdp_input").val().trim();
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Parametres/Securite/submit_securite_mdp.php',
            type: 'POST',
            data: {
                'donnee': donnee
            },
            dataType: 'json',
            success: function (data) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                if (data['success'] === true) {
                    $("#form_duree_de_vie_mdp").hide();
                    $("#p_duree_de_vie_mdp_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
                }else {
                    $("#p_duree_de_vie_mdp_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });

        return false;
    });


});
$('#EditionSecuriteMdpModal').modal({
    show: false,
    backdrop: 'static'
});