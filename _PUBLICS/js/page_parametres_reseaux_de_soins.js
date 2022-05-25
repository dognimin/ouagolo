jQuery(function () {
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });
    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau réseau');
        return false;
    });

    $("#code_reseau_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code.length >= 3) {
            $("#code_reseau_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeReseauHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_reseau_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeReseauHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code pour le réseau SVP.");
        }
    });
    $("#libelle_reseau_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle.length >= 3) {
            $("#libelle_reseau_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libelleReseauHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#libelle_reseau_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libelleReseauHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé pour le réseau SVP.");
        }
    });

    $("#form_reseau_de_soins").submit(function () {
        let code = $("#code_reseau_input").val().trim(),
            libelle = $("#libelle_reseau_input").val().toUpperCase().trim();
        if (code && libelle){
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soins.php',
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
                        $("#form_reseau_de_soins").hide();
                        $("#p_reseau_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_reseau_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else{
            if(!code) {
                $("#code_reseau_input").addClass('is-invalid');
                $("#codeReseauHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code SVP.");
            }
            if(!libelle) {
                $("#libelle_reseau_input").addClass('is-invalid');
                $("#libelleReseauHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libelle SVP.");
            }
        }
        return false;
    });

    $("#code_input").keyup(function () {
        let code = $(this).val(),
            code_reseau = $("#code_reseau_input").val();
        if(code.length === 9) {
            $("#button_enregistrer")
                .prop('disabled',true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_etablissement.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_reseau': code_reseau
                },
                dataType:'json',
                success: function (data) {
                    $("#button_enregistrer")
                        .prop('disabled',false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#p_reseau_etablissement_resultats").hide();
                        $("#code_input").val(data['code']);
                        $("#raison_sociale_input").val(data['raison_sociale']);
                        $("#date_debut_input").val(data['date_debut']);
                    }else {
                        $("#p_reseau_etablissement_resultats")
                            .show()
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger text-dark')
                            .html(data['message']);
                    }
                }
            });
        }else {
            $("#raison_sociale_input").val('');
            $("#date_debut_input").val('');
        }
    })
        .blur(function () {
        $("#p_reseau_etablissement_resultats").hide();
        let raison_sociale = $("#raison_sociale_input").val();
        if(!raison_sociale) {
            $("#code_input").val('');
            $("#date_debut_input").val('');
        }
    });

    $("#raison_sociale_input")
        .autocomplete({
        source: function(request, response) {
            $.getJSON("../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_etablissement.php", {
                raison_sociale: $('#raison_sociale_input').val()
                }, response
            );
        },
        minLength: 2,
        select: function(e, ui) {
            $("#code_input").val(ui.item.value);
            $("#raison_sociale_input").val(ui.item.label);
            $("#date_debut_input").val(ui.item.date_debut);
            return false;
        }
    })
        .keyup(function () {
        $("#code_input").val('');
        $("#date_debut_input").val('');
    })
        .blur(function () {
        let code = $("#code_input").val();
        if(!code) {
            $("#raison_sociale_input").val('');
            $("#date_debut_input").val('');
        }
    });

    $("#form_reseau_etablissement").submit(function () {
        let code_ets = $("#code_input").val().trim(),
            code_reseau = $("#code_reseau_input").val().trim(),
            raison_sociale = $("#raison_sociale_input").val().trim(),
            date_debut = $("#date_debut_input").val().trim();
        if(code_ets && code_reseau && raison_sociale && date_debut) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin_etablissement.php',
                type: 'POST',
                data: {
                    'code_ets': code_ets,
                    'code_reseau': code_reseau,
                    'raison_sociale': raison_sociale,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success:function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    if (data['success'] === true) {
                        $("#form_reseau_etablissement").hide();
                        $("#p_reseau_etablissement_resultats").show().removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_reseau_etablissement_resultats").show().removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#form_reseau_acte_medical").submit(function () {
        let code_acte = $("#code_acte_input").val().trim(),
            code_reseau = $("#code_reseau_input").val().trim(),
            libelle = $("#libelle_input").val().trim(),
            tarif = $("#tarif_input").val().trim(),
            date_debut = $("#date_debut_input").val().trim();
        if(code_acte && libelle && tarif && date_debut) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin_acte_medicale.php',
                type: 'POST',
                data: {
                    'code_acte': code_acte,
                    'libelle': libelle,
                    'code_reseau': code_reseau,
                    'tarif': tarif,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success:function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    if (data['success'] === true) {
                        $("#form_reseau_acte_medical").hide();
                        $("#p_reseau_acte_medical_resultats").show().removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_reseau_acte_medical_resultats").show().removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
    $("#code_acte_input").keyup(function () {
        let code = $(this).val(),
            code_reseau = $("#code_reseau_input").val();
        if(code.length === 4) {
            $("#button_enregistrer")
                .prop('disabled',true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_acte_medicale.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_reseau': code_reseau
                },
                dataType:'json',
                success: function (data) {
                    $("#button_enregistrer")
                        .prop('disabled',false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#p_reseau_acte_medical_resultats").hide();
                        $("#code_acte_input").val(data['code']);
                        $("#libelle_input").val(data['libelle']),
                            $("#date_debut_input").val(data['date_debut']);
                    }else {
                        $("#p_reseau_acte_medical_resultats")
                            .show()
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger text-dark')
                            .html(data['message']);
                    }
                }
            });
        }else {
            $("#libelle_input").val('');
            $("#date_debut_input").val('');
        }
    })
        .blur(function () {
        $("#p_acte_medical_resultats").hide();
        let libelle = $("#libelle_input").val();
        if(!libelle) {
            $("#code_acte_input").val('');
            $("#date_debut_input").val('');
        }
    });
    $("#libelle_input")
        .autocomplete({
        source: function(request, response) {
            $.getJSON("../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_acte_medicale.php", {
                    libelle: $('#libelle_input').val()
                }, response
            );
        },
        minLength: 2,
        select: function(e, ui) {
            $("#code_acte_input").val(ui.item.value);
            $("#libelle_input").val(ui.item.label);
            $("#date_debut_input").val(ui.item.date_debut);
            return false;
        }
    })
        .keyup(function () {
        $("#code_acte_input").val('');
        $("#date_debut_input").val('');
    })
        .blur(function () {
        let code = $("#code_acte_input").val();
        if(!code) {
            $("#libelle_input").val('');
            $("#date_debut_input").val('');
        }
    });
    $(".btn_edit_medicament").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            tarif = tableau[2],
            date_debut = tableau[3];
        $("#medicament_code").val(code).prop('disabled',true);
        $("#libelle_medicament_input").val('').prop('disabled',true);
        $("#tarif_medicament_input").val(tarif);
        $("#date_debut_input").val(date_debut);
        $(".card-title").html("Edition médicament");

    });
    $(".btn_edit_acte_medicale").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            code_acte = tableau[1],
            tarif = tableau[2],
            date_debut = tableau[3];
        $("#code_acte_input").val(code_acte).prop('disabled',true);
        $("#libelle_input").val('').prop('disabled',true);
        $("#tarif_input").val(tarif);
        $("#date_debut_input").val(date_debut);
        $(".card-title").html("Edition acte médicale");

    });
    $(".btn_edit").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            code_etablissement = tableau[1],
            date_debut = tableau[2];
        $("#code_input").val(code).prop('disabled',true);
        $("#libelle_input").val(code_etablissement);
        $("#code_reseau_input").val(code);
        $("#date_debut_input").val(date_debut);
        $(".card-title").html("Edition Etablissement");

    });
    $(".btn_edit_etablissement").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            code_etablissement = tableau[1],
            date_debut = tableau[2];
        $("#code_input").val(code_etablissement).prop('disabled',true);
        $("#libelle_input").val(code);
        $("#code_reseau_input").val(code);
        $("#date_debut_input").val(date_debut);
        $(".card-title").html("Edition Etablissement");

    });
    $('#historiqueModal').modal({
        show: false,
        backdrop: 'static'
    });

    $(".button_historique").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            donnee = tableau[0],
            type_donnee = tableau[1];
        if(donnee && type_donnee) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
                type: 'POST',
                data: {
                    'donnee': donnee,
                    'type': type_donnee
                },
                success: function (data) {
                    $("#div_historique").html(data);
                }
            });
        }
    });


    $("#medicament_code").keyup(function () {
        let code = $(this).val(),
            code_reseau = $("#code_reseau_input").val();
        if(code.length === 7) {
            $("#button_enregistrer")
                .prop('disabled',true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_medicament.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_reseau': code_reseau
                },
                dataType:'json',
                success: function (data) {

                    $("#button_enregistrer")
                        .prop('disabled',false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#p_reseau_medicament_resultat").hide();
                        $("#medicament_code").val(data['code']);
                        $("#libelle_medicament_input").val(data['libelle']),
                            $("#date_debut_input").val(data['date_debut']);
                    }else {
                        $("#p_reseau_medicament_resultat")
                            .show()
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger text-dark')
                            .html(data['message']);
                    }
                }
            });
        }else {
            $("#libelle_medicament_input").val('');
            $("#date_debut_input").val('');
        }
    })
        .blur(function () {
        let libelle = $("#libelle_medicament_input").val();
        if(!libelle) {
            $("#medicament_code").val('');
            $("#date_debut_input").val('');
        }
    });
    $("#libelle_medicament_input").autocomplete({
        source: function(request, response) {
            $.getJSON("../../_CONFIGS/Includes/Searches/Parametres/ReseauxDeSoins/search_medicament.php", {
                    libelle: $('#libelle_medicament_input').val()
                }, response
            );
        },
        minLength: 2,
        select: function(e, ui) {
            $("#medicament_code").val(ui.item.value);
            $("#libelle_medicament_input").val(ui.item.label);
            $("#date_debut_input").val(ui.item.date_debut);
            return false;
        }
    })
        .keyup(function () {
        $("#medicament_code").val('');
        $("#date_debut_input").val('');
    })
        .blur(function () {
        let code = $("#medicament_code").val();
        if(!code) {
            $("#libelle_input").val('');
            $("#date_debut_input").val('');
        }
    });

    $("#form_reseau_medicament").submit(function () {
        let code_reseau = $("#code_reseau_input").val().trim(),
            medicament_code = $("#medicament_code").val().trim(),
            tarif = $("#tarif_medicament_input").val().trim();
        if (medicament_code){
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin_medicament.php',
                type: 'POST',
                data: {
                    'code_reseau': code_reseau,
                    'medicament_code': medicament_code,
                    'tarif': tarif
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_reseau_medicament").hide();
                        $("#p_reseau_medicament_resultat").show().removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_reseau_medicament_resultats").show().removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!medicament_code) {
                $("#medicament_code").addClass('is-invalid');
                $("#codeMedicamentHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code du médicament SVP.");
            }
            if(!tarif) {
                $("#tarif_input").addClass('is-invalid');
                $("#tarifHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le tarif SVP.");
            }
        }
        return false;
    });
    $('#editionDureevieModal').modal({
        show: false,
        backdrop: 'static'
    });

    $('#AutorisationDoubleModal').modal({
        show: false,
        backdrop: 'static'
    });
    $('#tableDeValeurs').DataTable();

    $("#date_debut_input").datepicker({
        minDate: 0
    });

    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("../exporter-reseaux-de-soins.php?type="+code_export+"&data=res", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
});