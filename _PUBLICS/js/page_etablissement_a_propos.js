jQuery(function () {

    $("#form_etablissement").submit(function () {
        let code                 = $("#code_input").val().toUpperCase().trim(),
            raison_sociale       = $("#raison_sociale_input").val().toUpperCase().trim(),
            type_etablissement   = $("#type_etablissement_input").val().trim(),
            adresse_postale      = $("#adresse_postale_input").val().toLowerCase().trim(),
            adresse_geographique = $("#adresse_geo_input").val().toLowerCase().trim(),
            longitude            = $("#longitude_input").val().toLowerCase().trim(),
            latitude             = $("#latitude_input").val().toLowerCase().trim(),
            secteur              = $("#secteur_input").val().trim(),
            pays                 = $("#pays_input").val().trim(),
            region               = $("#region_input").val().trim(),
            departement          = $("#departement_input").val().trim(),
            commune              = $("#commune_input").val().trim();
        if (type_etablissement && raison_sociale && pays && region && departement && commune) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement.php',
                type: 'POST',
                data: {
                    'code': code,
                    'raison_sociale': raison_sociale,
                    'type_etablissement': type_etablissement,
                    'secteur': secteur,
                    'adresse_geo': adresse_geographique,
                    'adresse_post': adresse_postale,
                    'longitude': longitude,
                    'latitude': latitude,
                    'pays': pays,
                    'region': region,
                    'departement': departement,
                    'commune': commune

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement").hide();
                        $("#p_etablissement_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    } else {
                        $("#p_etablissement_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code) {
                $("#code_etablissement_input").addClass('is-invalid');
                $("#codeEtablissementHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code s'il vous plait.");
            }
            if(!raison_sociale) {
                $("#raison_sociale_input").addClass('is-invalid');
                $("#raisonSocialeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la raison sociale s'il vous plait.");
            }
            if(!type_etablissement) {
                $("#type_etablissement_input").addClass('is-invalid');
                $("#typeEtablissementHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner un type s'il vous plait.");
            }
            if(!pays) {
                $("#pays_input").addClass('is-invalid');
                $("#paysHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le pays s'il vous plait.");
            }
            if(!region) {
                $("#region_input").addClass('is-invalid');
                $("#regionHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la region s'il vous plait.");
            }
            if(!departement) {
                $("#departement_input").addClass('is-invalid');
                $("#departementHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le departement s'il vous plait.");
            }
            if(!commune) {
                $("#commune_input").addClass('is-invalid');
                $("#communeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la commune s'il vous plait.");
            }
        }
        return false;
    });

    $("#form_etablissement_logo").submit(function () {
        let form_data = new FormData(this);
        $("#button_enregistrer_logo").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Etablissement/Apropos/submit_logo.php',
            type: 'POST',
            data: form_data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $("#button_enregistrer_logo").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_etablissement_logo").hide();
                    $("#p_etablissement_logo_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload();
                    },5000);
                }else {
                    $("#p_etablissement_logo_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
        return false;
    });
    $("#button_ets_coordonnees").click(function () {
        let code = $("#code_input").val().trim();
        if(code) {
            $(".button_ets")
                .prop('disabled',false)
                .removeClass('btn-outline-secondary')
                .addClass('btn-secondary');
            $("#button_ets_coordonnees")
                .prop('disabled',true)
                .removeClass('btn-secondary')
                .addClass('btn-outline-secondary');
            display_ets_coordonnees(2, code);
        }
    });
});
$(".datepicker").datepicker({
    maxDate: -1
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});