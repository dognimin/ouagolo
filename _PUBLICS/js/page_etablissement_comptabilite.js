jQuery(function () {
    $("#form_search_ets_ecritures_comptables").submit(function () {
        let num_piece = $("#num_piece_search_input").val().trim(),
            libelle    = $("#libelle_piece_input").val().trim(),
            date_debut  = $("#date_debut_search_input").val().trim(),
            date_fin    = $("#date_fin_search_input").val().trim();
        if (date_debut && date_fin) {
            display_etablissement_ecritures_comptables(num_piece, libelle, date_debut, date_fin)
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