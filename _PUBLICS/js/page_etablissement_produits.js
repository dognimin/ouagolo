jQuery(function () {

    $("#libelle_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_medicaments.php", {
                    libelle: $('#libelle_input').val().trim()
                    }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_input").val(ui.item.value);
            $("#libelle_input").val(ui.item.label);
            return false;
        }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_input").val('');
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
        });


    $("#produit_achat_input").change(function () {
        if (this.checked) {
            $("#div_prix_achat").show();
            $("#prix_achat_input").prop('required', true);
        } else {
            $("#div_prix_achat").hide();
            $("#prix_achat_input").prop('required', false);
        }
    });

    $("#produit_vente_input").change(function () {
        if (this.checked) {
            $("#div_prix_vente").show();
            $("#prix_vente_input").prop('required', true);
        } else {
            $("#div_prix_vente").hide();
            $("#prix_vente_input").prop('required', false);
        }
    });

    $("#form_produit").submit(function () {
        let code            = $("#code_input").val().trim(),
            nature          = $("#nature_input").val().trim(),
            libelle         = $("#libelle_input").val().trim(),
            description     = $("#description_input").val().trim(),
            limite_stock    = $("#alert_limite_stock_input").val().trim(),
            achat           = null,
            prix_achat      = $("#prix_achat_input").val().trim(),
            vente           = null,
            prix_vente      = $("#prix_vente_input").val().trim(),
            perissable      = null;

        if ($("#produit_achat_input").is(":checked")) {
            achat = 1;
        } else {
            achat = 0;}

        if ($("#produit_vente_input").is(":checked")) {
            vente = 1;
        } else {
            vente = 0;}

        if ($("#produit_perissable_input").is(":checked")) {
            perissable = 1;
        } else {
            perissable = 0;}

        if (nature && libelle && limite_stock) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Pharmacie/submit_edition_produit.php',
                type: 'POST',
                data: {
                    'code': code,
                    'nature': nature,
                    'libelle': libelle,
                    'achat': achat,
                    'prix_achat': prix_achat,
                    'vente': vente,
                    'prix_vente': prix_vente,
                    'perissable': perissable,
                    'description': description,
                    'limite_stock': limite_stock
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_produit").hide();
                        $("#p_produit_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    } else {
                        $("#p_produit_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#form_search_produits").submit(function () {
        let code    = $("#code_produit_search_input").val().trim(),
            libelle = $("#libelle_search_input").val().trim(),
            nature  = $("#nature_search_input").val().trim(),
            type    = $("#type_search_input").val().trim();
        if (code || libelle || nature || type) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_produits.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'nature': nature,
                    'type': type
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
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});