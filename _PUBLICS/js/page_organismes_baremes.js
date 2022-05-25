jQuery(function () {
    $("#libelle_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle.length > 3) {
            $("#libelle_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libelleHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#libelle_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libelleHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé SVP.");
        }
    });

    $("#form_bareme").submit(function () {
        let code                = $("#code_input").val().trim(),
            libelle             = $("#libelle_input").val().trim().toUpperCase(),
            description         = $("#description_input").val().trim().toUpperCase();
        if(libelle.length > 3) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Organismes/Baremes/submit_edition.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'description': description
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    if (data['success'] === true) {
                        $("#form_bareme").hide();
                        $("#p_bareme_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../organismes/baremes?code="+data['code'];
                        }, 5000);
                    } else {
                        $("#p_bareme_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if(!libelle) {
                $("#libelle_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
            }
            if(!code_panier_soins) {
                $("#code_panier_soins_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codePanierSoinsHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner un panier de soins SVP.");
            }
            if(!code_reseau_soins) {
                $("#code_reseau_soins_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codeReseauSoinsHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner un réseau de soins SVP.");
            }
        }
        return false;
    });
});
$("#table_baremes").dataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});