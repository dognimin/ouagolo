jQuery(function () {
    $("#libelle_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle) {
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
    $("#code_panier_soins_input").change(function () {
        let code_panier_soins     = $(this).val().trim();
        if(code_panier_soins) {
            $("#code_panier_soins_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePanierSoinsHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_panier_soins_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codePanierSoinsHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un panier de soins  SVP.");
        }
    });
    $("#code_reseau_soins_input").change(function () {
        let code_reseau_soins     = $(this).val().trim();
        if(code_reseau_soins) {
            $("#code_reseau_soins_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeReseauSoinsHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_reseau_soins_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeReseauSoinsHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un réseau de soins  SVP.");
        }
    });

    $("#form_organisme_produit").submit(function () {
        let code                = $("#code_input").val().trim(),
            libelle             = $("#libelle_input").val().trim().toUpperCase(),
            description         = $("#description_input").val().trim().toUpperCase(),
            code_panier_soins   = $("#code_panier_soins_input").val().trim(),
            code_reseau_soins   = $("#code_reseau_soins_input").val().trim();
        if(libelle && code_panier_soins && code_reseau_soins) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Parametres/Produits/submit_edition_produit.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'description': description,
                    'code_panier_soins': code_panier_soins,
                    'code_reseau_soins': code_reseau_soins
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    if (data['success'] === true) {
                        $("#form_organisme_produit").hide();
                        $("#p_organisme_produit_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../parametres/produits?code="+data['code'];
                        }, 5000);
                    } else {
                        $("#p_organisme_produit_resultats").removeClass('alert alert-success')
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
$("#table_produits").DataTable();
$("#table_contrats").DataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});