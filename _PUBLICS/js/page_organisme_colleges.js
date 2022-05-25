jQuery(function () {
    $("#nom_police_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/Polices/search_json_polices.php", {
                        raison_sociale: $('#nom_police_input').val().toUpperCase()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#id_police_input").val(ui.item.value);
                $("#nom_police_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#id_police_input").val('');
        })
        .blur(function () {
            let code = $("#id_police_input").val();
            if(!code || code.length !== 24) {
                $("#id_police_input").val('');
                $("#nom_police_input").val('');
            }
        });


    $("#form_college").submit(function () {
        let num_police          = $("#num_police_input").val().trim(),
            code                = $("#code_input").val().trim(),
            libelle             = $("#libelle_input").val().trim(),
            description         = $("#description_input").val().trim();
        if(num_police && libelle) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Colleges/submit_edition_college.php',
                type: 'POST',
                data: {
                    'num_police': num_police,
                    'code': code,
                    'libelle': libelle,
                    'description': description
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_college").hide();
                        $("#p_college_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../colleges/?id-police="+num_police+"&code="+data['code'];
                        }, 2000);
                    } else {
                        $("#p_college_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else {
            if (!code_collectivite) {
                $("#code_collectivite_input").addClass('is-invalid');
                $("#codeCollectiviteHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la collectivité s'il vous plait.");
            }
            if (!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le libellé s'il vous plait.");
            }
            if (!taux_couverture) {
                $("#taux_couverture_input").addClass('is-invalid');
                $("#tauxCouvertureHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le taux de couverture s'il vous plait.");
            }
            if (!montant_prime) {
                $("#montant_prime_input").addClass('is-invalid');
                $("#montantPrimeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le montant de la prime s'il vous plait.");
            }
            if (!montant_plafond) {
                $("#montant_plafond_input").addClass('is-invalid');
                $("#montantPlafondHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le montant du plafond s'il vous plait.");
            }
            if (!date_debut) {
                $("#date_debut_input").addClass('is-invalid');
                $("#dateDebutHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la date de début s'il vous plait.");
            }
            if (!date_fin) {
                $("#date_fin_input").addClass('is-invalid');
                $("#dateFinHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la date de fin s'il vous plait.");
            }
        }
        return false;
    });

    $("#form_search_colleges").submit(function () {
        let annee           = $("#annee_input").val().trim(),
            raison_sociale  = $("#raison_sociale_collectivite_recherche_input").val().trim();
        if(annee || raison_sociale) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Colleges/search_colleges.php',
                type: 'POST',
                data: {
                    'annee': annee,
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

    $("#form_organisme_college_reseau").submit(function () {
        let code_reseau = $("#code_reseau_input").val().trim(),
            num_college = $("#strong_num_college").html().trim();
        if(code_reseau && num_college) {
            $("#button_enregistrer_reseau").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Colleges/submit_edition_college_reseau.php',
                type: 'POST',
                data: {
                    'code_reseau': code_reseau,
                    'num_college': num_college
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_reseau").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_organisme_college_reseau").hide();
                        $("#p_organisme_college_reseau_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $("#p_organisme_college_reseau_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#button_lister").click(function () {
        $("form")[0].reset();
        $("#div_affiche_details").hide();
        $("#div_ajout_assure").hide();
        $("#div_recherche_assures").slideDown();
        return false;
    });
    $(".button_ajout").click(function () {
        $("form")[0].reset();
        $("#div_affiche_details").hide();
        $("#div_recherche_assures").hide();
        $("#div_ajout_assure").slideDown();
        return false;
    });
    $(".button_college_retourner").click(function () {
        $("form")[0].reset();
        $("#div_ajout_assure").hide();
        $("#div_recherche_assures").hide();
        $("#div_affiche_details").slideDown();
        return false;
    });

    $("#code_qualite_civile_input").change(function () {
        $("#codeQualiteCivileHelp").html('');
        let code_qualite_civile = $(this).val().trim();
        if(code_qualite_civile) {
            $("#code_qualite_civile_input").removeClass('is-invalid').addClass('is-valid');
            if(code_qualite_civile === 'PAY') {
                $("#num_ip_payeur_input").val('').prop('disabled', true);
            }else {
                $("#num_ip_payeur_input").val('').prop('disabled', false);
            }
        }else {
            $("#code_qualite_civile_input").removeClass('is-valid').addClass('is-invalid');
        }
    });
    $("#code_civilite_input").change(function () {
        $("#codeSexeHelp").html('');
        $("#codeCiviliteHelp").html('');
        let code_civilite = $(this).val().trim();
        if(code_civilite) {
            $("#code_civilite_input").removeClass('is-invalid').addClass('is-valid');
            if(code_civilite === 'M') {
                $("#code_sexe_input").val('M').removeClass('is-invalid').addClass('is-valid');
            }else {
                $("#code_sexe_input").val('F').removeClass('is-invalid').addClass('is-valid');
            }
        }else {
            $("#code_civilite_input").removeClass('is-valid').addClass('is-invalid');
            $("#code_sexe_input").val('').removeClass('is-valid').addClass('is-invalid');
        }
    });
    $("#code_sexe_input").change(function () {
        $("#codeCiviliteHelp").html('');
        $("#codeSexeHelp").html('');
        let code_sexe = $(this).val().trim();
        if(code_sexe) {
            $("#code_sexe_input").removeClass('is-invalid').addClass('is-valid');
            if(code_sexe === 'M') {
                $("#code_civilite_input").val('M').removeClass('is-invalid').addClass('is-valid');
            }else {
                $("#code_civilite_input").val('').removeClass('is-valid').addClass('is-invalid');
            }
        }else {
            $("#code_sexe_input").val('').removeClass('is-valid').addClass('is-invalid');
            $("#code_civilite_input").removeClass('is-valid').addClass('is-invalid');
        }
    });

    $("#prenoms_input").keyup(function () {
        let prenoms = $(this).val().trim();
        if(prenoms.length >= 2) {
            $("#prenoms_input").removeClass('is-invalid').addClass('is-valid');
            $("#prenomsHelp").html('');
        } else {
            $("#prenoms_input").removeClass('is-valid').addClass('is-invalid');
            $("#prenomsHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le prénom de l'assuré vous plait.");
        }
    });
    $("#nom_input").keyup(function () {
        let nom = $(this).val().trim();
        if(nom.length >= 2) {
            $("#nom_input").removeClass('is-invalid').addClass('is-valid');
            $("#nomHelp").html('');
        } else {
            $("#nom_input").removeClass('is-valid').addClass('is-invalid');
            $("#nomHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le nom de l'assuré vous plait.");
        }
    });


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

    $("#form_assure_college").submit(function () {
        let num_college                 = $("#strong_num_college").html(),
            code_qualite_civile         = $("#code_qualite_civile_input").val().trim(),
            nip                         = $ ("#nip_input").val().trim(),
            num_ip_payeur               = $ ("#num_ip_payeur_input").val().trim(),
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
            code_csp                    = $ ("#code_csp_input").val().trim(),
            code_secteur_activite       = $ ("#code_secteur_activite_input").val().trim(),
            num_matricule               = $ ("#num_matricule_input").val().trim(),
            code_profession             = $ ("#code_profession_input").val().trim(),

            code_pays_residence         = $ ("#code_pays_residence_input").val().trim(),
            code_region_residence       = $ ("#code_region_residence_input").val().trim(),
            code_departement_residence  = $ ("#code_departement_residence_input").val().trim(),
            code_commune_residence      = $ ("#code_commune_residence_input").val().trim(),
            adresse_postale             = $ ("#adresse_postale_input").val().trim(),
            adresse_geographique        = $ ("#adresse_geographique_input").val().trim();
        if(num_college && code_qualite_civile && code_civilite && prenoms && prenoms.length >= 2 && nom && nom.length >= 2 && date_naissance && code_sexe && situation_matrimoniale && code_nationnalite && code_pays_naissance && code_csp && code_pays_residence && code_region_residence && code_departement_residence && code_commune_residence) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Colleges/submit_edition_assure.php',
                type: 'POST',
                data: {
                    'num_college': num_college,
                    'code_qualite_civile': code_qualite_civile,
                    'nip': nip,
                    'num_ip_payeur': num_ip_payeur,
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
                    'code_csp': code_csp,
                    'code_secteur_activite': code_secteur_activite,
                    'num_matricule': num_matricule,
                    'code_profession': code_profession,
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
                        $("#form_assure_college").hide();
                        $("#p_assure_college_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../assures/?num="+data['num_population'];
                        }, 2000);
                    } else {
                        $("#p_assure_college_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if (!code_qualite_civile) {
                $("#code_qualite_civile_input").addClass('is-invalid');
                $("#codeQualiteCivileHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type d'assuré vous plait.");
            }
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
            if (!code_csp) {
                $("#code_csp_input").addClass('is-invalid');
                $("#codeCSPHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la CSP de l'assuré vous plait.");
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

    $("#form_college_produit").submit(function () {
        let num_college     = $("#strong_num_college").html(),
            code_produit    = $("#code_produit_input").val().trim();
        if(num_college && code_produit) {
            $("#button_produit_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Colleges/submit_college_produit.php',
                type: 'POST',
                data: {
                    'num_college': num_college,
                    'code_produit': code_produit
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_produit_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_college_produit").hide();
                        $("#p_college_produit_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_college_produit_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $(".button_college_statut").click(function () {
        let statut = this.id.toUpperCase();
        $("#code_college_statut_input").val(statut).prop('disabled', true);
        if(statut === 'ACT') {
            $("#div_college_motif").hide();
            $("#college_motif_input").val("College ACTIVE");
        }else {
            $("#div_college_motif").show();
            $("#college_motif_input").val("");
        }
    });

    $("#college_motif_input").keyup(function () {
        let motif = $(this).val().trim();
        if(motif.length >= 3) {
            $("#college_motif_input").removeClass('is-invalid').addClass('is-valid');
            $("#collegeMotifHelp").html('');
        } else {
            $("#college_motif_input").removeClass('is-valid').addClass('is-invalid');
            $("#collegeMotifHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le motif vous plait.");
        }
    });

    $("#form_college_statut").submit(function () {
        let id_police       = $("#strong_id_police").html(),
            code_college    = $("#strong_num_college").html(),
            code_statut     = $("#code_college_statut_input").val().trim(),
            motif           = $("#college_motif_input").val().trim().toUpperCase();
        if(id_police && code_college && code_statut && motif) {
            $("#button_statut_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Colleges/submit_college_statut.php',
                type: 'POST',
                data: {
                    'id_police': id_police,
                    'code_college': code_college,
                    'code_statut': code_statut,
                    'motif': motif
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_statut_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_college_statut").hide();
                        $("#p_college_statut_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_college_statut_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else {
            if (!motif) {
                $("#college_motif_input").addClass('is-invalid');
                $("#collegeMotifHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le motif vous plait.");
            }
        }
        return false;
    });
});
$("#table_assures").dataTable();
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