jQuery(function () {

    $("#form_search_commandes").submit(function () {
        let code_commande       = $("#code_commande_search_input").val().trim(),
            code_fournisseur    = $("#code_fournisseur_search_input").val().trim(),
            statut              = $("#statut_search_input").val().trim(),
            date_debut          = $("#date_debut_search_input").val().trim(),
            date_fin            = $("#date_fin_search_input").val().trim();
        if (date_debut && date_fin) {
            display_etablissement_commandes(code_commande, code_fournisseur, statut, date_debut, date_fin);
        }
        return false;
    });

    $("#libelle_produit_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_liste_produits.php", {
                    libelle: $('#libelle_produit_input').val().trim()
                }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_produit_input").val(ui.item.value);
            $("#libelle_produit_input").val(ui.item.label);
            $("#quantite_en_stock_input").val(ui.item.quantite_stock);
            $("#prix_unitaire_input").val(ui.item.prix_unitaire);
            $("#quantite_input").val(ui.item.quantite);
            $("#montant_ht_input").val(ui.item.montant_ht);
            return false;
        }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_produit_input").val('');
            $("#quantite_en_stock_input").val(0);
            $("#prix_unitaire_input").val(0);
            $("#quantite_input").val(1);
            $("#montant_ht_input").val(0);
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_produit_input").val();
            if (!code) {
                $("#libelle_produit_input").val('');
            }
        });

    $("#remise_input").change(function () {
        let remise = $(this).val().trim(),
            prix_unitaire = $("#prix_unitaire_input").val().trim(),
            quantite = $("#quantite_input").val().trim(),
            montant_brut = (prix_unitaire * quantite),
            montant_remise = (montant_brut * remise / 100),
            montant_net = (montant_brut - montant_remise);
        $("#montant_ht_input").val(montant_net);
    });

    $("#quantite_input").change(function () {
        let remise = $("#remise_input").val().trim(),
            prix_unitaire = $("#prix_unitaire_input").val().trim(),
            quantite = $(this).val().trim(),
            montant_brut = (prix_unitaire * quantite),
            montant_remise = (montant_brut * remise / 100),
            montant_net = (montant_brut - montant_remise);
        $("#montant_ht_input").val(montant_net);
    });

    $("#button_ajouter_produit").click(function () {
        let code_produit        = [],
            montant_commande    = parseInt($("#th_montant_commande").html()),
            libelle             = $("#libelle_produit_input").val().trim(),
            code                = $("#code_produit_input").val().trim(),
            prix_unitaire       = $("#prix_unitaire_input").val().trim(),
            quantite            = $("#quantite_input").val().trim(),
            remise              = $("#remise_input").val().trim(),
            montant_depense     = $("#montant_ht_input").val().trim();
        if (libelle && code && prix_unitaire && quantite && montant_depense) {
            $("#table_commande_produits").slideDown();
            $('.code_produit_td').each(function () {
                code_produit.push($(".code_produit_td").html());});
            if (jQuery.inArray(code, code_produit) === -1) {
                $("#p_erreur_commande").removeClass('alert alert-danger align_center').html('');
                $("#tbody_produits").append('<tr id="tr_'+code+'">' +
                    '<td></td>' +
                    '<td class="code_produit_td">'+code+'</td>' +
                    '<td>'+libelle+'</td>' +
                    '<td class="align_right prix_unitaire_td" id="prix_unitaire_td'+code+'">'+prix_unitaire+'</td>' +
                    '<td class="align_right quantite_td" id="quantite_td'+code+'">'+quantite+'</td>' +
                    '<td class="align_right remise_td" id="remise_td'+code+'">'+remise+'%</td>' +
                    '<td class="align_right montant_depense_td" id="montant_depense_td'+code+'">'+montant_depense+'</td>' +
                    '<td><button type="button" class="badge bg-danger button_retirer_produit" id="'+code+'"><i class="bi bi-x-lg"></i></button></td>' +
                    '</tr>');
                montant_commande += parseInt(montant_depense);
                $("#th_montant_commande").html(montant_commande);

                $("#libelle_produit_input").val('');
                $("#code_produit_input").val('');
                $("#prix_unitaire_input").val('');
                $("#quantite_input").val(1);
                $("#remise_input").val(0);
                $("#montant_ht_input").val('');
            } else {
                $("#p_erreur_commande").addClass('alert alert-danger align_center').html('Ce produit a déjà été saisi.');
            }
        }
    });
    $(document).on('click', '.button_retirer_produit', function () {
        let code            = this.id,
            montant_commande = parseInt($("#th_montant_commande").html()),
            montant_depense = parseInt($("#montant_depense_td"+code).html());
        if (code) {
            montant_commande -= montant_depense;
            $("#th_montant_commande").html(montant_commande);
            $("#tbody_produits").find("#tr_"+code).remove();
        }
    });

    $("#form_etablissement_commande").submit(function () {
        let code                = $("#code_input").val().trim(),
            code_fournisseur    = $("#code_fournisseur_input").val().trim(),
            code_produit        = $.map($(".code_produit_td"),function (select) {
                return $(select).html();}),
            prix_unitaire       = $.map($(".prix_unitaire_td"),function (select) {
                return $(select).html();}),
            quantite            = $.map($(".quantite_td"),function (select) {
                return $(select).html();}),
            remise              = $.map($(".remise_td"),function (select) {
                return $(select).html();});
        if (code_fournisseur && code_produit && quantite) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Enregistrement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Pharmacie/submit_edition_commande.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_fournisseur': code_fournisseur,
                    'code_produit': code_produit,
                    'prix_unitaire': prix_unitaire,
                    'quantite': quantite,
                    'remise': remise
                },
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_commande").hide();
                        $("#p_etablissement_commande_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../pharmacie/commandes?num="+data['code'];
                        }, 3000);
                    } else {
                        $("#p_etablissement_commande_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $(".quantite_receptionnee").change(function () {
        let code                    = this.id,
            quantite_receptionnee   = $(this).val().trim();
        if (code) {
            let prix_unitaire   = $("#prix_unitaire_"+code+"_input").val().trim(),
                montant         = parseInt(quantite_receptionnee * prix_unitaire);
            $("#montant_"+code+"_input").val(montant);
        }
    });

    $("#form_etablissement_reception_commande").submit(function () {
        let code_commande   = $("#code_commande_input").val().trim(),
            code_produit    = $.map($(".code_produit"),function (select) {
                return $(select).val();}),
            quantite        = $.map($(".quantite_receptionnee"),function (select) {
                return $(select).val();});
        if (code_commande && code_produit && quantite) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Enregistrement...</i>');

            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Pharmacie/submit_edition_reception_commande.php',
                type: 'POST',
                data: {
                    'code_commande': code_commande,
                    'code_produit': code_produit,
                    'quantite': quantite
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_reception_commande").hide();
                        $("#p_etablissement_reception_commande_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_etablissement_reception_commande_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $(".button_imprimer").click(function () {
        let code = this.id;
        if (code) {
            let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
            window.open('imprimer-commande?num='+code, '/', params);

        }
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