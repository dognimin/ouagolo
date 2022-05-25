jQuery(function () {

    $("#form_search_etablissement").submit(function () {
        let code            = $('#code_search_input').val().trim(),
            raison_sociale  = $('#raison_sociale_search_input').val().trim(),
            niveau          = $('#niveau_input').val().trim(),
            type            = $('#type_input').val().trim();

        if(code || raison_sociale || niveau || type) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Searches/Etablissements/search_etablissements.php',
                type: 'post',
                data: {
                    'code': code,
                    'raison_sociale': raison_sociale,
                    'niveau': niveau,
                    'type': type
                },
                success: function(data) {
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
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#editionModal").hide();
        $("#serviceModal").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $(".btn_add").click(function () {
        $("#div_resultats").hide();
        $("#div_utilisateur").slideDown();
        $(".card-title").html('Nouvel Utilisateur');
        return false;
    });
    $(".btn_edit").click(function () {
        $("#div_resultats").hide();
        $("#div_detail").hide();
        $("#div_utilisateur").slideDown();

        $(".card-title").html('Edition Utilisateur');
        return false;

    });

    $(".btn_edit_coord").click(function () {
        $("#coordonneesModal").slideDown();

        $(".card-title").html('Edition Utilisateur');
        return false;

    });
    $("#code_etablissement_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_etablissement_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeEtablissementHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_etablissement_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeEtablissementHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });
    $("#raison_sociale_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#raison_sociale_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#raisonSocialeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#raison_sociale_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#raisonSocialeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la raison sociale SVP.");
        }
    });
    $("#type_etablissement_input").change(function () {
        let type     = $(this).val().trim();
        if(type) {
            $("#type_etablissement_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#typeEtablissementHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#type_etablissement_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#typeEtablissementHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un type  SVP.");
        }
    });

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
                url: '../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
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
                url: '../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
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
                url: '../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
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
                url: '../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement.php',
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
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement").hide();
                        $("#p_etablissement_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="?code="+data['code'];
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
            url: '../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement_logo.php',
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


    $("#btn_types_etablissements").click(function () {
        display_types_etablissements();
    });

    $("#btn_niveaux_sanitaires").click(function () {
        display_niveaux_sanitaires();
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
            display_ets_coordonnees(1, code);
        }
    });
    $("#button_ets_ps").click(function () {
        let code = $("#code_input").val().trim();
        if(code) {
            $(".button_ets")
                .prop('disabled',false)
                .removeClass('btn-outline-secondary')
                .addClass('btn-secondary');
            $("#button_ets_ps")
                .prop('disabled',true)
                .removeClass('btn-secondary')
                .addClass('btn-outline-secondary');
            display_ets_professionnels_sante('../',code);
        }
    });
    $("#button_ets_utilisateurs").click(function () {
        let code = $("#code_input").val().trim();
        if(code) {
            $(".button_ets")
                .prop('disabled',false)
                .removeClass('btn-outline-secondary')
                .addClass('btn-secondary');
            $("#button_ets_utilisateurs")
                .prop('disabled',true)
                .removeClass('btn-secondary')
                .addClass('btn-outline-secondary');
            display_ets_utilisateurs(1,code);
        }
    });
    $("#button_ets_services").click(function () {
        let code = $("#code_input").val().trim();
        if(code) {
            $(".button_ets")
                .prop('disabled',false)
                .removeClass('btn-outline-secondary')
                .addClass('btn-secondary');
            $("#button_ets_services")
                .prop('disabled',true)
                .removeClass('btn-secondary')
                .addClass('btn-outline-secondary');
            display_ets_services(1, code);
        }
    });

});

$('.modal').modal({
    show: false,
    backdrop: 'static'
});