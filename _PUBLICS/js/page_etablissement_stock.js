jQuery(function () {
    $("#libelle_produit_search_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_liste_produits.php", {
                    libelle: $('#libelle_produit_search_input').val().trim()
                }, response);
            },
            minLength: 2,
            select: function (e, ui) {
                $("#code_produit_search_input").val(ui.item.value);
                $("#libelle_produit_search_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $("#code_produit_search_input").val('');
        })
        .blur(function () {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            let code = $("#code_produit_search_input").val();
            if (!code) {
                $("#libelle_produit_search_input").val('');
            }
        });

    $("#form_search_stocks").submit(function () {
        let code_produit       = $("#code_produit_search_input").val().trim(),
            date_debut          = $("#date_debut_search_input").val().trim(),
            date_fin            = $("#date_fin_search_input").val().trim();
        if (date_debut && date_fin) {
            display_etablissement_stock(code_produit, date_debut, date_fin);
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