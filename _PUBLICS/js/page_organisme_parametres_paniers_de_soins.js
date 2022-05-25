jQuery(function () {
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });
    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau panier');
        return false;
    });

    $("#code_panier_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code.length >= 3) {
            $("#code_panier_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePanierHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_panier_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codePanierHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code pour le réseau SVP.");
        }
    });
    $("#libelle_panier_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle.length >= 3) {
            $("#libelle_panier_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libellePanierHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#libelle_panier_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libellePanierHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé pour le réseau SVP.");
        }
    });
    $("#form_panier_de_soins").submit(function () {
        let code = $("#code_panier_input").val().trim(),
            libelle = $("#libelle_panier_input").val().toUpperCase().trim();
        if (libelle){
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/PaniersDeSoins/submit_edition_panier_de_soins.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_panier_de_soins").hide();
                        $("#p_panier_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../parametres/paniers-de-soins?code="+data['code'];
                        },5000);
                    }else {
                        $("#p_panier_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else{
            if(!libelle) {
                $("#libelle_panier_input").addClass('is-invalid');
                $("#libellePanierHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
            }
        }
        return false;
    });

    $("#libelle_acte_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_actes_medicaux.php", {
                    libelle: $('#libelle_acte_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_acte_input").val(ui.item.code);
                $("#libelle_acte_input").val(ui.item.label);
                $("#tarif_acte_input").val(ui.item.tarif);
                $("#tarif_plafond_acte_input").val(ui.item.tarif);
                $("#date_debut_acte_input").val(ui.item.date_debut);
                $("#button_enregistrer_acte").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                let code = $("#code_acte_input").val();
                if(!code) {
                    $("#libelle_acte_input").val('');
                    $("#tarif_acte_input").val('');
                    $("#tarif_plafond_acte_input").val('');
                    $("#date_debut_acte_input").val('');
                }
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer_acte").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');

            $("#code_acte_input").val('');
            $("#tarif_acte_input").val('');
            $("#date_debut_acte_input").val('');

        })
        .blur(function () {
            $("#button_enregistrer_acte").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_acte_input").val();
            if(!code) {
                $("#libelle_acte_input").val('');
                $("#tarif_acte_input").val('');
                $("#tarif_plafond_acte_input").val('');
                $("#date_debut_acte_input").val('');
            }
        });
    $("#code_acte_input").keyup(function () {
        $("#p_panier_de_soins_acte_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if(code.length === 7) {
            $("#button_enregistrer_acte").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/search_actes_medicaux.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_acte").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#libelle_acte_input").val(data['libelle']);
                        $("#tarif_acte_input").val(data['tarif']);
                        $("#tarif_plafond_acte_input").val(data['tarif']);
                        $("#date_debut_acte_input").val(data['date_debut']);
                    }else {
                        $("#p_panier_de_soins_acte_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_acte_input").val('').focus();
                        $("#libelle_acte_input").val('');
                        $("#tarif_acte_input").val('');
                        $("#tarif_plafond_acte_input").val('');
                        $("#date_debut_acte_input").val('');
                    }
                }
            });
        }else {
            $("#libelle_acte_input").val('');
            $("#tarif_acte_input").val('');
            $("#tarif_plafond_acte_input").val('');
            $("#date_debut_acte_input").val('');
        }
    });
    $("#form_panier_de_soins_acte").submit(function () {
        let code_panier     = $("#code_panier_input").val().trim(),
            code_acte       = $("#code_acte_input").val().trim(),
            libelle_acte    = $("#libelle_acte_input").val().trim(),
            tarif_acte      = $("#tarif_acte_input").val().trim(),
            tarif_plafond   = $("#tarif_plafond_acte_input").val().trim(),
            statut_ep       = $("#statut_entente_prealable_input").val().trim(),
            date_debut      = $("#date_debut_acte_input").val().trim();
        if(code_panier && code_acte && libelle_acte && tarif_acte && tarif_plafond && date_debut) {
            $("#button_enregistrer_acte").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/PaniersDeSoins/submit_edition_actes_medicaux.php',
                type: 'POST',
                data: {
                    'code_panier': code_panier,
                    'code_acte': code_acte,
                    'tarif_acte': tarif_acte,
                    'tarif_plafond': tarif_plafond,
                    'statut_ep': statut_ep,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_acte").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_panier_de_soins_acte").hide();
                        $("#p_panier_de_soins_acte_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $("#p_panier_de_soins_acte_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#libelle_medicament_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_medicaments.php", {
                        libelle: $('#libelle_medicament_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_medicament_input").val(ui.item.code);
                $("#libelle_medicament_input").val(ui.item.label);
                $("#tarif_medicament_input").val(ui.item.tarif);
                $("#date_debut_medicament_input").val(ui.item.date_debut);
                $("#button_enregistrer_acte").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                let code = $("#code_medicament_input").val();
                if(!code) {
                    $("#libelle_medicament_input").val('');
                    $("#tarif_medicament_input").val('');
                    $("#date_debut_medicament_input").val('');
                }
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer_medicament").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');

            $("#code_medicament_input").val('');
            $("#tarif_medicament_input").val('');
            $("#date_debut_medicament_input").val('');

        })
        .blur(function () {
            $("#button_enregistrer_medicament").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_medicament_input").val();
            if(!code) {
                $("#libelle_medicament_input").val('');
                $("#tarif_medicament_input").val('');
                $("#date_debut_medicament_input").val('');
            }
        });
    $("#code_medicament_input").keyup(function () {
        $("#p_panier_de_soins_medicament_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if(code.length === 20) {
            $("#button_enregistrer_medicament").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/search_medicaments.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_medicament").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#libelle_medicament_input").val(data['libelle']);
                        $("#tarif_medicament_input").val(data['tarif']);
                        $("#date_debut_medicament_input").val(data['date_debut']);
                    }else {
                        $("#p_panier_de_soins_medicament_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_medicament_input").val('').focus();
                        $("#libelle_medicament_input").val('');
                        $("#tarif_medicament_input").val('');
                        $("#date_debut_medicament_input").val('');
                    }
                }
            });
        }else {
            $("#libelle_medicament_input").val('');
            $("#tarif_medicament_input").val('');
            $("#date_debut_medicament_input").val('');
        }
    });
    $("#form_panier_de_soins_medicament").submit(function () {
        let code_panier         = $("#code_panier_input").val().trim(),
            code_medicament     = $("#code_medicament_input").val().trim(),
            libelle_medicament  = $("#libelle_medicament_input").val().trim(),
            tarif_medicament    = $("#tarif_medicament_input").val().trim(),
            date_debut          = $("#date_debut_medicament_input").val().trim();
        if(code_panier && code_medicament && libelle_medicament && tarif_medicament && date_debut) {
            $("#button_enregistrer_medicament").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/PaniersDeSoins/submit_edition_medicaments.php',
                type: 'POST',
                data: {
                    'code_panier': code_panier,
                    'code_medicament': code_medicament,
                    'tarif_medicament': tarif_medicament,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_medicament").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_panier_de_soins_medicament").hide();
                        $("#p_panier_de_soins_medicament_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $("#p_panier_de_soins_medicament_resultats").removeClass('alert alert-success')
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
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_pathologies.php", {
                        libelle: $('#libelle_pathologie_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_pathologie_input").val(ui.item.code);
                $("#libelle_pathologie_input").val(ui.item.label);
                $("#date_debut_pathologie_input").val(ui.item.date_debut);
                $("#button_enregistrer_pathologie").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                let code = $("#code_pathologie_input").val();
                if(!code) {
                    $("#libelle_pathologie_input").val('');
                    $("#date_debut_pathologie_input").val('');
                }
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer_pathologie").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');

            $("#code_pathologie_input").val('');
            $("#date_debut_pathologie_input").val('');

        })
        .blur(function () {
            $("#button_enregistrer_pathologie").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_pathologie_input").val();
            if(!code) {
                $("#libelle_pathologie_input").val('');
                $("#date_debut_pathologie_input").val('');
            }
        });
    $("#code_pathologie_input").keyup(function () {
        $("#p_panier_de_soins_pathologie_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val().toUpperCase();
        if(code.length === 3) {
            $("#button_enregistrer_pathologie").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/search_pathologies.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_pathologie").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#libelle_pathologie_input").val(data['libelle']);
                        $("#date_debut_pathologie_input").val(data['date_debut']);
                    }else {
                        $("#p_panier_de_soins_pathologie_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_pathologie_input").val('').focus();
                        $("#libelle_pathologie_input").val('');
                        $("#date_debut_pathologie_input").val('');
                    }
                }
            });
        }else {
            $("#libelle_pathologie_input").val('');
            $("#date_debut_pathologie_input").val('');
        }
    });
    $("#form_panier_de_soins_pathologie").submit(function () {
        let code_panier         = $("#code_panier_input").val().trim(),
            code_pathologie     = $("#code_pathologie_input").val().toUpperCase().trim(),
            libelle_pathologie  = $("#libelle_pathologie_input").val().trim(),
            date_debut          = $("#date_debut_pathologie_input").val().trim();
        if(code_panier && code_pathologie && libelle_pathologie && date_debut) {
            $("#button_enregistrer_pathologie").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/PaniersDeSoins/submit_edition_pathologies.php',
                type: 'POST',
                data: {
                    'code_panier': code_panier,
                    'code_pathologie': code_pathologie,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_pathologie").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_panier_de_soins_pathologie").hide();
                        $("#p_panier_de_soins_pathologie_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $("#p_panier_de_soins_pathologie_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });


    $(".btn_afficher").click(function () {
        let btn_id      = this.id,
            code_panier = $("#code_panier_input").val().trim();
        if(btn_id === 'btn_afficher_actes') {
            $("#afficherModalLabel").html('<i class="bi bi-ui-radios-grid"></i> Actes médicaux');
        }else if(btn_id === 'btn_afficher_medicaments') {
            $("#afficherModalLabel").html('<i class="bi bi-toggles"></i> Médicaments');
        }else if(btn_id === 'btn_afficher_pathologies') {
            $("#afficherModalLabel").html('<i class="bi bi-file-medical-fill"></i> Pathologies');
        }
        if(btn_id && code_panier){
            $("#div_afficher").html(loading_gif(2));
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Parametres/PanierDeSoins/search_panier_de_soins.php',
                type: 'POST',
                data: {
                    'type_donnee': btn_id,
                    'code_panier': code_panier
                },
                success: function (data) {
                    $("#div_afficher").html(data);
                }
            });
        }else {

        }
    });
    $(".btn_ajouter").click(function () {
        let btn_id      = this.id,
            code_panier = $("#code_panier_input").val().trim();
        if(btn_id === 'btn_ajouter_acte') {
            $("#ajouterModalLabel").html('Ajouter un acte médical');
            $("#div_panier_acte").slideDown();
            $("#div_panier_medicament").hide();
            $("#div_panier_pathologie").hide();
        }else if(btn_id === 'btn_ajouter_medicament') {
            $("#ajouterModalLabel").html('Ajouter un médicament');
            $("#div_panier_acte").hide();
            $("#div_panier_medicament").slideDown();
            $("#div_panier_pathologie").hide();
        }else if(btn_id === 'btn_ajouter_pathologie') {
            $("#ajouterModalLabel").html('Ajouter une pathologie');
            $("#div_panier_acte").hide();
            $("#div_panier_medicament").hide();
            $("#div_panier_pathologie").slideDown();
        }
        if(btn_id && code_panier){

        }else {

        }
    });
});
$(".datepicker").datepicker({
    minDate: 0
});
$("#table_paniers_de_soins").DataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});