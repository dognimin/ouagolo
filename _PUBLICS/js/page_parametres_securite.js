jQuery(function () {
    $("#form_securite_mdp").submit(function () {
        let longueur_minimale = $("#longueur_minimale_input").val().trim(),
            caracteres_speciaux,
            minuscules,
            majuscules,
            chiffres;
        if($("#caracteres_speciaux_input").is(':checked')){caracteres_speciaux = 1;}else {caracteres_speciaux = 0;}
        if($("#minuscules_input").is(':checked')){minuscules = 1;}else {minuscules = 0;}
        if($("#majuscules_input").is(':checked')){majuscules = 1;}else {majuscules = 0;}
        if($("#chiffres_input").is(':checked')){chiffres = 1;}else {chiffres = 0;}
        if(longueur_minimale || caracteres_speciaux || minuscules || majuscules || chiffres) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Securite/Json/submit_securite_mdp.php',
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
        }
        return false;
    });
    $("#form_securite_compte").submit(function () {
        let nombre_essais = $("#nombre_essais_input").val().trim(),
            duree_mot_de_passe = $("#duree_mot_de_passe_input").val().trim(),
            double_authentification,
            autoriser_sms,
            autoriser_email;
        if($("#caracteres_speciaux_input").is(':checked')){double_authentification = 1;}else {double_authentification = 0;}
        if($("#minuscules_input").is(':checked')){autoriser_sms = 1;}else {autoriser_sms = 0;}
        if($("#majuscules_input").is(':checked')){autoriser_email = 1;}else {autoriser_email = 0;}
        if(nombre_essais || duree_mot_de_passe || double_authentification || autoriser_sms || autoriser_email) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Securite/Json/submit_securite_compte.php',
                type: 'POST',
                data: {
                    'nombre_essais': nombre_essais,
                    'duree_mot_de_passe': duree_mot_de_passe,
                    'double_authentification': double_authentification,
                    'autoriser_sms': autoriser_sms,
                    'autoriser_email': autoriser_email
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_securite_compte").hide();
                        $("#p_securite_compte_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_securite_compte_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
});
$('#EditionSecuriteModal').modal({
    show: false,
    backdrop: 'static'
});