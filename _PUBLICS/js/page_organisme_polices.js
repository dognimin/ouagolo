jQuery(function () {
    $("#form_search_organisme_polices").submit(function () {
        let date_debut      = $("#date_debut_search_input").val().trim(),
            date_fin        = $("#date_fin_search_input").val().trim(),
            numero          = $("#numero_police_input").val().trim(),
            nom             = $("#nom_police_input").val().trim();
        if((date_debut && date_fin) || numero || nom) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Polices/search_polices.php',
                type: 'POST',
                data: {
                    'date_debut': date_debut,
                    'date_fin': date_fin,
                    'numero': numero,
                    'nom': nom
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

    $("#raison_sociale_souscripteur_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Organisme/search_collectivites.php", {
                        raison_sociale: $('#raison_sociale_souscripteur_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#code_souscripteur_input").val(ui.item.value);
                $("#raison_sociale_souscripteur_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#code_souscripteur_input").val('');
            $("#raison_sociale_souscripteur_input").removeClass('is-invalid').addClass('is-valid');
            $("#raisonSocialeSouscripteurHelp").removeClass('text-danger').html('');

            let raison_sociale = $('#raison_sociale_souscripteur_input').val().trim().toUpperCase();
            $("#libelle_input").val("POLICE "+raison_sociale);
        })
        .blur(function () {
            let code = $("#code_souscripteur_input").val();
            if(!code) {
                $("#raison_sociale_souscripteur_input").val('').removeClass('is-valid').addClass('is-invalid');
                $("#raisonSocialeSouscripteurHelp").addClass('text-danger').html('Veuillez sélectionner le souscripteur SVP.');
                $("#libelle_input").val('');
            }else {
                let raison_sociale = $('#raison_sociale_souscripteur_input').val().trim().toUpperCase();
                $("#libelle_input").val("POLICE "+raison_sociale);
            }
        });

    $("#libelle_input").keyup(function () {
        let libelle = $(this).val().trim();
        if(libelle) {
            $("#libelle_input").removeClass('is-invalid').addClass('is-valid');
            $("#libelleHelp").removeClass('text-danger').html('');
        }
    });

    $("#date_debut_input").change(function () {
        let date_debut = $(this).val().trim();
        if(date_debut) {
            $("#date_debut_input").removeClass('is-invalid').addClass('is-valid');
            $("#dateDebutHelp").removeClass('text-danger').html('');
        }
    });

    $("#form_organisme_police").submit(function () {
        let code_collectivite   = $("#code_souscripteur_input").val().trim(),
            id_police           = $("#code_input").val().trim(),
            libelle             = $("#libelle_input").val().trim().toUpperCase(),
            description         = $("#description_input").val().trim().toUpperCase(),
            date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim();
        if(code_collectivite && libelle && date_debut) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Polices/submit_edition_police.php',
                type: 'POST',
                data: {
                    'code_collectivite': code_collectivite,
                    'id_police': id_police,
                    'libelle': libelle,
                    'description': description,
                    'date_debut': date_debut,
                    'date_fin': date_fin
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_organisme_police").hide();
                        $("#p_organisme_police_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../polices/?id="+data['id_police'].toLowerCase();
                        }, 2000);
                    } else {
                        $("#p_organisme_police_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }else {
            if(!code_collectivite) {
                $("#raison_sociale_souscripteur_input").removeClass('is-valid').addClass('is-invalid');
                $("#raisonSocialeSouscripteurHelp").addClass('text-danger').html('Veuillez sélectionner le souscripteur SVP.');
            }
            if(!libelle) {
                $("#libelle_input").removeClass('is-valid').addClass('is-invalid');
                $("#libelleHelp").addClass('text-danger').html('Veuillez renseigner le nom de la police SVP.');
            }
            if(!date_debut) {
                $("#date_debut_input").removeClass('is-valid').addClass('is-invalid');
                $("#dateDebutHelp").addClass('text-danger').html('Veuillez sélectionner la date de début de la police SVP.');
            }
        }
        return false;
    });
});
$(".date").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    minDate: 0,
    lang: 'fr'
});
$(".date_passee").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    maxDate: 0,
    lang: 'fr'
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});