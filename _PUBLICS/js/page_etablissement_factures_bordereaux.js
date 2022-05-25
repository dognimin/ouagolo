jQuery(function () {
    $('#multiselect').multiselect();
    $("#date_debut_input").change(function () {
        let date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim(),
            code_organisme      = $("#code_organisme_input").val().trim(),
            code_type_facture   = $("#code_type_facture_input").val().trim();
        display_etablissement_search_factures(code_organisme, code_type_facture, date_debut, date_fin);
    });
    $("#date_fin_input").change(function () {
        let date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim(),
            code_organisme      = $("#code_organisme_input").val().trim(),
            code_type_facture   = $("#code_type_facture_input").val().trim();
        display_etablissement_search_factures(code_organisme, code_type_facture, date_debut, date_fin);
    });
    $("#code_organisme_input").change(function () {
        let date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim(),
            code_organisme      = $("#code_organisme_input").val().trim(),
            code_type_facture   = $("#code_type_facture_input").val().trim();
        display_etablissement_search_factures(code_organisme, code_type_facture, date_debut, date_fin);
    });
    $("#code_type_facture_input").change(function () {
        let date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim(),
            code_organisme      = $("#code_organisme_input").val().trim(),
            code_type_facture   = $("#code_type_facture_input").val().trim();
        display_etablissement_search_factures(code_organisme, code_type_facture, date_debut, date_fin);
    });
    $("#form_etablissement_factures_bordereau").submit(function () {

        let date_debut          = $("#date_debut_input").val().trim(),
            date_fin            = $("#date_fin_input").val().trim(),
            code_organisme      = $("#code_organisme_input").val().trim(),
            code_type_facture   = $("#code_type_facture_input").val().trim(),
            num_factures        = $.map($("#multiselect_to"),function (select) {
                return $(select).val();});

        if (date_debut && date_fin && code_organisme && code_type_facture && num_factures) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Factures/submit_edition_factures_bordereau.php',
                type: 'POST',
                data: {
                    'date_debut': date_debut,
                    'date_fin': date_fin,
                    'code_organisme': code_organisme,
                    'type_facture': code_type_facture,
                    'num_factures': num_factures
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_factures_bordereau").hide();
                        $("#p_etablissement_factures_bordereau_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="bordereaux?num="+data['num_bordereau'];
                        }, 3000);
                    } else {
                        $("#p_etablissement_factures_bordereau_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!code_organisme) {
                $("#code_organisme_input").addClass('is-invalid');
                $("#codeOrganismeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner l'organisme SVP.");
            }
            if (!code_type_facture) {
                $("#code_type_facture_input").addClass('is-invalid');
                $("#typeFactureHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de facture SVP.");
            }
        }

        return false;
    });

    $("#button_imprimer_bordereau").click(function () {
        let num_bordereau = $("#strong_num_bordereau").html();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-bordereau?num='+num_bordereau, '/', params);
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
