jQuery(function () {
    $("#form_search_patients").submit(function () {
        let num_secu    = $("#num_secu_search_input").val().trim(),
            nip         = $("#nip_search_input").val().trim(),
            nom_prenom  = $("#nom_prenom_search_input").val().trim().toUpperCase();
        if (num_secu || nip || nom_prenom) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Patients/search_patients.php',
                type: 'POST',
                data: {
                    'num_secu': num_secu,
                    'nip': nip,
                    'nom_prenom': nom_prenom
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
    $("#code_civilite_input").change(function () {
        $("#codeSexeHelp").html('');
        $("#codeCiviliteHelp").html('');
        let code_civilite = $(this).val().trim();
        if (code_civilite) {
            $("#code_civilite_input").removeClass('is-invalid').addClass('is-valid');
            if (code_civilite === 'M') {
                $("#code_sexe_input").val('M').removeClass('is-invalid').addClass('is-valid');
            } else {
                $("#code_sexe_input").val('F').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $("#code_civilite_input").removeClass('is-valid').addClass('is-invalid');
            $("#code_sexe_input").val('').removeClass('is-valid').addClass('is-invalid');
        }
    });
    $("#code_sexe_input").change(function () {
        $("#codeCiviliteHelp").html('');
        $("#codeSexeHelp").html('');
        let code_sexe = $(this).val().trim();
        if (code_sexe) {
            $("#code_sexe_input").removeClass('is-invalid').addClass('is-valid');
            if (code_sexe === 'M') {
                $("#code_civilite_input").val('M').removeClass('is-invalid').addClass('is-valid');
            } else {
                $("#code_civilite_input").val('').removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $("#code_sexe_input").val('').removeClass('is-valid').addClass('is-invalid');
            $("#code_civilite_input").removeClass('is-valid').addClass('is-invalid');
        }
    });

    $("#code_pays_residence_input").change(function () {
        let code_pays     = $(this).val().trim();
        if (code_pays) {
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
                success: function (json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_region_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function (index, value) {
                        $("#code_region_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_pays_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePaysResidenceHelp")
                .removeClass('text-danger')
                .html("");
        } else {
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

        if (code_region) {
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
                success: function (json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_departement_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function (index, value) {
                        $("#code_departement_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_region_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeRegionResidenceHelp")
                .removeClass('text-danger')
                .html("");
        } else {
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
        if (code_departement) {
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
                success: function (json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_commune_residence_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function (index, value) {
                        $("#code_commune_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_departement_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeDepartementResidenceHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#code_departement_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeDepartementResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#code_commune_residence_input").change(function () {
        let commune     = $(this).val().trim();
        if (commune) {
            $("#code_commune_residence_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeCommuneResidenceHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#code_commune_residence_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeCommuneResidenceHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner la commune SVP.");
        }
    });

    $("#raison_sociale_collectivite_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_polices.php", {
                    raison_sociale: $('#raison_sociale_collectivite_input').val()
                    }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_collectivite_input").val(ui.item.value);
            $("#raison_sociale_collectivite_input").val(ui.item.label);
            return false;
        }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_collectivite_input").val('');
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_collectivite_input").val();
            if (!code) {
                $("#raison_sociale_collectivite_input").val('');
            }
        });

    $("#num_assure_input").keyup(function () {
        let num_assure      = $(this).val().trim(),
            code_organisme  = $("#code_organisme_input").val().trim();
        if(code_organisme && num_assure.length === 16) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Patients/search_patient.php',
                type: 'POST',
                data: {
                    'code_organisme': code_organisme,
                    'num_assure': num_assure,
                    'num_secu': null
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#nip_input").val(data['nip']);
                        $("#code_civilite_input").val(data['code_civilite']);
                        $("#nom_input").val(data['nom']);
                        $("#nom_patronymique_input").val(data['nom_patronymique']);
                        $("#prenom_input").val(data['prenoms']);
                        $("#date_naissance_input").val(data['date_naissance']);
                        $("#code_sexe_input").val(data['code_sexe']);
                        $("#code_situation_matrimoniale_input").val(data['code_situation_familiale']);
                        $("#code_pays_residence_input").val(data['code_pays_residence']);

                        $("#code_region_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_regions'], function (index, value) {
                            if (index === data['code_region_residence']) {
                                $("#code_region_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_region_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#code_departement_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_departements'], function (index, value) {
                            if (index === data['code_departement_residence']) {
                                $("#code_departement_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_departement_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#code_commune_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_communes'], function (index, value) {
                            if (index === data['code_commune_residence']) {
                                $("#code_commune_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_commune_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#adresse_postale_input").val(data['adresse_postale']);
                        $("#adresse_georaphique_input").val(data['adresse_geographique']);
                    } else {
                        $("#p_patient_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            if(!code_organisme) {
                $("#code_organisme_input").removeClass('is-valid').addClass('is-invalid');
                $("#codeOrganismeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner l'organisme s'il vous plait.");
            }

            $("#nip_input").val('');
            $("#num_secu_input").val('');
            $("#code_civilite_input").val('').removeClass('is-valid');
            $("#nom_input").val('');
            $("#nom_patronymique_input").val('');
            $("#prenom_input").val('');
            $("#date_naissance_input").val('');
            $("#code_sexe_input").val('').removeClass('is-valid');
            $("#code_situation_matrimoniale_input").val('').removeClass('is-valid');
            $("#code_pays_residence_input").val('').removeClass('is-valid');
            $("#code_region_residence_input").val('').removeClass('is-valid');
            $("#code_departement_residence_input").val('').removeClass('is-valid');
            $("#code_commune_residence_input").val('').removeClass('is-valid');
            $("#adresse_postale_input").val('');
            $("#adresse_georaphique_input").val('');
        }
    });

    $("#num_secu_input").keyup(function () {
        let num_secu = $(this).val().trim();
        if(num_secu.length === 13) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Patients/search_patient.php',
                type: 'POST',
                data: {
                    'num_secu': num_secu,
                    'code_organisme': null,
                    'num_assure': null
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#nip_input").val(data['nip']);
                        $("#code_civilite_input").val(data['code_civilite']);
                        $("#nom_input").val(data['nom']);
                        $("#nom_patronymique_input").val(data['nom_patronymique']);
                        $("#prenom_input").val(data['prenoms']);
                        $("#date_naissance_input").val(data['date_naissance']);
                        $("#code_sexe_input").val(data['code_sexe']);
                        $("#code_situation_matrimoniale_input").val(data['code_situation_familiale']);
                        $("#code_pays_residence_input").val(data['code_pays_residence']);

                        $("#code_region_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_regions'], function (index, value) {
                            if (index === data['code_region_residence']) {
                                $("#code_region_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_region_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#code_departement_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_departements'], function (index, value) {
                            if (index === data['code_departement_residence']) {
                                $("#code_departement_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_departement_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#code_commune_residence_input").empty().append('<option value="">Sélectionnez</option>');
                        $.each(data['liste_communes'], function (index, value) {
                            if (index === data['code_commune_residence']) {
                                $("#code_commune_residence_input").append('<option value="'+ index +'" selected>'+ value +'</option>');
                            } else {
                                $("#code_commune_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                            }
                        });

                        $("#adresse_postale_input").val(data['adresse_postale']);
                        $("#adresse_georaphique_input").val(data['adresse_geographique']);
                    } else {
                        $("#p_patient_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            $("#nip_input").val('');
            $("#code_civilite_input").val('').removeClass('is-valid');
            $("#nom_input").val('');
            $("#nom_patronymique_input").val('');
            $("#prenom_input").val('');
            $("#date_naissance_input").val('');
            $("#code_sexe_input").val('').removeClass('is-valid');
            $("#code_situation_matrimoniale_input").val('').removeClass('is-valid');
            $("#code_pays_residence_input").val('').removeClass('is-valid');
            $("#code_region_residence_input").val('').removeClass('is-valid');
            $("#code_departement_residence_input").val('').removeClass('is-valid');
            $("#code_commune_residence_input").val('').removeClass('is-valid');
            $("#adresse_postale_input").val('');
            $("#adresse_georaphique_input").val('');
        }
    });

    $("#code_organisme_input").change(function () {
        let code_organisme = $(this).val();
        if(code_organisme) {
            $("#code_organisme_input").removeClass('is-invalid').addClass('is-valid');
            $("#codeOrganismeHelp").html('');
            if (code_organisme === 'ORG00001') {
                $("#num_assure_input")
                    .empty()
                    .prop('disabled', true)
                    .prop('required', false).val('');
            } else {
                $("#num_assure_input")
                    .prop('disabled', false)
                    .prop('required', true).val('');
            }
        } else {
            $("#code_organisme_input").removeClass('is-valid').addClass('is-invalid');
            $("#codeOrganismeHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner l'organisme s'il vous plait.");
        }
    });

    $("#form_patient").submit(function () {
        let nip                         = $("#nip_input").val().trim(),
            num_secu                    = $("#num_secu_input").val().trim(),
            code_civilite               = $("#code_civilite_input").val().trim(),
            nom                         = $("#nom_input").val().trim().toUpperCase(),
            nom_patronymique            = $("#nom_patronymique_input").val().trim().toUpperCase(),
            prenom                      = $("#prenom_input").val().trim().toUpperCase(),
            date_naissance              = $("#date_naissance_input").val().trim(),
            code_sexe                   = $("#code_sexe_input").val().trim(),
            code_situation_matrimoniale = $("#code_situation_matrimoniale_input").val().trim(),
            code_pays_residence         = $("#code_pays_residence_input").val().trim(),
            code_region_residence       = $("#code_region_residence_input").val().trim(),
            code_departement_residence  = $("#code_departement_residence_input").val().trim(),
            code_commune_residence      = $("#code_commune_residence_input").val().trim(),
            adresse_postale             = $("#adresse_postale_input").val().trim().toUpperCase(),
            adresse_georaphique         = $("#adresse_georaphique_input").val().trim().toUpperCase();
        if (code_civilite && nom && nom.length >= 3 && prenom && prenom.length >= 3 && date_naissance && code_sexe && code_situation_matrimoniale && code_pays_residence && code_region_residence && code_departement_residence && code_commune_residence) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Patients/submit_edition_patient.php',
                type: 'POST',
                data: {
                    'nip': nip,
                    'num_secu': num_secu,
                    'code_civilite': code_civilite,
                    'nom': nom,
                    'nom_patronymique': nom_patronymique,
                    'prenom': prenom,
                    'date_naissance': date_naissance,
                    'code_sexe': code_sexe,
                    'code_situation_matrimoniale': code_situation_matrimoniale,
                    'code_pays_residence': code_pays_residence,
                    'code_region_residence': code_region_residence,
                    'code_departement_residence': code_departement_residence,
                    'code_commune_residence': code_commune_residence,
                    'adresse_postale': adresse_postale,
                    'adresse_georaphique': adresse_georaphique
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_patient").hide();
                        $("#p_patient_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            if (nip) {
                                window.location.reload();
                            } else {
                                window.location.href="?nip="+data['nip'].toLowerCase();
                            }
                        }, 3000);
                    } else {
                        $("#p_patient_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!code_civilite) {
                $("#code_civilite_input").addClass('is-invalid');
                $("#codeCiviliteHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la civilité s'il vous plait.");
            }
            if (!nom || nom.length < 3) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom s'il vous plait.");
            }
            if (!prenom || prenom.length < 3) {
                $("#prenom_input").addClass('is-invalid');
                $("#prenomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le prénom s'il vous plait.");
            }
            if (!date_naissance) {
                $("#date_naissance_input").addClass('is-invalid');
                $("#dateNaissanceHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date de naissance s'il vous plait.");
            }
            if (!code_sexe) {
                $("#code_sexe_input").addClass('is-invalid');
                $("#codeSexeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le sexe s'il vous plait.");
            }
            if (!code_situation_matrimoniale) {
                $("#code_situation_matrimoniale_input").addClass('is-invalid');
                $("#codeSituationMatrimonialeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la situation matrimoniale s'il vous plait.");
            }
            if (!code_pays_residence) {
                $("#code_pays_residence_input").addClass('is-invalid');
                $("#codePaysResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le pays de résidence s'il vous plait.");
            }
            if (!code_region_residence) {
                $("#code_region_residence_input").addClass('is-invalid');
                $("#codeRegionResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la région s'il vous plait.");
            }
            if (!code_departement_residence) {
                $("#code_departement_residence_input").addClass('is-invalid');
                $("#codeDepartementResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le département s'il vous plait.");
            }
            if (!code_commune_residence) {
                $("#code_commune_residence_input").addClass('is-invalid');
                $("#codeCommuneResidenceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la commune s'il vous plait.");
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
            $("#valeur_patient_coordonnee_input")
                .prop('disabled',false)
                .attr('type','tel')
                .attr('maxLength','10')
                .val('')
                .focus();
        } else if (code_email.includes(code)) {
            $("#valeur_patient_coordonnee_input")
                .prop('disabled',false)
                .attr('type','email')
                .attr('maxLength','100')
                .val('')
                .focus();
        } else if (code_web.includes(code)) {
            $("#valeur_patient_coordonnee_input")
                .prop('disabled',false)
                .attr('type','url')
                .attr('maxLength','150')
                .val('')
                .focus();
        } else {
            $("#valeur_patient_coordonnee_input")
                .prop('disabled',true)
                .val('');
        }
    });
    $("#form_patient_coordonnee").submit(function () {
        let num_patient = $("#num_patient_strong").html().trim(),
            type        = $("#code_type_coordonnee_input").val().trim(),
            valeur      = $("#valeur_patient_coordonnee_input").val().trim();

        if (num_patient && type && valeur) {
            $("#button_patient_coordonnees_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Patients/submit_coordonnee.php',
                type: 'POST',
                data: {
                    'num_patient': num_patient,
                    'type': type,
                    'valeur': valeur,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_patient_coordonnees_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_patient_coordonnee").hide();
                        $("#p_patient_coordonnee_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        },5000);
                    } else {
                        $("#p_patient_coordonnee_resultats").removeClass('alert alert-success')
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

    $("#form_patient_photo").submit(function () {
        let form_data = new FormData(this);
        $("#button_enregistrer_photo").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Etablissement/Patients/submit_photo.php',
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
                    $("#form_patient_photo").hide();
                    $("#p_patient_photo_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload();
                    },5000);
                } else {
                    $("#p_patient_photo_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
        return false;
    });

    $("#type_facture_input").change(function () {
        $("#code_acte_input").val('');
        $("#libelle_acte_input").val('');
        $("#prix_unitaire_acte_input").val(0);
        $("#quantite_acte_input").val(1);
    });

    $("#quantite_acte_input").change(function () {
        let prix_unitaire   = $("#prix_unitaire_acte_input").val(),
            quantite        = $(this).val(),
            montant_depense = (prix_unitaire * quantite);
        $("#montant_depense_acte_input").val(montant_depense);
    });

    $("#date_soins_input").change(function () {
        $("#code_assurance_input").val('');
        $("#num_assurance_input").val('').prop('disabled', false);
        $("#num_bon_input").val('');
        $("#taux_assurance_input").val(0).prop('disabled', false);
        $("#type_facture_input").val('');
        $("#code_acte_input").val('');
        $("#libelle_acte_input").val('');
        $("#prix_unitaire_acte_input").val(0);
        $("#quantite_acte_input").val(1);
        $("#montant_depense_acte_input").val(0);

        let date_soins  = $(this).val().trim(),
            nip         = $("#nip_dossier_input").val().trim();
        if(nip && date_soins) {
            $("#button_dossier_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Patients/search_patient_organismes.php',
                type: 'POST',
                data: {
                    'nip': nip,
                    'date_soins': date_soins
                },
                dataType: 'json',
                success: function (json) {
                    $("#button_dossier_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_assurance_input").empty().prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');

                    $.each(json, function (index, value) {
                        $("#code_assurance_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
        }
    });

    $("#code_assurance_input").change(function () {
        let code_assurance = $(this).val();
        if (code_assurance === 'ORG00001') {
            $("#num_assurance_input")
                .empty()
                .prop('disabled', true)
                .prop('required', false);
            $("#num_bon_input")
                .empty()
                .prop('disabled', true)
                .prop('required', false);
            $("#taux_assurance_input")
                .val(0)
                .prop('disabled', true)
                .prop('required', false);
        } else {
            let date_soins  = $("#date_soins_input").val().trim(),
                nip         = $("#nip_dossier_input").val().trim();
            if(code_assurance && nip && date_soins) {
                $("#button_dossier_enregistrer").prop('disabled', true)
                    .removeClass('btn-primary')
                    .addClass('btn-warning')
                    .html('<i>Recherche...</i>');
                $.ajax({
                    url: '../../_CONFIGS/Includes/Searches/Etablissement/Patients/search_patient_organisme.php',
                    type: 'POST',
                    data: {
                        'code_assurance': code_assurance,
                        'nip': nip,
                        'date_soins': date_soins
                    },
                    dataType: 'json',
                    success: function (data) {
                        $("#button_dossier_enregistrer").prop('disabled', false)
                            .removeClass('btn-warning')
                            .addClass('btn-primary')
                            .html('<i class="bi bi-save"></i> Enregistrer');
                        if(data['success'] === true) {
                            $("#num_assurance_input").val(data['num_police']).prop('disabled', true);
                            $("#taux_assurance_input").val(data['taux_couverture']).prop('disabled', true);
                        }else {
                            $("#num_assurance_input").val(data['num_police']).prop('disabled', false);
                            $("#taux_assurance_input").val(data['taux_couverture']).prop('disabled', false);
                        }

                    }
                });
            }
            $("#num_assurance_input")
                .prop('disabled', false)
                .prop('required', true);
            $("#num_bon_input")
                .prop('disabled', false)
                .prop('required', true);
            $("#taux_assurance_input")
                .prop('disabled', false)
                .prop('required', true);
        }
        console.log(code_assurance);
    });

    $("#libelle_acte_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_facture_actes.php", {
                    num_assure: $("#num_assurance_input").val().trim(),
                    code_assurance: $("#code_assurance_input").val().trim(),
                    libelle: $('#libelle_acte_input').val(),
                    date_soins: $("#date_soins_input").val(),
                    type_facture: $("#type_facture_input").val(),
                    code_ets: $("#code_ets_acte_input").val()
                }, response);
            },
            minLength: 2,
            select: function (e, ui) {
                $("#code_acte_input").val(ui.item.value);
                $("#libelle_acte_input").val(ui.item.label);
                $("#prix_unitaire_acte_input").val(ui.item.tarif);

                let prix_unitaire   = ui.item.tarif,
                    quantite        = $("#quantite_acte_input").val(),
                    montant_depense = (prix_unitaire * quantite);
                $("#montant_depense_acte_input").val(montant_depense);
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_acte_input").val('');
            $("#prix_unitaire_acte_input").val(0);
            $("#quantite_acte_input").val(1);
            $("#montant_depense_acte_input").val(0);
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_acte_input").val();
            if (!code) {
                $("#libelle_acte_input").val('');
                $("#prix_unitaire_acte_input").val(0);
                $("#quantite_acte_input").val(1);
                $("#montant_depense_acte_input").val(0);
            }
        });

    $("#form_dossier").submit(function () {
        let nip             = $("#nip_dossier_input").val().trim(),
            num_dossier     = $("#num_dossier_input").val().trim(),
            code_assurance  = $("#code_assurance_input").val().trim(),
            num_assurance   = $("#num_assurance_input").val().trim(),
            num_bon         = $("#num_bon_input").val().trim(),
            taux_assurance  = $("#taux_assurance_input").val().trim(),
            date_soins      = $("#date_soins_input").val().trim(),
            num_facture     = $("#num_facture_input").val().trim(),
            type_facture    = $("#type_facture_input").val().trim(),
            code_acte       = $("#code_acte_input").val().trim(),
            prix_unitaire   = $("#prix_unitaire_acte_input").val().trim(),
            quantite        = $("#quantite_acte_input").val().trim();
        if (nip && code_assurance && taux_assurance && date_soins && type_facture && code_acte) {
            $("#button_dossier_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_dossier.php',
                type: 'POST',
                data: {
                    'nip': nip,
                    'num_dossier': num_dossier,
                    'code_assurance': code_assurance,
                    'num_assurance': num_assurance,
                    'num_bon': num_bon,
                    'taux_assurance': taux_assurance,
                    'date_soins': date_soins,
                    'num_facture': num_facture,
                    'type_facture': type_facture,
                    'code_acte': code_acte,
                    'prix_unitaire': prix_unitaire,
                    'quantite': quantite
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_dossier_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier").hide();
                        $("#p_dossier_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
                            window.open('../factures/imprimer-facture-medicale?num='+data['num_facture'], '/', params);
                            if(num_bon) {
                                let params_bon = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=700,left=100,top=50`;
                                window.open('../factures/imprimer-bon-medical?num='+data['num_facture'], '/', params_bon);
                            }

                            window.location.href="../dossiers/?num="+data['num_dossier'];
                        }, 3000);
                    } else {
                        $("#p_dossier_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!nip) {
                $("#nip_dossier_input").addClass('is-invalid');
                $("#nipDossierHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le NIP.");
            }
            if (!code_assurance) {
                $("#code_assurance_input").addClass('is-invalid');
                $("#codeAssuranceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner une assurance / mutuelle.");
            }
            if (!taux_assurance) {
                $("#taux_assurance_input").addClass('is-invalid');
                $("#tauxAssuranceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le taux de couverture.");
            }
            if (!date_soins) {
                $("#date_soins_input").addClass('is-invalid');
                $("#dateSoinsHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date des soins.");
            }
            if (!type_facture) {
                $("#type_facture_input").addClass('is-invalid');
                $("#typeFactureHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de facture.");
            }
            if (!code_acte) {
                $("#libelle_acte_input").addClass('is-invalid');
                $("#libelleActeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'acte médical.");
            }
        }
        return false;
    });

    $(".btn_print_bill").click(function () {
        let num_facture = this.id;
        if (num_facture) {
            let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
            window.open('../factures/imprimer-facture-medicale?num='+num_facture, '/', params);
        }
        return false;
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
