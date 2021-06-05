jQuery(function () {
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $("#medicamnent_code").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#medicamnent_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeMedicamentHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#medicamnent_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeMedicamentHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });

    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau medicament');
        return false;
    });

    $("#form_reseau_medicament").submit(function () {
        let code_reseau = $("#code_input").val().trim(),
         medicament_code = $("#medicamnent_code").val().trim(),
         tarif = $("#tarif_input").val().trim();
 if (medicament_code && tarif){
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin_medicament.php',
            type: 'POST',
            data: {
                'code_reseau': code_reseau,
                'medicament_code': medicament_code,
                'tarif': tarif
            },
            dataType: 'json',
            success: function (data) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_reseau_medicament").hide();
                    $("#p_reseau_medicament_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
                }else {
                    $("#p_reseau_medicament_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
    }
else {
        if(!medicament_code) {
            $("#medicamnent_code").addClass('is-invalid');
            $("#codeMedicamentHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le code du médicament SVP.");
        }
        if(!tarif) {
            $("#tarif_input").addClass('is-invalid');
            $("#tarifHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le tarif SVP.");
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
            tarif = tableau[2],
            code_medicament = tableau[1];
        $("#code").val(code_reseau).prop('disabled',true);
        $("#medicamnent_code").val(code_medicament);
        $("#tarif_input").val(tarif);


        $(".card-title").html("Edition d'un medicament");

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
            window.open("../exporter-reseaux-de-soins.php?type="+code_export+"&data=res_med", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });

});