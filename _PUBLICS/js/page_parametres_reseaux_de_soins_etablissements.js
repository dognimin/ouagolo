jQuery(function () {
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $("#etablissement_code").keyup(function () {
        let code_etablissement     = $(this).val().trim();
        if(code_etablissement) {
            $("#etablissement_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeEtablissementHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#etablissement_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeEtablissementHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un etablissement SVP.");
        }
    });

    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouvel établissement');
        return false;
    });

    $("#form_reseau_etablissement").submit(function () {
        let code_reseau = $("#code_input").val().trim(),
         etablissement_code = $("#etablissement_code").val().trim();
 if (etablissement_code){
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin_etablissement.php',
            type: 'POST',
            data: {
                'code_reseau': code_reseau,
                'etablissement_code': etablissement_code,

            },
            dataType: 'json',
            success: function (data) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_reseau_etablissement").hide();
                    $("#p_reseau_etablissement_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
                }else {
                    $("#p_reseau_etablissement_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
    }
else {
        if(!etablissement_code) {
            $("#code_etablissement_input").addClass('is-invalid');
            $("#codeEtablissementHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un établissement SVP.");
        }
        }
        return false;
    });
    $('#editionDureevieModal').modal({
        show: false,
        backdrop: 'static'
    });
    $('#historiqueModal').modal({
        show: false,
        backdrop: 'static'
    });

    $('#AutorisationDoubleModal').modal({
        show: false,
        backdrop: 'static'
    });

    $('#tableDeValeurs').DataTable();
    $(".btn_edit").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code_reseau = tableau[0],
            code_etablissement = tableau[1];
        $("#code").val(code_reseau).prop('disabled',true);
        $("#etablissement_code").val(code_etablissement);



        $(".card-title").html("Edition d'un établissement");

    });

    $(".button_historique").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            donnee1 = tableau[0],
            donnee2 = tableau[1],
            type_donnee = tableau[2];
        if(donnee1 && type_donnee) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
                type: 'POST',
                data: {
                    'donnee1': donnee1,
                    'donnee2': donnee2,
                    'type': type_donnee
                },
                success: function (data) {
                    $("#div_historique").html(data);
                }
            });
        }
    });
    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("../exporter-reseaux-de-soins.php?type="+code_export+"&data=res_etab", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });

});