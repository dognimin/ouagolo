jQuery(function () {
    $("#form_search_ets_factures").submit(function () {
        let num_facture     = $("#num_facture_search_input").val().trim(),
            num_secu        = $("#num_secu_search_input").val().trim(),
            num_patient     = $("#nip_search_input").val().trim(),
            nom_prenom      = $("#nom_prenoms_input").val().trim(),
            date_debut      = $("#date_debut_search_input").val().trim(),
            date_fin        = $("#date_fin_search_input").val().trim();
        if (date_debut && date_fin) {
            display_etablissement_factures(num_facture, num_secu, num_patient, nom_prenom, date_debut, date_fin);
        }
        return false;
    });

    $("#remise_input").change(function () {
        let remise = $(this).val().trim(),
            montant_brut = $("#montant_brut_input").val().trim(),
            montant_remise = (montant_brut * remise / 100),
            montant_net = (montant_brut - montant_remise);
        $("#montant_net_input").val(montant_net.toLocaleString('fr'));
        $("#montant_recu_input").val('');
        $("#monnaie_rendue_input").val('');
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

    $("#mode_paiement_input").change(function () {
        let mode_paiement = $("#mode_paiement_input").val().trim();
        if (mode_paiement === 'ESP') {
            $("#div_paiement_especes").slideDown();
        } else {
            $("#div_paiement_especes").hide();
            $("#montant_recu_input").val('');
            $("#monnaie_rendue_input").val('');
        }
    });
    $("#form_facture_medicale_paiement").submit(function () {
        let num_facture     = $("#num_facture_input").val().trim(),
            montant_brut    = $("#montant_brut_input").val().trim(),
            remise          = $("#remise_input").val().trim(),
            montant_net     = parseInt($("#montant_net_input").val().trim().replace(/\s+/g, '')),
            mode_paiement   = $("#mode_paiement_input").val().trim(),
            montant_recu    = parseInt($("#montant_recu_input").val().trim().replace(/\s+/g, '')),
            monnaie         = parseInt($("#monnaie_rendue_input").val().trim().replace(/\s+/g, ''));
        if (num_facture && montant_recu >= montant_net) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Factures/submit_paiement_facture.php',
                type: 'POST',
                data: {
                    'num_facture': num_facture,
                    'montant_brut': montant_brut,
                    'remise': remise,
                    'montant_net': montant_net,
                    'mode_paiement': mode_paiement,
                    'montant_recu': montant_recu,
                    'monnaie': monnaie
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_facture_medicale_paiement").hide();
                        $("#p_facture_medicale_paiement_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
                            window.open('imprimer-recu-paiement?num='+data['num_paiement'], '/', params);
                            window.location.reload(true);
                        }, 3000);
                    } else {
                        $("#p_facture_medicale_paiement_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!montant_recu) {
                $("#montant_recu_input").addClass('is-invalid');
                $("#montantRecuHelp")
                    .addClass('text-danger')
                    .html("Montant reçu.");
            }
        }
        return false;
    });

    $("#num_dossier_f_input").change(function () {
        let num_dossier = $(this).val().trim();
        if (num_dossier) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Factures/search_factures_initiales.php',
                type: 'POST',
                data: {
                    'code_dossier': num_dossier
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#num_facture_initiale_f_input")
                            .empty()
                            .append('<option value="">Sélectionnez</option>');
                        let factures = data['factures'];
                        $.each(factures, function (index, facture) {
                            $("#num_facture_initiale_f_input").append('<option value="'+ facture['num_facture'] +'">'+ facture['type_facture'] +' - '+ facture['num_facture'] +'</option>');
                        });
                    }
                }
            });
        } else {
            $("#type_facture_f_input").val('');
            $("#num_facture_initiale_f_input")
                .empty()
                .append('<option value="">Sélectionnez</option>');
            $("#code_assurance_input").val('');
            $("#num_assurance_input").val('');
            $("#num_bon_input").val('');
            $("#taux_assurance_input").val(0);
        }
    });

    $("#num_facture_initiale_f_input").change(function () {
        let num_facture_initiale = $(this).val().trim();
        if (num_facture_initiale) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/Factures/search_facture_initiale.php',
                type: 'POST',
                data: {
                    'num_facture_initiale': num_facture_initiale
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');

                    $("#code_assurance_input").val(data['code_organisme']);
                    $("#num_assurance_input").val(data['num_assurance']);
                    $("#num_bon_input").val('');
                    $("#taux_assurance_input").val(data['taux_organisme']);


                    if (data['code_organisme'] === 'ORG00001') {
                        $("#num_assurance_input")
                            .empty()
                            .prop('disabled', true)
                            .prop('required', false);
                        $("#num_bon_input")
                            .empty()
                            .prop('disabled', true)
                            .prop('required', false);
                        $("#taux_assurance_input")
                            .val(0)
                            .prop('disabled', true)
                            .prop('required', false);
                    } else {
                        $("#num_assurance_input")
                            .prop('disabled', false)
                            .prop('required', true);
                        $("#num_bon_input")
                            .prop('disabled', false)
                            .prop('required', true);
                        $("#taux_assurance_input")
                            .prop('disabled', false)
                            .prop('required', true);
                    }
                }
            });
        } else {
            $("#code_assurance_input").val('');
            $("#num_assurance_input").val('');
            $("#num_bon_input").val('');
            $("#taux_assurance_input").val(0);
        }
    });
    $("#type_facture_f_input").change(function () {
        let type_facture = $(this).val().trim();
        console.log(type_facture);
        if (type_facture === 'AMB' || type_facture === 'DEN') {
            $("#num_facture_initiale_f_input").val('').prop('readonly', true);
        } else {
            $("#num_facture_initiale_f_input").prop('readonly', false).focus();
        }
    });

    $("#libelle_acte_input")
        .autocomplete({
            source: function (request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_facture_actes.php", {
                    libelle: $('#libelle_acte_input').val(),
                    date_soins: $("#date_soins_input").val(),
                    type_facture: $("#type_facture_f_input").val(),
                    code_ets: $("#code_ets_acte_input").val()
                    }, response);
            },
        minLength: 2,
        select: function (e, ui) {
            $("#code_acte_input").val(ui.item.value);
            $("#libelle_acte_input").val(ui.item.label);
            $("#prix_unitaire_acte_input").val(ui.item.tarif);

            let prix_unitaire   = ui.item.tarif,
                quantite        = $("#quantite_acte_input").val(),
                montant_depense = (prix_unitaire * quantite);
            $("#montant_depense_acte_input").val(montant_depense);
            return false;
        }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_acte_input").val('');
            $("#prix_unitaire_acte_input").val(0);
            $("#quantite_acte_input").val(1);
            $("#montant_depense_acte_input").val(0);
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let code = $("#code_acte_input").val();
            if (!code) {
                $("#libelle_acte_input").val('');
                $("#prix_unitaire_acte_input").val(0);
                $("#quantite_acte_input").val(1);
                $("#montant_depense_acte_input").val(0);
            }
        });



    $("#button_ajouter_acte").click(function () {
        let code_acte       = [],
            montant_patient = parseInt($("#th_montant_patient").html()),
            libelle         = $("#libelle_acte_input").val().trim(),
            code            = $("#code_acte_input").val().trim(),
            prix_unitaire   = $("#prix_unitaire_acte_input").val().trim(),
            quantite        = $("#quantite_acte_input").val().trim(),
            montant_depense = $("#montant_depense_acte_input").val().trim();
        if (libelle && code && prix_unitaire && quantite && montant_depense) {
            $("#table_facture_actes").slideDown();
            $('.code_acte_td').each(function () {
                code_acte.push($(".code_acte_td").html());});
            if (jQuery.inArray(code, code_acte) === -1) {
                $("#p_erreur_actes").removeClass('alert alert-danger align_center').html('');
                $("#tbody_actes").append('<tr id="tr_'+code+'">' +
                    '<td></td>' +
                    '<td class="code_acte_td">'+code+'</td>' +
                    '<td>'+libelle+'</td>' +
                    '<td class="align_right prix_unitaire_td" id="prix_unitaire_td'+code+'">'+prix_unitaire+'</td>' +
                    '<td class="align_right quantite_td" id="quantite_td'+code+'">'+quantite+'</td>' +
                    '<td class="align_right montant_depense_td" id="montant_depense_td'+code+'">'+montant_depense+'</td>' +
                    '<td><button type="button" class="badge bg-danger button_retirer_acte" id="'+code+'"><i class="bi bi-x-lg"></i></button></td>' +
                    '</tr>');
                montant_patient += parseInt(montant_depense);
                $("#th_montant_patient").html(montant_patient);

                $("#libelle_acte_input").val('');
                $("#code_acte_input").val('');
                $("#prix_unitaire_acte_input").val('');
                $("#quantite_acte_input").val(1);
                $("#montant_depense_acte_input").val('');
            } else {
                $("#p_erreur_actes").addClass('alert alert-danger align_center').html('Cet acte a déjà été saisi.');
            }
        }
    });
    $(document).on('click', '.button_retirer_acte', function () {
        let code            = this.id,
            montant_patient = parseInt($("#th_montant_patient").html()),
            montant_depense = parseInt($("#montant_depense_td"+code).html());
        if (code) {
            montant_patient -= montant_depense;
            $("#th_montant_patient").html(montant_patient);
            $("#tbody_actes").find("#tr_"+code).remove();
        }
    });
    $("#quantite_acte_input").change(function () {
        let prix_unitaire   = $("#prix_unitaire_acte_input").val(),
            quantite        = $(this).val(),
            montant_depense = (prix_unitaire * quantite);
        $("#montant_depense_acte_input").val(montant_depense);
    });

    $("#code_assurance_input").change(function () {
        let code_assurance = $(this).val();
        if (code_assurance === 'ORG00001') {
            $("#num_assurance_input")
                .empty()
                .prop('disabled', true)
                .prop('required', false);
            $("#num_bon_input")
                .empty()
                .prop('disabled', true)
                .prop('required', false);
            $("#taux_assurance_input")
                .val(0)
                .prop('disabled', true)
                .prop('required', false);
        } else {
            $("#num_assurance_input")
                .prop('disabled', false)
                .prop('required', true);
            $("#num_bon_input")
                .prop('disabled', false)
                .prop('required', true);
            $("#taux_assurance_input")
                .prop('disabled', false)
                .prop('required', true);
        }
    });

    $("#form_etablissement_facture").submit(function () {
        let num_dossier             = $("#num_dossier_f_input").val().trim(),
            type_facture            = $("#type_facture_f_input").val().trim(),
            num_facture_initiale    = $("#num_facture_initiale_f_input").val().trim(),
            num_facture             = $("#num_facture_input").val().trim(),
            code_assurance          = $("#code_assurance_input").val().trim(),
            num_assurance           = $("#num_assurance_input").val().trim(),
            num_bon                 = $("#num_bon_input").val().trim(),
            taux_assurance          = $("#taux_assurance_input").val().trim(),
            date_soins              = $("#date_soins_input").val().trim(),
            code_acte               = $.map($(".code_acte_td"),function (select) {
                return $(select).html();}),
            prix_unitaire           = $.map($(".prix_unitaire_td"),function (select) {
                return $(select).html();}),
            quantite                = $.map($(".quantite_td"),function (select) {
                return $(select).html();});

        if (num_dossier && type_facture && code_assurance && taux_assurance && date_soins && code_acte  && quantite) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Factures/submit_edition_facture.php',
                type: 'POST',
                data: {
                    'num_dossier': num_dossier,
                    'code_assurance': code_assurance,
                    'num_assurance': num_assurance,
                    'num_bon': num_bon,
                    'taux_assurance': taux_assurance,
                    'date_soins': date_soins,
                    'num_facture': num_facture,
                    'type_facture': type_facture,
                    'num_facture_initiale': num_facture_initiale,
                    'code_acte': code_acte,
                    'prix_unitaire': prix_unitaire,
                    'quantite': quantite
                },
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_facture").hide();
                        $("#p_etablissement_facture_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
                            window.open('imprimer-facture-medicale?num='+data['num_facture'], '/', params);
                            window.location.href="../dossiers/?num="+num_dossier;
                        }, 3000);
                    } else {
                        $("#p_etablissement_facture_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!num_dossier) {
                $("#num_dossier_f_input").addClass('is-invalid');
                $("#numDossierFHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le dossier du patient.");
            }
            if (!type_facture) {
                $("#type_facture_f_input").addClass('is-invalid');
                $("#typeFactureFHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de facture à éditer.");
            }
            if (!code_assurance) {
                $("#code_assurance_input").addClass('is-invalid');
                $("#codeAssuranceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner l'assurance du patient.");
            }
            if (!taux_assurance) {
                $("#taux_assurance_input").addClass('is-invalid');
                $("#tauxAssuranceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le taux de couverture de l'assurance.");
            }
            if (!date_soins) {
                $("#taux_assurance_input").addClass('is-invalid');
                $("#tauxAssuranceHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date de la facture.");
            }
            if (!code_acte || quantite) {
                $("#table_facture_actes").hide();
                $("#p_erreur_actes").addClass('alert alert-danger').html("Veuillez renseigner au moins un acte.");
            }
        }
        return false;
    });

    $("#button_impression_facture").click(function () {
        let num_facture = $("#num_facture_b").html();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-facture-medicale?num='+num_facture, '/', params);
    });
    $("#button_impression_recu").click(function () {
        let num_facture = $("#num_facture_b").html();
        let params = `directories=no,titlebar=no,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=400,left=100,top=100`;
        window.open('imprimer-recu-paiement?num='+num_facture, '/', params);
    });
});
$(".date").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    maxDate: 0,
    lang: 'fr'
});
$("#table_factures").DataTable();
