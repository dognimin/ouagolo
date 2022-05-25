jQuery(function () {
    $(document).on('click', '.button_edition_acte', function(){
        let code_acte = this.id;
        if(code_acte) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Parametres/PanierDeSoins/search_acte_medical.php',
                type: 'POST',
                data: {
                    'code_acte': code_acte
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#editionActeModalLabel").html("Edition acte "+data['code']);
                        $("#code_acte_input").val(data['code']);
                        $("#libelle_acte_input").val(data['libelle']);
                        $("#type_facture_input").val(data['type_facture']);
                        $("#tarif_acte_input").val(data['tarif']);
                        $("#date_debut_acte_input").val(data['date_debut']);
                    }else {
                        $("#p_etablissement_panier_soins_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
    });

    $("#form_etablissement_panier_soins").submit(function () {
        let code            = $("#code_acte_input").val().trim(),
            libelle         = $("#libelle_acte_input").val().trim(),
            type_facture    = $("#type_facture_input").val().trim(),
            tarif           = $("#tarif_acte_input").val().trim(),
            date_debut      = $("#date_debut_acte_input").val().trim();
        if(code && libelle && tarif && date_debut) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Parametres/PanierDeSoins/submit_acte_medical.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'type_facture': type_facture,
                    'tarif': tarif,
                    'date_debut': date_debut
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_panier_soins").hide();
                        $("#p_etablissement_panier_soins_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_etablissement_panier_soins_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
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
$("#table_actes").DataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});