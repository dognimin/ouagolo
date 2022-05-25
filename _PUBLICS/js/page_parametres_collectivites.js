jQuery(function () {
    $("#pays_input").change(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#region_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
                type: 'post',
                data: {
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#region_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#region_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#pays_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#paysHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#pays_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#paysHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#region_input").change(function () {
        let code_region     = $(this).val().trim(),
            code_pays     = $("#pays_input").val().trim();

        if(code_region) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#departement_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
                type: 'post',
                data: {
                    'code_region': code_region,
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#departement_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#departement_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#region_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#regionHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#region_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#regionHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une region SVP.");
        }
    });
    $("#departement_input").change(function () {
        let code_departement     = $(this).val().trim(),
            code_pays     = $("#pays_input").val().trim(),
            code_region     = $("#region_input").val().trim();
        if(code_departement) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#commune_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
                type: 'post',
                data: {
                    'code_pays': code_pays,
                    'code_region': code_region,
                    'code_departement': code_departement
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#commune_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#commune_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#departement_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#departementHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#departement_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#departementHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#commune_input").change(function () {
        let commune     = $(this).val().trim();
        if(commune) {
            $("#commune_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#communeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#commune_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#communeHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner la commune SVP.");
        }
    });

    $("#form_collectivite").submit(function () {
        let code_secteur            = $("#code_secteur_input").val().trim()
            code                    = $("#code_input").val().trim(),
            code_externe            = $("#code_externe_input").val().trim(),
            raison_sociale          = $("#raison_sociale_input").val().toUpperCase().trim(),
            code_pays               = $("#pays_input").val().trim(),
            code_region             = $("#region_input").val().trim(),
            code_departement        = $("#departement_input").val().trim(),
            code_commune            = $("#commune_input").val().trim(),
            adresse_postale         = $("#adresse_postale_input").val().toUpperCase().trim(),
            adresse_geographique    = $("#adresse_geo_input").val().toUpperCase().trim(),
            latitude                = $("#latitude_input").val().trim(),
            longitude               = $("#longitude_input").val().trim();
        if(code_secteur && raison_sociale && code_pays && code_region && code_departement && code_commune) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Collectivites/submit_edition_collectivite.php',
                type: 'POST',
                data: {
                    'code_secteur': code_secteur,
                    'code': code,
                    'code_externe': code_externe,
                    'raison_sociale': raison_sociale,
                    'pays': code_pays,
                    'region': code_region,
                    'departement': code_departement,
                    'commune': code_commune,
                    'adresse_postale': adresse_postale,
                    'adresse_geographique': adresse_geographique,
                    'latitude': latitude,
                    'longitude': longitude

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_collectivite").hide();
                        $("#p_collectivite_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="?code="+data['code'];
                        }, 5000);
                    } else {
                        $("#p_collectivite_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_secteur) {
                $("#code_secteur_input").addClass('is-invalid');
                $("#codeSecteurHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le secteur d'activité s'il vous plait.");
            }
            if(!raison_sociale) {
                $("#raison_sociale_input").addClass('is-invalid');
                $("#raisonSocialeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la raison sociale s'il vous plait.");
            }
            if(!code_pays) {
                $("#pays_input").addClass('is-invalid');
                $("#paysHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le pays s'il vous plait.");
            }
            if(!code_region) {
                $("#region_input").addClass('is-invalid');
                $("#regionHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la region s'il vous plait.");
            }
            if(!code_departement) {
                $("#departement_input").addClass('is-invalid');
                $("#departementHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le departement s'il vous plait.");
            }
            if(!code_commune) {
                $("#commune_input").addClass('is-invalid');
                $("#communeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la commune s'il vous plait.");
            }
        }
        return false;
    });

    $("#form_search_collectivites").submit(function () {
        let code_secteur    = $("#code_secteur_collectivite_input").val().trim(),
            code            = $("#code_collectivite_input").val().trim(),
            raison_sociale  = $("#raison_sociale_collectivite_input").val().trim();
        if(code_secteur || code || raison_sociale) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_collectivites.php',
                type: 'POST',
                data: {
                    'code_secteur': code_secteur,
                    'code': code,
                    'raison_sociale': raison_sociale
                },
                success: function (data) {
                    $("#btn_search").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .html('<i class="bi bi-search"></i>');
                    $("#div_resultats").html(data);
                }
            });
        }
        return false;
    });
});