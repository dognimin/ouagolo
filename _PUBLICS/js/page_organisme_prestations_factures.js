jQuery(function () {
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
                $("#code_etablissement_input").val(ui.item.code);
                $("#raison_sociale_input").val(ui.item.label);
                $("#btn_search").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-success')
                    .html('<i class="bi bi-search"></i>');
                let code = $("#code_etablissement_input").val();
                if(!code) {
                    $("#raison_sociale_input").val('');
                }
                return false;
            }
        })
        .keyup(function () {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#code_etablissement_input").val('');

        })
        .blur(function () {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            let code = $("#code_etablissement_input").val();
            if(!code) {
                $("#raison_sociale_input").val('');
            }
        });

    $("#form_search_organisme_factures").submit(function () {
        let num_facture         = $("#num_facture_input").val().trim(),
            num_secu            = $("#num_secu_input").val().trim(),
            nom_prenoms         = $("#nom_prenoms_input").val().trim(),
            code_etablissement  = $("#code_etablissement_input").val().trim(),
            rubrique            = $("#rubrique_input").val().trim();

        if(rubrique && (num_facture || num_secu || nom_prenoms || code_etablissement)) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Organisme/Prestations/Factures/search_factures.php',
                type: 'POST',
                data: {
                    'num_facture': num_facture,
                    'num_secu': num_secu,
                    'nom_prenoms': nom_prenoms,
                    'code_etablissement': code_etablissement,
                    'rubrique': rubrique
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