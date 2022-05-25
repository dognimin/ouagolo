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
        if (libelle){
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/ReseauxDeSoins/submit_edition_reseau_de_soins.php',
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
                            window.location.href="../parametres/reseaux-de-soins?code="+data['code'];
                        },5000);
                    }else {
                        $("#p_reseau_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else{
            if(!libelle) {
                $("#libelle_reseau_input").addClass('is-invalid');
                $("#libelleReseauHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libelle SVP.");
            }
        }
        return false;
    });

    $("#raison_sociale_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_etablissements_sante.php", {
                    raison_sociale: $('#raison_sociale_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_input").val(ui.item.code);
                $("#raison_sociale_input").val(ui.item.label);
                $("#date_debut_input").val(ui.item.date_debut);
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                let code = $("#code_input").val();
                if(!code) {
                    $("#raison_sociale_input").val('');
                    $("#date_debut_input").val('');
                }
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');

            $("#code_input").val('');
            $("#date_debut_input").val('');

        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_input").val();
            if(!code) {
                $("#raison_sociale_input").val('');
                $("#date_debut_input").val('');
            }
        });
    $("#code_input").keyup(function () {
        $("#p_reseau_etablissement_resultats")
            .removeClass('alert alert-success alert-danger').html('');
        let code = $(this).val();
        if(code.length === 9) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/search_etablissements_sante.php',
                type: 'POST',
                data: {
                    'code': code
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#raison_sociale_input").val(data['raison_sociale']);
                        $("#date_debut_input").val(data['date_debut']);
                    }else {
                        $("#p_reseau_etablissement_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le code "+code+" est incorrect. Veuillez saisir un code correct.");
                        $("#code_input").val('').focus();
                        $("#raison_sociale_input").val('');
                        $("#date_debut_input").val('');
                    }
                }
            });
        }else {
            $("#raison_sociale_input").val('');
            $("#date_debut_input").val('');
        }
    });

    $("#form_reseau_etablissement").submit(function () {
        let code_reseau     = $("#code_reseau_input").val().trim(),
            code            = $("#code_input").val().trim(),
            raison_sociale  = $("#raison_sociale_input").val().trim(),
            date_debut      = $("#date_debut_input").val().trim();
        if(code_reseau && code && raison_sociale && date_debut) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/ReseauxDeSoins/submit_edition_etablissement_sante.php',
                type: 'POST',
                data: {
                    'code_reseau': code_reseau,
                    'code': code,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_reseau_etablissement").hide();
                        $("#p_reseau_etablissement_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    } else {
                        $("#p_reseau_etablissement_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
});
$("#table_reseaux_de_soins").DataTable();
$("#table_reseaux_de_soins_etablissements").DataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});