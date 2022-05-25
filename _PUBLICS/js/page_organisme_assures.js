jQuery(function () {

    $("#code_pays_naissance_input").change(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_region_naissance_input").prop('disabled',false)
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
                    $("#code_region_naissance_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_region_naissance_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_pays_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePaysNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_pays_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codePaysNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#code_region_naissance_input").change(function () {
        let code_region     = $(this).val().trim(),
            code_pays     = $("#code_pays_naissance_input").val().trim();

        if(code_region) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_departement_naissance_input").prop('disabled',false)
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
                    $("#code_departement_naissance_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_departement_naissance_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_region_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeRegionNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_region_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeRegionNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une region SVP.");
        }
    });
    $("#code_departement_naissance_input").change(function () {
        let code_departement     = $(this).val().trim(),
            code_pays     = $("#code_pays_naissance_input").val().trim(),
            code_region     = $("#code_region_naissance_input").val().trim();
        if(code_departement) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_commune_naissance_input").prop('disabled',false)
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
                    $("#code_commune_naissance_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_commune_naissance_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_departement_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeDepartementNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_departement_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeDepartementNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#code_commune_naissance_input").change(function () {
        let commune     = $(this).val().trim();
        if(commune) {
            $("#code_commune_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeCommuneNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_commune_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeCommuneNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner la commune SVP.");
        }
    });

    $("#code_pays_residence_input").change(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_region_residence_input").prop('disabled',false)
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
                    $("#code_region_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_region_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_pays_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePaysResidenceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_pays_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codePaysResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#code_region_residence_input").change(function () {
        let code_region     = $(this).val().trim(),
            code_pays     = $("#code_pays_residence_input").val().trim();

        if(code_region) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_departement_residence_input").prop('disabled',false)
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
                    $("#code_departement_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_departement_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_region_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeRegionResidenceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_region_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeRegionResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une region SVP.");
        }
    });
    $("#code_departement_residence_input").change(function () {
        let code_departement     = $(this).val().trim(),
            code_pays     = $("#code_pays_residence_input").val().trim(),
            code_region     = $("#code_region_residence_input").val().trim();
        if(code_departement) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_commune_residence_input").prop('disabled',false)
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
                    $("#code_commune_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_commune_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_departement_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeDepartementResidenceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_departement_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeDepartementResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#code_commune_residence_input").change(function () {
        let commune     = $(this).val().trim();
        if(commune) {
            $("#code_commune_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeCommuneResidenceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_commune_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeCommuneResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner la commune SVP.");
        }
    });


    $("#raison_sociale_collectivite_search_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_contrats_collectivites.php", {
                        raison_sociale: $('#raison_sociale_collectivite_search_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_collectivite_search_input").val(ui.item.value);
                $("#raison_sociale_collectivite_search_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#code_collectivite_search_input").val('');
        })
        .blur(function () {
            let code = $("#code_collectivite_search_input").val();
            if(!code) {
                $("#raison_sociale_collectivite_search_input").val('');
            }
        });

    $("#form_search_assures").submit(function () {
        let num_population      = $("#num_population_search_input").val().trim(),
            num_secu            = $("#num_secu_search_input").val().trim(),
            nom_prenoms         = $("#nom_prenoms_input").val().trim(),
            code_collectivite   = $("#code_collectivite_search_input").val().trim();
        if(num_population || num_secu || nom_prenoms || code_collectivite) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Assures/search_assures.php',
                type: 'POST',
                data: {
                    'num_population': num_population,
                    'num_secu': num_secu,
                    'nom_prenoms': nom_prenoms,
                    'code_collectivite': code_collectivite
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

    $("#form_assure").submit(function () {
        let nip                         = $ ("#nip_input").val().trim(),
            num_rgb                     = $ ("#num_rgb_input").val().trim(),
            code_civilite               = $ ("#code_civilite_input").val().trim(),
            prenoms                     = $ ("#prenoms_input").val().trim().toUpperCase(),
            nom                         = $ ("#nom_input").val().trim().toUpperCase(),
            nom_patronymique            = $ ("#nom_patronymique_input").val().trim().toUpperCase(),
            date_naissance              = $ ("#date_naissance_input").val().trim(),
            code_sexe                   = $ ("#code_sexe_input").val().trim(),
            situation_matrimoniale      = $ ("#situation_matrimoniale_input").val().trim(),
            code_nationnalite           = $ ("#code_nationnalite_input").val().trim(),
            code_pays_naissance         = $ ("#code_pays_naissance_input").val().trim(),
            code_region_naissance       = $ ("#code_region_naissance_input").val().trim(),
            code_departement_naissance  = $ ("#code_departement_naissance_input").val().trim(),
            code_commune_naissance      = $ ("#code_commune_naissance_input").val().trim(),
            lieu_naissance              = $ ("#lieu_naissance_input").val().trim(),

            code_pays_residence         = $ ("#code_pays_residence_input").val().trim(),
            code_region_residence       = $ ("#code_region_residence_input").val().trim(),
            code_departement_residence  = $ ("#code_departement_residence_input").val().trim(),
            code_commune_residence      = $ ("#code_commune_residence_input").val().trim(),
            adresse_postale             = $ ("#adresse_postale_input").val().trim(),
            adresse_geographique        = $ ("#adresse_geographique_input").val().trim();


        if(code_civilite && prenoms && prenoms.length >= 2 && nom && nom.length >= 2 && date_naissance && code_sexe && situation_matrimoniale && code_nationnalite && code_pays_naissance && code_pays_residence && code_region_residence && code_departement_residence && code_commune_residence) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Assures/submit_edition_assure.php',
                type: 'POST',
                data: {
                    'nip': nip,
                    'num_rgb': num_rgb,
                    'code_civilite': code_civilite,
                    'prenoms': prenoms,
                    'nom': nom,
                    'nom_patronymique': nom_patronymique,
                    'date_naissance': date_naissance,
                    'code_sexe': code_sexe,
                    'situation_matrimoniale': situation_matrimoniale,
                    'code_nationnalite': code_nationnalite,
                    'code_pays_naissance': code_pays_naissance,
                    'code_region_naissance': code_region_naissance,
                    'code_departement_naissance': code_departement_naissance,
                    'code_commune_naissance': code_commune_naissance,
                    'lieu_naissance': lieu_naissance,
                    'code_pays_residence': code_pays_residence,
                    'code_region_residence': code_region_residence,
                    'code_departement_residence': code_departement_residence,
                    'code_commune_residence': code_commune_residence,
                    'adresse_postale': adresse_postale,
                    'adresse_geographique': adresse_geographique
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_assure").hide();
                        $("#p_assure_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../assures/?num="+data['num_population'];
                        }, 2000);
                    } else {
                        $("#p_assure_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if (!code_civilite) {
                $("#code_civilite_input").addClass('is-invalid');
                $("#codeCiviliteHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la civilité de l'assuré vous plait.");
            }
            if (!prenoms || prenoms.length < 2) {
                $("#prenoms_input").addClass('is-invalid');
                $("#prenomsHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le prénom de l'assuré vous plait.");
            }
            if (!nom || nom.length < 2) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom de l'assuré vous plait.");
            }
            if (!date_naissance) {
                $("#date_naissance_input").addClass('is-invalid');
                $("#dateNaissanceHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date de naissance de l'assuré vous plait.");
            }
            if (!code_sexe) {
                $("#code_sexe_input").addClass('is-invalid');
                $("#codeSexeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le sexe de l'assuré vous plait.");
            }
            if (!situation_matrimoniale) {
                $("#situation_matrimoniale_input").addClass('is-invalid');
                $("#situationMatrimonialeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la situation matrimoniale de l'assuré vous plait.");
            }
            if (!code_nationnalite) {
                $("#code_nationnalite_input").addClass('is-invalid');
                $("#codeNationnaliteHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la nationalité de l'assuré vous plait.");
            }
            if (!code_pays_naissance) {
                $("#code_pays_naissance_input").addClass('is-invalid');
                $("#codePaysNaissanceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le lieu de naissance de l'assuré vous plait.");
            }
            if (!code_pays_residence) {
                $("#code_pays_residence_input").addClass('is-invalid');
                $("#codePaysResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le pays de résidence de l'assuré vous plait.");
            }
            if (!code_region_residence) {
                $("#code_region_residence_input").addClass('is-invalid');
                $("#codeRegionResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la région de résidence de l'assuré vous plait.");
            }
            if (!code_departement_residence) {
                $("#code_departement_residence_input").addClass('is-invalid');
                $("#codeDepartementResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le département de résidence de l'assuré vous plait.");
            }
            if (!code_commune_residence) {
                $("#code_commune_residence_input").addClass('is-invalid');
                $("#codeCommuneResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la commune de résidence de l'assuré vous plait.");
            }
        }


        return false;
    });

    $("#code_type_coordonnee_input").change(function () {
        let code = $(this).val().trim(),
            code_telephone = ['MOBPER','MOBPRO','TELFAX','TELPRO'],
            code_email = ['MELPER','MELPRO'],
            code_web = ['SITWEB'];

        if (code_telephone.includes(code)) {
            $("#valeur_assure_coordonnee_input")
                .prop('disabled',false)
                .attr('type','tel')
                .attr('maxLength','10')
                .val('')
                .focus();
        } else if (code_email.includes(code)) {
            $("#valeur_assure_coordonnee_input")
                .prop('disabled',false)
                .attr('type','email')
                .attr('maxLength','100')
                .val('')
                .focus();
        } else if (code_web.includes(code)) {
            $("#valeur_assure_coordonnee_input")
                .prop('disabled',false)
                .attr('type','url')
                .attr('maxLength','150')
                .val('')
                .focus();
        } else {
            $("#valeur_assure_coordonnee_input")
                .prop('disabled',true)
                .val('');
        }
    });
    $("#form_assure_coordonnee").submit(function () {
        let num_assure = $("#photo_num_assure_input").val().trim(),
            type        = $("#code_type_coordonnee_input").val().trim(),
            valeur      = $("#valeur_assure_coordonnee_input").val().trim();

        if (num_assure && type && valeur) {
            $("#button_assure_coordonnees_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Assures/submit_coordonnee.php',
                type: 'POST',
                data: {
                    'num_assure': num_assure,
                    'type': type,
                    'valeur': valeur,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_assure_coordonnees_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_assure_coordonnee").hide();
                        $("#p_assure_coordonnee_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        },2000);
                    } else {
                        $("#p_assure_coordonnee_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!type) {
                $("#code_type_coordonnee_input").addClass('is-invalid');
                $("#typeCoordHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de coordonnée s'il vous plait.");
            }
            if (!valeur) {
                $("#valeur_ets_coordonnee_input").addClass('is-invalid');
                $("#valeurCoordonneeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la valeur de la coordonnée s'il vous plait.");
            }
        }
        return false;
    });

    $("#form_assure_photo").submit(function () {
        let form_data = new FormData(this);
        $("#button_enregistrer_photo").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Organisme/Assures/submit_photo.php',
            type: 'POST',
            data: form_data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $("#button_enregistrer_photo").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_assure_photo").hide();
                    $("#p_assure_photo_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload();
                    },2000);
                } else {
                    $("#p_assure_photo_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
        return false;
    });

    $(".button_lister_ouvrant_ayant_droits").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            code_contrat = tableau[0],
            nip_contractant = tableau[1],
            code_qualite_civile = tableau[2];
        if(code_contrat && nip_contractant && code_qualite_civile) {
            if(code_qualite_civile === 'PAY') {
                $("#ayantOuvrantDroitsModalLabel").html("Liste des bénéficiaires");
            } else {
                $("#ayantOuvrantDroitsModalLabel").html("Identité du souscripteur");
            }
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Assures/search_ouvrant_ayants_droits.php',
                type: 'POST',
                data: {
                    'code_contrat': code_contrat,
                    'nip_contractant': nip_contractant,
                    'code_qualite_civile': code_qualite_civile
                },
                success: function (data) {
                    $("#ayantOuvrantDroitsModalBody").html(data);
                }
            });
        }
    });
});

$(".date").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    maxDate: 0,
    lang: 'fr'
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});