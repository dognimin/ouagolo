jQuery(function () {
    $("#button_imprimer_dossier").click(function () {
        let code_dossier    = $("#strong_code_dossier").html().trim();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-dossier?code='+code_dossier, '/', params);
    });

    $("#form_search_dossiers").submit(function () {
        let num_dossier = $("#num_dossier_search_input").val().trim(),
            num_secu    = $("#num_secu_dossier_search_input").val().trim(),
            num_patient = $("#nip_search_input").val().trim(),
            nom_prenoms = $("#nom_prenoms_input").val().trim(),
            date_debut  = $("#date_debut_search_input").val().trim(),
            date_fin    = $("#date_fin_search_input").val().trim();
        if (date_debut && date_fin) {
            display_etablissement_dossiers(num_dossier, num_secu, num_patient, nom_prenoms, date_debut, date_fin);
        }
        return false;
    });
    $("#patient_poids_input").keyup(function () {
        let poids    = $(this).val().trim(),
            nouveau_poids = 0;
        if (isNaN(poids)) {
            nouveau_poids = poids.slice(0, -1);
            $(this).val(nouveau_poids);
        }
    });
    $("#patient_temperature_input").keyup(function () {
        let temperature    = $(this).val().trim(),
            nouvelle_temperature = 0;
        if (isNaN(temperature)) {
            nouvelle_temperature = temperature.slice(0, -1);
            $(this).val(nouvelle_temperature);
        }
    });
    $("#patient_pouls_input").keyup(function () {
        let pouls    = $(this).val().trim(),
            nouveau_pouls = 0;
        if (isNaN(pouls)) {
            nouveau_pouls = pouls.slice(0, -1);
            $(this).val(nouveau_pouls);
        }
    });
    $("#form_constantes").submit(function () {
        let poids           = $("#patient_poids_input").val().trim(),
            temperature     = $("#patient_temperature_input").val().trim(),
            pouls           = $("#patient_pouls_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if (code_dossier && (poids && temperature && pouls)) {
            $("#button_constantes_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_constantes.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'poids': poids,
                    'temperature': temperature,
                    'pouls': pouls
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_constantes_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_constantes").hide();
                        $("#p_constantes_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_constantes_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#form_dossier_professionnel_sante").submit(function () {
        let code_ps         = $("#code_ps_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if (code_ps && code_dossier) {
            $("#button_professionnel_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_professionnel_sante.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'code_ps': code_ps
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_professionnel_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_professionnel_sante").hide();
                        $("#p_dossier_professionnel_sante_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_dossier_professionnel_sante_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#form_dossier_plaintes").submit(function () {
        let plaintes        = $("#dossier_plaintes_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if (plaintes && code_dossier) {
            $("#button_plaintes_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_plaintes.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'plaintes': plaintes
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_plaintes_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_plaintes").hide();
                        $("#p_dossier_plaintes_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_dossier_plaintes_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#form_dossier_diagnostic").submit(function () {
        let diagnostic      = $("#dossier_diagnostic_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if (diagnostic && code_dossier) {
            $("#button_diagnostic_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_diagnostic.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'diagnostic': diagnostic
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_diagnostic_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_diagnostic").hide();
                        $("#p_dossier_diagnostic_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_dossier_diagnostic_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#form_dossier_pathologies").submit(function () {
        let code            = $("#code_pathologie_input").val().trim(),
            libelle         = $("#libelle_pathologie_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if (code && libelle && code_dossier) {
            $("#button_pathologie_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Enregistrement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_pathologie.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_pathologie_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_pathologies").hide();
                        $("#p_dossier_pathologies_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_dossier_pathologies_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#libelle_pathologie_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_pathologies.php", {
                    libelle: $('#libelle_pathologie_input').val()
                    }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_pathologie_input").val(ui.item.value);
            $("#libelle_pathologie_input").val(ui.item.label);
            return false;
        }
        })
        .keyup(function () {
            $("#button_pathologie_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_pathologie_input").val('');
        })
        .blur(function () {
            $("#button_pathologie_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_pathologie_input").val();
            if (!code) {
                $("#libelle_pathologie_input").val('');
            }
        });
    $("#code_pathologie_input").keyup(function () {
        $("#p_pathologie_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if (code.length === 3) {
            $("#button_pathologie_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/search_pathologies.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_pathologie_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#libelle_pathologie_input").val(data['libelle']);
                    } else {
                        $("#p_pathologie_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_pathologie_input").val('').focus();
                        $("#libelle_pathologie_input").val('');
                    }
                }
            });
        } else {
            $("#libelle_pathologie_input").val('');
        }
    });

    $("#libelle_examen_acte_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_actes_medicaux.php", {
                    libelle: $('#libelle_examen_acte_input').val()
                    }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_examen_acte_input").val(ui.item.value);
            $("#libelle_examen_acte_input").val(ui.item.label);
            return false;
        }
        })
        .keyup(function () {
            $("#button_examens_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_examen_acte_input").val('');
        })
        .blur(function () {
            $("#button_examens_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_examen_acte_input").val();
            if (!code) {
                $("#libelle_examen_acte_input").val('');
            }
        });
    $("#code_examen_acte_input").keyup(function () {
        $("#p_acte_medical_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if (code.length === 7) {
            $("#button_examens_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/search_actes_medicaux.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_examens_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#libelle_examen_acte_input").val(data['libelle']);
                    } else {
                        $("#p_acte_medical_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_examen_acte_input").val('').focus();
                        $("#libelle_examen_acte_input").val('');
                    }
                }
            });
        } else {
            $("#code_examen_acte_input").val('');
        }
    });
    $("#button_ajouter_examens_acte").click(function () {
        let code_acte       = [],
            code            = $("#code_examen_acte_input").val().trim(),
            libelle_acte    = $("#libelle_examen_acte_input").val().trim();
        if (code_acte && libelle_acte) {
            $(".code_acte_td").each(function () {
                code_acte.push($(".code_acte_td").html());});
            if (jQuery.inArray(code, code_acte) === -1) {
                $("#p_erreur_examens_actes").removeClass('alert alert-danger align_center').html('');
                $("#tbody_examens_actes").append('<tr id="tr_'+code+'">' +
                    '<td class="code_acte_td">'+code+'</td>' +
                    '<td>'+libelle_acte+'</td>' +
                    '<td><button type="button" class="badge bg-danger button_retirer_acte" id="'+code+'"><i class="bi bi-x-lg"></i></button></td>' +
                    '</tr>');

                $("#code_examen_acte_input").val('');
                $("#libelle_examen_acte_input").val('');
            } else {
                $("#p_erreur_examens_actes").addClass('alert alert-danger align_center').html('Cet acte a déjà été saisi.');
            }
        }
    });
    $(document).on('click', '.button_retirer_acte', function () {
        let code = this.id;
        if (code) {
            $("#tbody_examens_actes").find("#tr_"+code).remove();
        }
    });

    $("#libelle_ordonnance_medicament_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_medicaments.php", {
                    libelle: $('#libelle_ordonnance_medicament_input').val().trim()
                }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_ordonnance_medicament_input").val(ui.item.value);
            $("#libelle_ordonnance_medicament_input").val(ui.item.label);
            return false;
        }
        })
        .keyup(function () {
            $("#button_ordonnance_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_ordonnance_medicament_input").val('');
        })
        .blur(function () {
            $("#button_ordonnance_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_ordonnance_medicament_input").val();
            if (!code) {
                $("#libelle_ordonnance_medicament_input").val('');
            }
        });
    $("#code_ordonnance_medicament_input").keyup(function () {
        $("#p_dossier_ordonnance_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if (code.length === 20) {
            $("#button_ordonnance_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/search_medicaments.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_ordonnance_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#libelle_ordonnance_medicament_input").val(data['libelle']);
                    } else {
                        $("#p_dossier_ordonnance_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_ordonnance_medicament_input").val('').focus();
                        $("#libelle_ordonnance_medicament_input").val('');
                    }
                }
            });
        } else {
            $("#code_ordonnance_medicament_input").val('');
        }
    });
    $("#button_ajouter_ordonnance_medicament").click(function () {
        let code_medicament     = [],
            code                = $("#code_ordonnance_medicament_input").val().trim(),
            libelle_medicament  = $("#libelle_ordonnance_medicament_input").val().trim(),
            posologie           = $("#posologie_ordonnance_medicament_input").val().trim(),
            duree               = $("#duree_ordonnance_medicament_input").val().trim(),
            unite_duree         = $("#unite_duree_ordonnance_medicament_input").val().trim();
        if (code_medicament && libelle_medicament) {
            $(".code_medicament_td").each(function () {
                code_medicament.push($(".code_medicament_td").html());});
            if (jQuery.inArray(code, code_medicament) === -1) {
                $("#p_dossier_ordonnance_resultats").removeClass('alert alert-danger align_center').html('');
                $("#tbody_ordonnance_medicaments").append('<tr id="tr_'+code+'">' +
                    '<td><strong class="code_medicament_strong">'+code+'</strong></td>' +
                    '<td><strong class="libelle_medicament_strong">'+libelle_medicament+'</strong></td>' +
                    '<td><strong class="posologie_medicament_strong">'+posologie+'</strong></td>' +
                    '<td><strong class="duree_medicament_strong">'+duree+'</strong> <strong class="unite_duree_medicament_strong">'+unite_duree+'</strong></td>' +
                    '<td><button type="button" class="badge bg-danger button_retirer_medicament" id="'+code+'"><i class="bi bi-x-lg"></i></button></td>' +
                    '</tr>');

                $("#code_ordonnance_medicament_input").val('');
                $("#libelle_ordonnance_medicament_input").val('');
                $("#posologie_ordonnance_medicament_input").val('');
                $("#duree_ordonnance_medicament_input").val('');
                $("#unite_duree_ordonnance_medicament_input").val('J');
            } else {
                $("#p_erreur_examens_actes").addClass('alert alert-danger align_center').html('Cet acte a déjà été saisi.');
            }
        }
    });
    $(document).on('click', '.button_retirer_medicament', function () {
        let code = this.id;
        if (code) {
            $("#tbody_ordonnance_medicaments").find("#tr_"+code).remove();
        }
    });

    $("#form_dossier_sortie").submit(function () {
        let dossier_code    = $("#strong_code_dossier").html(),
            date_fin        = $("#date_fin_soins_input").val().trim(),
            type_fin        = $("input[type='radio'][name='sortieOptions']:checked").val();
        if (dossier_code && date_fin && type_fin) {
            $("#button_sortie_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Enregistrement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_sortie.php',
                type: 'POST',
                data: {
                    'code_dossier': dossier_code,
                    'date_fin': date_fin,
                    'type_fin': type_fin
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_sortie_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    if (data['success'] === true) {
                        $("#form_dossier_sortie").hide();
                        $("#p_dossier_sortie_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_dossier_sortie_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#form_dossier_examens").submit(function () {
        let code            = $.map($(".code_acte_td"),function (select) {
                return $(select).html();}),
            renseignements  = $("#renseignements_input").html().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();

        if (code_dossier && code) {
            $("#button_examens_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_examens.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'renseignements': renseignements,
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_examens_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_examens").hide();
                        $("#p_dossier_examens_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        window.location.reload();
                    } else {
                        $("#p_dossier_examens_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#form_dossier_ordonnance").submit(function () {
        let code            = $.map($(".code_medicament_strong"),function (select) {
                return $(select).html();}),
            posologie       = $.map($(".posologie_medicament_strong"),function (select) {
                return $(select).html();}),
            duree           = $.map($(".duree_medicament_strong"),function (select) {
                return $(select).html();}),
            unite_duree     = $.map($(".unite_duree_medicament_strong"),function (select) {
                return $(select).html();}),
            code_dossier    = $("#strong_code_dossier").html().trim();

        if (code_dossier && code) {
            $("#button_ordonnance_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Dossiers/submit_edition_ordonnance.php',
                type: 'POST',
                data: {
                    'code_dossier': code_dossier,
                    'code': code,
                    'posologie': posologie,
                    'duree': duree,
                    'unite_duree': unite_duree
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_ordonnance_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dossier_ordonnance").hide();
                        $("#p_dossier_ordonnance_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        window.location.reload();
                    } else {
                        $("#p_dossier_ordonnance_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $(".button_examen_print").click(function () {
        let num_bulletin    = this.id,
            code_dossier    = $("#strong_code_dossier").html().trim();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-bulletin-examen?code-dossier='+code_dossier+'&num='+num_bulletin, '/', params);
    });
    $(".button_ordonnance_print").click(function () {
        let code_ordonnance = this.id,
            code_dossier    = $("#strong_code_dossier").html().trim();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-ordonnance?code-dossier='+code_dossier+'&num='+code_ordonnance, '/', params);
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
$('.editor').summernote({
    height: 300,
    minHeight: null,
    maxHeight: null,
    focus: true,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
    ]
});
