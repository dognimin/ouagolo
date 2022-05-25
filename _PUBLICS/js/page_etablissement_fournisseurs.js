jQuery(function () {
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

    $("#libelle_input").keyup(function () {
        let libelle = $(this).val().trim();
        if (libelle && libelle.length > 3) {
            $("#libelle_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libelleHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#libelle_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libelleHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé SVP.");
        }
    });

    $("#form_fournisseur").submit(function () {
        let code            = $("#code_input").val().trim(),
            libelle         = $("#libelle_input").val().trim(),
            pays            = $("#pays_input").val().trim(),
            region          = $("#region_input").val().trim(),
            departement     = $("#departement_input").val().trim(),
            commune         = $("#commune_input").val().trim(),
            adresse_postale = $("#adresse_postale_input").val().trim(),
            adresse_geo     = $("#adresse_geo_input").val().trim(),
            email           = $("#email_input").val().trim(),
            num_telephone_1 = $("#num_telephone_1_input").val().trim(),
            num_telephone_2 = $("#num_telephone_2_input").val().trim();
        if (libelle && pays && region && departement && commune && email && num_telephone_1) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Etablissement/Fournisseurs/submit_edition_fournisseur.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'pays': pays,
                    'region': region,
                    'departement': departement,
                    'commune': commune,
                    'adresse_postale': adresse_postale,
                    'adresse_geo': adresse_geo,
                    'email': email,
                    'num_telephone_1': num_telephone_1,
                    'num_telephone_2': num_telephone_2
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_fournisseur").hide();
                        $("#p_fournisseur_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="fournisseurs?code="+data['code'].toLowerCase();
                        }, 3000);
                    } else {
                        $("#p_fournisseur_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
            }
            if (!pays) {
                $("#pays_input").addClass('is-invalid');
                $("#paysHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le pays SVP.");
            }
            if (!region) {
                $("#region_input").addClass('is-invalid');
                $("#regionHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la région SVP.");
            }
            if (!departement) {
                $("#departement_input").addClass('is-invalid');
                $("#departementHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le département SVP.");
            }
            if (!commune) {
                $("#commune_input").addClass('is-invalid');
                $("#communeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la commune SVP.");
            }
            if (!email) {
                $("#email_input").addClass('is-invalid');
                $("#emailHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'adresse email SVP.");
            }
            if (!num_telephone_1) {
                $("#num_telephone_1_input").addClass('is-invalid');
                $("#numtelephone1Help")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le numéro de téléphone SVP.");
            }
        }
        return false;
    });
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});
$(".date").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    maxDate: 0,
    lang: 'fr'
});
$("#table_fournisseurs").DataTable();
