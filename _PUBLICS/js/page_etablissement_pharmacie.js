jQuery(function () {
    $("#button_nouvelle_vente").click(function () {
        $("#div_nouvelle_vente").fadeIn();
    });
    $("#button_retourner").click(function () {
        $("#div_nouvelle_vente").fadeOut();
    });

    $("#num_facture_initiale_input").keyup(function () {
        $("#form_vente")[0].reset();
        $("#tbody_produits").html('');
    }).keypress(function () {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode === 13){
           let num_facture_initiale = $(this).val().trim();
           if(num_facture_initiale) {
               console.log(num_facture_initiale);
           } else {

           }
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
                let prix_unitaire                   = ui.item.prix_unitaire,
                    quantite                        = ui.item.quantite,
                    montant_brut                    = (prix_unitaire * quantite),
                    remise                          = parseInt($("#remise_produit_input").val().trim()),
                    taux_organisme                  = parseInt($("#taux_organisme_input").val().trim()),
                    montant_organisme               = (montant_brut * taux_organisme / 100),
                    montant_brut_apres_organisme    = (montant_brut - montant_organisme),
                    montant_remise                  = (montant_brut_apres_organisme * remise / 100),
                    montant_net                     = (montant_brut - (montant_organisme + montant_remise));
                $("#code_produit_input").val(ui.item.value);
                $("#libelle_produit_input").val(ui.item.label);
                $("#quantite_en_stock_input").val(ui.item.quantite_stock);
                $("#prix_unitaire_input").val(prix_unitaire);
                $("#quantite_input").val(quantite);
                $("#montant_depense_input").val(montant_net);
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
            $("#montant_depense_input").val(0);
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

    $("#remise_produit_input").change(function () {
        let remise = $(this).val().trim(),
            prix_unitaire                   = $("#prix_unitaire_input").val().trim(),
            taux_organisme                  = parseInt($("#taux_organisme_input").val().trim()),
            quantite                        = $("#quantite_input").val().trim(),
            montant_brut                    = (prix_unitaire * quantite),
            montant_organisme               = (montant_brut * taux_organisme / 100),
            montant_brut_apres_organisme    = (montant_brut - montant_organisme),
            montant_remise                  = (montant_brut_apres_organisme * remise / 100),
            montant_net                     = (montant_brut - (montant_organisme + montant_remise));
        $("#montant_depense_input").val(montant_net);
    });

    $("#quantite_input").change(function () {
        let remise              = $("#remise_produit_input").val().trim(),
            prix_unitaire       = $("#prix_unitaire_input").val().trim(),
            taux_organisme      = parseInt($("#taux_organisme_input").val().trim()),
            quantite            = $(this).val().trim(),
            montant_brut                    = (prix_unitaire * quantite),
            montant_organisme               = (montant_brut * taux_organisme / 100),
            montant_brut_apres_organisme    = (montant_brut - montant_organisme),
            montant_remise                  = (montant_brut_apres_organisme * remise / 100),
            montant_net                     = (montant_brut - (montant_organisme + montant_remise));
        $("#montant_depense_input").val(montant_net);
    });

    $("#button_ajouter_produit").click(function () {
        let code_produit                = [],
            libelle                     = $("#libelle_produit_input").val().trim(),
            code                        = $("#code_produit_input").val().trim(),
            quantite_en_stock           = parseInt($("#quantite_en_stock_input").val().trim()),
            taux_organisme_produit      = parseInt($("#taux_organisme_produit_input").val().trim()),
            prix_unitaire               = parseInt($("#prix_unitaire_input").val().trim()),
            taux_rgb_produit            = parseInt($("#taux_rgb_produit_input").val().trim()),
            quantite                    = parseInt($("#quantite_input").val().trim()),
            taux_remise_produit         = parseInt($("#remise_produit_input").val().trim()),
            montant_depense             = parseInt(prix_unitaire * quantite),
            montant_rgb                 = 0,
            montant_apres_rgb           = 0,
            montant_organisme           = 0,
            montant_apres_organisme     = 0,
            montant_remise              = 0,
            montant_apres_remise        = 0,
            montant_facture             = parseInt($("#montant_facture_input").val().trim()),
            montant_facture_rgb         = parseInt($("#montant_facture_rgb_input").val().trim()),
            montant_facture_organisme   = parseInt($("#montant_facture_organisme_input").val().trim()),
            remise_facture              = parseInt($("#remise_facture_input").val().trim()),
            montant_net                 = parseInt($("#montant_net_input").val().trim());
        if (quantite_en_stock !== 0) {
            if (libelle && code && prix_unitaire && quantite && montant_depense) {
                $("#table_facture_produits").slideDown();
                $(".code_produit_td").each(function () {
                    code_produit.push($(".code_produit_td").html());});
                if (jQuery.inArray(code, code_produit) === -1) {
                    montant_rgb = (montant_depense * taux_rgb_produit / 100);
                    montant_apres_rgb = (montant_depense - montant_rgb);
                    montant_organisme = (montant_apres_rgb * taux_organisme_produit / 100);
                    montant_apres_organisme = montant_apres_rgb - montant_organisme;
                    montant_remise = (montant_apres_organisme * taux_remise_produit / 100);
                    montant_apres_remise = (montant_apres_organisme - montant_remise);


                    $("#montant_rgb_input").val(montant_rgb);

                    $("#p_erreur_produits").removeClass('alert alert-danger align_center').html('');
                    $("#tbody_produits").append('<tr id="tr_'+code+'">' +
                        '<td><strong>#</strong></td>' +
                        '<td class="code_produit_td">'+code+'</td>' +
                        '<td>'+libelle+'</td>' +
                        '<td class="align_right prix_unitaire_td" id="prix_unitaire_td'+code+'">'+prix_unitaire+'</td>' +
                        '<td class="align_right quantite_td" id="quantite_td'+code+'">'+quantite+'</td>' +
                        '<td class="align_right taux_rgb_td" id="taux_rgb_td'+code+'">'+taux_rgb_produit+'</td>' +
                        '<td class="align_right taux_organisme_td" id="taux_organisme_td'+code+'">'+taux_organisme_produit+'</td>' +
                        '<td class="align_right taux_remise_td" id="taux_remise_td'+code+'">'+taux_remise_produit+'</td>' +
                        '<td class="align_right montant_depense_td" id="montant_depense_td'+code+'">'+montant_apres_remise+'</td>' +
                        '<td><button type="button" class="badge bg-danger button_retirer_produit" id="'+code+'"><i class="bi bi-x-lg"></i></button></td>' +
                        '</tr>');

                    $("#libelle_produit_input").val('');
                    $("#code_produit_input").val('');
                    $("#quantite_en_stock_input").val(0);
                    $("#prix_unitaire_input").val(0);
                    $("#quantite_input").val(1);
                    $("#taux_rgb_produit_input").val(0);
                    $("#taux_organisme_produit_input").val(0);
                    $("#remise_produit_input").val(0);
                    $("#montant_depense_input").val(0);

                    montant_facture += montant_apres_remise;
                    montant_facture_rgb += montant_rgb;
                    montant_facture_organisme += montant_organisme;
                    montant_net = montant_facture - (montant_facture * remise_facture / 100);


                    $("#montant_facture_input").val(montant_facture);
                    $("#montant_facture_rgb_input").val(montant_facture_rgb);
                    $("#montant_facture_organisme_input").val(montant_facture_organisme);
                    $("#montant_net_input").val(montant_net);
                    $("#montant_net_a_payer_input").val(montant_net);
                } else {
                    $("#p_erreur_produits").addClass('alert alert-danger align_center').html('Ce produit a déjà été saisi.');
                }
            } else {
                $("#p_erreur_produits").addClass('alert alert-danger align_center').html('Ce produit est indisponible en stock.');
            }
        }

        let code_produits = $.map($(".code_produit_td"),function (select) {
            return $(select).html();});
        if (!code_produits) {
            $("#button_valider_facture").prop('disabled', true);
        } else {
            $("#button_valider_facture").prop('disabled', false);
        }

    });
    $(document).on('click', '.button_retirer_produit', function () {
        let code            = this.id,
            code_produits   = $.map($(".code_produit_td"),function (select) {
                return $(select).html();}),
            nombre_produits = code_produits.length,
            montant_facture = parseInt($("#montant_facture_input").val().trim()),
            remise_facture  = parseInt($("#remise_facture_input").val().trim()),
            montant_net     = parseInt($("#montant_net_input").val().trim()),
            montant_depense = parseInt($("#montant_depense_td"+code).html());
        if (code) {
            montant_facture -= montant_depense;
            montant_net = montant_facture - (montant_facture * remise_facture / 100);
            $("#tbody_produits").find("#tr_"+code).remove();
            $("#montant_facture_input").val(montant_facture);
            $("#montant_net_input").val(montant_net);
            $("#montant_net_a_payer_input").val(montant_net);

            if (nombre_produits === 1) {
                $("#button_valider_facture").prop('disabled', true);
            } else {
                $("#button_valider_facture").prop('disabled', false);
            }
        }
    });

    $("#mode_paiement_input").change(function () {
        let mode_paiement = $("#mode_paiement_input").val().trim();
        if (mode_paiement === 'ESP') {
            $("#div_paiement_especes").slideDown();
        } else {
            $("#div_paiement_especes").hide();
            $("#montant_recu_input").val('').focus();
            $("#monnaie_rendue_input").val(0);
        }
    });

    $("#montant_recu_input")
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            let montant_recu    = $(this).val().trim(),
                montant_net     = parseInt($("#montant_net_input").val().replace(/\s+/g, '')),
                nouveau_montant = 0,
                monnaie         = 0;
            if (isNaN(montant_recu)) {
                nouveau_montant = montant_recu.slice(0, -1);
                $(this).val(nouveau_montant);
            } else {
                if (montant_recu >= montant_net) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    monnaie = (montant_recu - montant_net);
                    $("#monnaie_rendue_input").val(monnaie.toLocaleString('fr'));

                    $("#montant_recu_input")
                        .removeClass('is-invalid')
                        .addClass('is-valid');
                    $("#montantRecuHelp")
                        .addClass('text-danger')
                        .html("");
                } else {
                    $("#monnaie_rendue_input").val(0);
                    $("#montant_recu_input")
                        .removeClass('is-valid')
                        .addClass('is-invalid');
                    $("#montantRecuHelp")
                        .addClass('text-danger')
                        .html("Montant reçu.");
                }
            }
        })
        .blur(function () {
            let montant_recu    = parseInt($(this).val().trim()),
                montant_net     = parseInt($("#montant_net_input").val().trim().replace(' ','')),
                nouveau_montant = 0,
                monnaie         = 0;
            if (montant_recu < montant_net) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                $(this).val('');
            }
        });

    $("#form_pharmacie_vente").submit(function () {
        let num_facture_initiale    = $("#num_facture_initiale_input").val().trim(),
            num_ip                  = $("#num_ip_input").val().trim(),
            code_organisme          = $("#code_organisme_input").val().trim(),
            taux_organisme          = $("#taux_organisme_input").val().trim(),
            code_collectivite       = $("#code_collectivite_input").val().trim(),
            code_produit            = $.map($(".code_produit_td"),function (select) {
                return $(select).html();}),
            prix_unitaire           = $.map($(".prix_unitaire_td"),function (select) {
                return $(select).html();}),
            quantite                = $.map($(".quantite_td"),function (select) {
                return $(select).html();}),
            taux_rgb_produit        = $.map($(".taux_rgb_td"),function (select) {
                return $(select).html();}),
            taux_organisme_produit  = $.map($(".taux_organisme_td"),function (select) {
                return $(select).html();}),
            taux_remise_produit     = $.map($(".taux_remise_td"),function (select) {
                return $(select).html();}),
            montant_brut            = $("#montant_facture_input").val().trim(),
            montant_rgb             = $("#montant_facture_rgb_input").val().trim(),
            montant_organisme       = $("#montant_facture_organisme_input").val().trim(),
            remise_facture          = $("#remise_facture_input").val().trim(),
            montant_net             = $("#montant_net_input").val().trim(),
            mode_paiement           = $("#mode_paiement_input").val().trim(),
            montant_recu            = $("#montant_recu_input").val().trim(),
            monnaie_rendue          = $("#monnaie_rendue_input").val().trim();
        if (code_produit && mode_paiement) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Pharmacie/submit_paiement_vente.php',
                type: 'POST',
                data: {
                    'num_facture_initiale': num_facture_initiale,
                    'num_ip': num_ip,
                    'code_organisme': code_organisme,
                    'taux_organisme': taux_organisme,
                    'code_collectivite': code_collectivite,

                    'code_produit': code_produit,
                    'prix_unitaire': prix_unitaire,
                    'quantite': quantite,
                    'taux_rgb_produit': taux_rgb_produit,
                    'taux_organisme_produit': taux_organisme_produit,
                    'taux_remise_produit': taux_remise_produit,

                    'montant_brut': montant_brut,
                    'montant_rgb': montant_rgb,
                    'montant_organisme': montant_organisme,
                    'remise_facture': remise_facture,
                    'montant_net': montant_net,
                    'mode_paiement': mode_paiement,
                    'montant_recu': montant_recu,
                    'monnaie_rendue': monnaie_rendue,
                },
                dataType: 'json',
                success: function (data) {
                    if (data['success'] === true) {
                        $("#form_pharmacie_vente").hide();
                        $("#p_pharmacie_vente_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
                        window.open('imprimer-recu?num='+data['code'], '/', params);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#p_pharmacie_vente_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });
});
$("#table_ventes").dataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});
