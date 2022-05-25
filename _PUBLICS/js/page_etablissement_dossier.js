jQuery(function () {
    $("#form_constantes").submit(function () {
        let poids           = $("#patient_poids_input").val().trim(),
            temperature     = $("#patient_temperature_input").val().trim(),
            pouls           = $("#patient_pouls_input").val().trim(),
            code_dossier    = $("#strong_code_dossier").html().trim();
        if(code_dossier && (poids && temperature && pouls)) {
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
        if(plaintes && code_dossier) {
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
        if(diagnostic && code_dossier) {
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
        if(code && libelle && code_dossier) {
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
                        $("#p_dossier_diagnostic_resultats").removeClass('alert alert-success')
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
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_pathologies.php", {
                        libelle: $('#libelle_pathologie_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
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
            if(!code) {
                $("#libelle_pathologie_input").val('');
            }
        });
    $("#code_pathologie_input").keyup(function () {
        $("#p_pathologie_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if(code.length === 3) {
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
                    if(data['success'] === true) {
                        $("#libelle_pathologie_input").val(data['libelle']);
                    }else {
                        $("#p_pathologie_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_pathologie_input").val('').focus();
                        $("#libelle_pathologie_input").val('');
                    }
                }
            });
        }else {
            $("#libelle_pathologie_input").val('');
        }
    });

    $("#libelle_acte_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_actes_medicaux.php", {
                        libelle: $('#libelle_acte_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_acte_input").val(ui.item.value);
                $("#libelle_acte_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#button_examens_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_acte_input").val('');
        })
        .blur(function () {
            $("#button_examens_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_acte_input").val();
            if(!code) {
                $("#libelle_acte_input").val('');
            }
        });
    $("#code_acte_input").keyup(function () {
        $("#p_acte_medical_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if(code.length === 7) {
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
                    if(data['success'] === true) {
                        $("#libelle_acte_input").val(data['libelle']);
                    }else {
                        $("#p_acte_medical_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_acte_input").val('').focus();
                        $("#libelle_acte_input").val('');
                    }
                }
            });
        }else {
            $("#code_acte_input").val('');
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