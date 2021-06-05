jQuery(function () {
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $("#code_etablissement_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#etabli")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });

    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau réseau de soin');
        return false;
    });
    $(".btn_edit").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            libelle = tableau[1];
        $("#code_input").val(code).prop('disabled',true);
        $("#libelle_input").val(libelle);



        $(".card-title").html("Edition d'un reseau de soin");

    });
    $('#historiqueModal').modal({
        show: false,
        backdrop: 'static'
    });

    $(".button_historique").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            donnee = tableau[0],
            type_donnee = tableau[1];
        if(donnee && type_donnee) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
                type: 'POST',
                data: {
                    'donnee': donnee,
                    'type': type_donnee
                },
                success: function (data) {
                    $("#div_historique").html(data);
                }
            });
        }
    });
    $("#form_reseau").submit(function () {
        let code = $("#code_input").val().trim(),
         libelle = $("#libelle_input").val().trim();
        if (code && libelle){
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');

        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Parametres/ReseauxDeSoins/submit_reseau_de_soin.php',
            type: 'POST',
            data: {
                'code': code,
                'libelle': libelle
            },
            dataType: 'json',
            success: function (data) {
                $("#button_duree_de_vie_mdp").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_reseau").hide();
                    $("#p_reseau_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload(true);
                    },5000);
                }else {
                    $("#p_reseau_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
        }else{
            if(!code) {
                $("#code_input").addClass('is-invalid');
                $("#codeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code SVP.");
            }
            if(!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libelle SVP.");
            }
        }
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

    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("../exporter-reseaux-de-soins.php?type="+code_export+"&data=res", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });

});