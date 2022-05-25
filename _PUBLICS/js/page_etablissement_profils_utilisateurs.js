jQuery(function () {

    $("#libelle_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if (libelle && libelle.length > 3) {
            $("#libelle_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libelleHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#libelle_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libelleHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé SVP.");
        }
    });

    $("#form_profil_utilisateur").submit(function () {
        let code    = $("#code_input").val().trim(),
            libelle = $("#libelle_input").val().trim();
        if (libelle) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Parametres/ProfilsUtilisateurs/submit_edition_profil.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_profil_utilisateur").hide();
                        $("#p_profil_utilisateur_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.href="../parametres/profils-utilisateurs?pid="+data['code']
                        },3000);
                    } else {
                        $("#p_profil_utilisateur_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
            }
        }
        return false;
    });

    $("#affichage_patients_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_patients").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_patients").prop('disabled', false);
        }
    });
    $("#affichage_fournisseurs_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_fournisseurs").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_fournisseurs").prop('disabled', false);
        }
    });
    $("#affichage_dashboards_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_dashboard").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_dashboard").prop('disabled', false);
        }
    });

    $("#affichage_dossiers_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_dossiers").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_dossiers").prop('disabled', false);
        }
    });
    $("#affichage_pharmacie_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_pharmacie").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_pharmacie").prop('disabled', false);
        }
    });
    $("#affichage_supports_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_support").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_support").prop('disabled', false);
        }
    });

    $("#affichage_factures_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_factures").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_factures").prop('disabled', false);
        }
    });
    $("#affichage_professionnels_sante_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_professionnels_sante").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_professionnels_sante").prop('disabled', false);
        }
    });
    $("#affichage_a_proposs_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_a_propos").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_a_propos").prop('disabled', false);
        }
    });
    $("#affichage_admissions_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_admissions").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_admissions").prop('disabled', false);
        }
    });

    $("#affichage_rendez_vouss_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_rendez_vous").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_rendez_vous").prop('disabled', false);
        }
    });
    $("#affichage_comptabilites_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_comptabilite").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_comptabilite").prop('disabled', false);
        }
    });
    $("#affichage_laboratoires_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_laboratoire").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_laboratoire").prop('disabled', false);
        }
    });
    $("#affichage_parametres_input").change(function () {
        if (!$(this).is(':checked')) {
            $(".habilitations_parametres").prop('checked', false).prop('disabled', true);
        } else {
            $(".habilitations_parametres").prop('disabled', false);
        }
    });



    //$("#form_etablissement_profil_utilisateur_habilitations :input").prop("disabled", true);

    $("#form_etablissement_profil_utilisateur_habilitations").submit(function () {
        let code_profil                                 = $("#code_profil_input").val().trim(),
            modules                                     = '',
            sous_modules                                = '',

            affichage_patients                          = '',
            affichage_fournisseurs                      = '',
            affichage_dashboards                        = '',
            affichage_supports                          = '',
            affichage_dossiers                          = '',
            affichage_pharmacie                         = '',
            affichage_factures                          = '',
            affichage_professionnels_sante              = '',
            affichage_a_proposs                         = '',
            affichage_admissions                        = '',
            affichage_comptabilites                     = '',
            affichage_rendez_vouss                      = '',
            affichage_laboratoires                      = '',
            affichage_parametres                        = '',

            affichage_patient                           = '',
            edition_patient                             = '',
            affichage_patient_antecedants               = '',
            edition_patient_antecedants                 = '',

            affichage_fournisseur                       = '',
            edition_fournisseur                         = '',

            affichage_dashboard                         = '',
            edition_dashboard                           = '',

            affichage_dossier                           = '',
            edition_dossier                             = '',
            affichage_dossier_constantes                = '',
            edition_dossier_constantes                  = '',
            affichage_dossier_medecin_traitant          = '',
            edition_dossier_medecin_traitant            = '',
            affichage_dossier_plaintes                  = '',
            edition_dossier_plaintes                    = '',
            affichage_dossier_diagnostic                = '',
            edition_dossier_diagnostic                  = '',
            affichage_dossier_pathologie                = '',
            edition_dossier_pathologie                  = '',
            affichage_dossier_examens                   = '',
            edition_dossier_examens                     = '',
            affichage_dossier_ordonnance                = '',
            edition_dossier_ordonnance                  = '',

            affichage_pharmacie_ventes                  = '',
            edition_pharmacie_ventes                    = '',
            affichage_pharmacie_produits                = '',
            edition_pharmacie_produits                  = '',
            affichage_pharmacie_commandes               = '',
            edition_pharmacie_commandes                 = '',
            affichage_pharmacie_stock                   = '',
            edition_pharmacie_stock                     = '',

            affichage_support                           = '',
            edition_support                             = '',

            affichage_facture                           = '',
            edition_facture                             = '',

            affichage_factures_bordereaux               = '',
            edition_factures_bordereaux                 = '',

            affichage_professionnel_sante               = '',
            edition_professionnel_sante                 = '',

            affichage_a_propos                          = '',
            edition_a_propos                            = '',

            affichage_admission_patients                = '',
            edition_admission_patients                  = '',

            affichage_rendez_vous                       = '',
            edition_rendez_vous                         = '',

            affichage_comptabilite                      = '',
            edition_comptabilite                        = '',

            affichage_examens                           = '',
            edition_examens                             = '',

            affichage_parametres_panier_soins           = '',
            edition_parametres_panier_soins             = '',
            affichage_parametres_profils_utilisateurs   = '',
            edition_parametres_profils_utilisateurs     = '',
            affichage_parametres_utilisateurs           = '',
            edition_parametres_utilisateurs             = '',
            affichage_parametres_chambres               = '',
            edition_parametres_chambres                 = '';
        if ($('#affichage_patients_input').is(':checked')) {
            affichage_patients = $("#affichage_patients_input").val();
        }
        if ($('#affichage_fournisseurs_input').is(':checked')) {
            affichage_fournisseurs = $("#affichage_fournisseurs_input").val();
        }
        if ($('#affichage_dashboards_input').is(':checked')) {
            affichage_dashboards = $("#affichage_dashboards_input").val();
        }
        if ($('#affichage_dossiers_input').is(':checked')) {
            affichage_dossiers = $("#affichage_dossiers_input").val();
        }
        if ($('#affichage_pharmacie_input').is(':checked')) {
            affichage_pharmacie = $("#affichage_pharmacie_input").val();
        }
        if ($('#affichage_supports_input').is(':checked')) {
            affichage_supports = $("#affichage_supports_input").val();
        }
        if ($('#affichage_factures_input').is(':checked')) {
            affichage_factures = $("#affichage_factures_input").val();
        }
        if ($('#affichage_professionnels_sante_input').is(':checked')) {
            affichage_professionnels_sante = $("#affichage_professionnels_sante_input").val();
        }
        if ($('#affichage_a_proposs_input').is(':checked')) {
            affichage_a_proposs = $("#affichage_a_proposs_input").val();
        }
        if ($('#affichage_admissions_input').is(':checked')) {
            affichage_admissions = $("#affichage_admissions_input").val();
        }
        if ($('#affichage_rendez_vouss_input').is(':checked')) {
            affichage_rendez_vouss = $("#affichage_rendez_vouss_input").val();
        }
        if ($('#affichage_comptabilites_input').is(':checked')) {
            affichage_comptabilites = $("#affichage_comptabilites_input").val();
        }
        if ($('#affichage_laboratoires_input').is(':checked')) {
            affichage_laboratoires = $("#affichage_laboratoires_input").val();
        }
        if ($('#affichage_parametres_input').is(':checked')) {
            affichage_parametres = $("#affichage_parametres_input").val();
        }

        if ($('#affichage_patient_input').is(':checked')) {
            affichage_patient = $("#affichage_patient_input").val();
        }
        if ($('#edition_patient_input').is(':checked')) {
            edition_patient = $("#edition_patient_input").val();
        }
        if ($('#affichage_patient_antecedants_input').is(':checked')) {
            affichage_patient_antecedants = $("#affichage_patient_antecedants_input").val();
        }
        if ($('#edition_patient_antecedants_input').is(':checked')) {
            edition_patient_antecedants = $("#edition_patient_antecedants_input").val();
        }

        if ($('#affichage_fournisseur_input').is(':checked')) {
            affichage_fournisseur = $("#affichage_fournisseur_input").val();
        }
        if ($('#edition_fournisseur_input').is(':checked')) {
            edition_fournisseur = $("#edition_fournisseur_input").val();
        }

        if ($('#affichage_dashboard_input').is(':checked')) {
            affichage_dashboard = $("#affichage_dashboard_input").val();
        }
        if ($('#edition_dashboard_input').is(':checked')) {
            edition_dashboard = $("#edition_dashboard_input").val();
        }

        if ($('#affichage_dossier_input').is(':checked')) {
            affichage_dossier = $("#affichage_dossier_input").val();
        }
        if ($('#edition_dossier_input').is(':checked')) {
            edition_dossier = $("#edition_dossier_input").val();
        }
        if ($('#affichage_dossier_constantes_input').is(':checked')) {
            affichage_dossier_constantes = $("#affichage_dossier_constantes_input").val();
        }
        if ($('#edition_dossier_constantes_input').is(':checked')) {
            edition_dossier_constantes = $("#edition_dossier_constantes_input").val();
        }
        if ($('#affichage_dossier_medecin_traitant_input').is(':checked')) {
            affichage_dossier_medecin_traitant = $("#affichage_dossier_medecin_traitant_input").val();
        }
        if ($('#edition_dossier_medecin_traitant_input').is(':checked')) {
            edition_dossier_medecin_traitant = $("#edition_dossier_medecin_traitant_input").val();
        }
        if ($('#affichage_dossier_plaintes_input').is(':checked')) {
            affichage_dossier_plaintes = $("#affichage_dossier_plaintes_input").val();
        }
        if ($('#edition_dossier_plaintes_input').is(':checked')) {
            edition_dossier_plaintes = $("#edition_dossier_plaintes_input").val();
        }
        if ($('#affichage_dossier_diagnostic_input').is(':checked')) {
            affichage_dossier_diagnostic = $("#affichage_dossier_diagnostic_input").val();
        }
        if ($('#edition_dossier_diagnostic_input').is(':checked')) {
            edition_dossier_diagnostic = $("#edition_dossier_diagnostic_input").val();
        }
        if ($('#affichage_dossier_pathologie_input').is(':checked')) {
            affichage_dossier_pathologie = $("#affichage_dossier_pathologie_input").val();
        }
        if ($('#edition_dossier_pathologie_input').is(':checked')) {
            edition_dossier_pathologie = $("#edition_dossier_pathologie_input").val();
        }
        if ($('#affichage_dossier_examens_input').is(':checked')) {
            affichage_dossier_examens = $("#affichage_dossier_examens_input").val();
        }
        if ($('#edition_dossier_examens_input').is(':checked')) {
            edition_dossier_examens = $("#edition_dossier_examens_input").val();
        }
        if ($('#affichage_dossier_ordonnance_input').is(':checked')) {
            affichage_dossier_ordonnance = $("#affichage_dossier_ordonnance_input").val();
        }
        if ($('#edition_dossier_ordonnance_input').is(':checked')) {
            edition_dossier_ordonnance = $("#edition_dossier_ordonnance_input").val();
        }

        if ($('#affichage_pharmacie_ventes_input').is(':checked')) {
            affichage_pharmacie_ventes = $("#affichage_pharmacie_ventes_input").val();
        }
        if ($('#edition_pharmacie_ventes_input').is(':checked')) {
            edition_pharmacie_ventes = $("#edition_pharmacie_ventes_input").val();
        }
        if ($('#affichage_pharmacie_produits_input').is(':checked')) {
            affichage_pharmacie_produits = $("#affichage_pharmacie_produits_input").val();
        }
        if ($('#edition_pharmacie_produits_input').is(':checked')) {
            edition_pharmacie_produits = $("#edition_pharmacie_produits_input").val();
        }
        if ($('#affichage_pharmacie_commandes_input').is(':checked')) {
            affichage_pharmacie_commandes = $("#affichage_pharmacie_commandes_input").val();
        }
        if ($('#edition_pharmacie_commandes_input').is(':checked')) {
            edition_pharmacie_commandes = $("#edition_pharmacie_commandes_input").val();
        }
        if ($('#affichage_pharmacie_stock_input').is(':checked')) {
            affichage_pharmacie_stock = $("#affichage_pharmacie_stock_input").val();
        }
        if ($('#edition_pharmacie_stock_input').is(':checked')) {
            edition_pharmacie_stock = $("#edition_pharmacie_stock_input").val();
        }

        if ($('#affichage_support_input').is(':checked')) {
            affichage_support = $("#affichage_support_input").val();
        }
        if ($('#edition_support_input').is(':checked')) {
            edition_support = $("#edition_support_input").val();
        }

        if ($('#affichage_facture_input').is(':checked')) {
            affichage_facture = $("#affichage_facture_input").val();
        }
        if ($('#edition_facture_input').is(':checked')) {
            edition_facture = $("#edition_facture_input").val();
        }

        if ($('#affichage_factures_bordereaux_input').is(':checked')) {
            affichage_factures_bordereaux = $("#affichage_factures_bordereaux_input").val();
        }
        if ($('#edition_factures_bordereaux_input').is(':checked')) {
            edition_factures_bordereaux = $("#edition_factures_bordereaux_input").val();
        }

        if ($('#affichage_professionnel_sante_input').is(':checked')) {
            affichage_professionnel_sante = $("#affichage_professionnel_sante_input").val();
        }
        if ($('#edition_professionnel_sante_input').is(':checked')) {
            edition_professionnel_sante = $("#edition_professionnel_sante_input").val();
        }

        if ($('#affichage_a_propos_input').is(':checked')) {
            affichage_a_propos = $("#affichage_a_propos_input").val();
        }
        if ($('#edition_a_propos_input').is(':checked')) {
            edition_a_propos = $("#edition_a_propos_input").val();
        }

        if ($('#affichage_admission_patients_input').is(':checked')) {
            affichage_admission_patients = $("#affichage_admission_patients_input").val();
        }
        if ($('#edition_admission_patients_input').is(':checked')) {
            edition_admission_patients = $("#edition_admission_patients_input").val();
        }

        if ($('#affichage_rendez_vous_input').is(':checked')) {
            affichage_rendez_vous = $("#affichage_rendez_vous_input").val();
        }
        if ($('#edition_rendez_vous_input').is(':checked')) {
            edition_rendez_vous = $("#edition_rendez_vous_input").val();
        }

        if ($('#affichage_comptabilite_input').is(':checked')) {
            affichage_comptabilite = $("#affichage_comptabilite_input").val();
        }
        if ($('#edition_comptabilite_input').is(':checked')) {
            edition_comptabilite = $("#edition_comptabilite_input").val();
        }
        if ($('#affichage_examens_input').is(':checked')) {
            affichage_examens = $("#affichage_examens_input").val();
        }
        if ($('#edition_examens_input').is(':checked')) {
            edition_examens = $("#edition_examens_input").val();
        }

        if ($('#affichage_parametres_panier_soins_input').is(':checked')) {
            affichage_parametres_panier_soins = $("#affichage_parametres_panier_soins_input").val();
        }
        if ($('#edition_parametres_panier_soins_input').is(':checked')) {
            edition_parametres_panier_soins = $("#edition_parametres_panier_soins_input").val();
        }
        if ($('#affichage_parametres_profils_utilisateurs_input').is(':checked')) {
            affichage_parametres_profils_utilisateurs = $("#affichage_parametres_profils_utilisateurs_input").val();
        }
        if ($('#edition_parametres_profils_utilisateurs_input').is(':checked')) {
            edition_parametres_profils_utilisateurs = $("#edition_parametres_profils_utilisateurs_input").val();
        }
        if ($('#affichage_parametres_utilisateurs_input').is(':checked')) {
            affichage_parametres_utilisateurs = $("#affichage_parametres_utilisateurs_input").val();
        }
        if ($('#edition_parametres_utilisateurs_input').is(':checked')) {
            edition_parametres_utilisateurs = $("#edition_parametres_utilisateurs_input").val();
        }
        if ($('#affichage_parametres_chambres_input').is(':checked')) {
            affichage_parametres_chambres = $("#affichage_parametres_chambres_input").val();
        }
        if ($('#edition_parametres_chambres_input').is(':checked')) {
            edition_parametres_chambres = $("#edition_parametres_chambres_input").val();
        }

        modules = affichage_patients+affichage_fournisseurs+affichage_dashboards+affichage_supports+affichage_dossiers+affichage_pharmacie+affichage_factures+affichage_professionnels_sante+affichage_a_proposs+affichage_admissions+affichage_rendez_vouss+affichage_comptabilites+affichage_laboratoires+affichage_parametres;
        sous_modules = affichage_patient+edition_patient+affichage_patient_antecedants+edition_patient_antecedants
                        +affichage_fournisseur+edition_fournisseur
                        +affichage_dashboard+edition_dashboard
                        +affichage_dossier+edition_dossier+affichage_dossier_constantes+edition_dossier_constantes+affichage_dossier_medecin_traitant+edition_dossier_medecin_traitant+affichage_dossier_plaintes+edition_dossier_plaintes+affichage_dossier_diagnostic+edition_dossier_diagnostic+affichage_dossier_pathologie+edition_dossier_pathologie+affichage_dossier_examens+edition_dossier_examens+affichage_dossier_ordonnance+edition_dossier_ordonnance
                        +affichage_pharmacie_ventes+edition_pharmacie_ventes+affichage_pharmacie_produits+edition_pharmacie_produits+affichage_pharmacie_commandes+edition_pharmacie_commandes+affichage_pharmacie_stock+edition_pharmacie_stock
                        +affichage_support+edition_support
                        +affichage_facture+edition_facture+affichage_factures_bordereaux+edition_factures_bordereaux
                        +affichage_professionnel_sante+edition_professionnel_sante
                        +affichage_a_propos+edition_a_propos
                        +affichage_admission_patients+edition_admission_patients
                        +affichage_rendez_vous+edition_rendez_vous
                        +affichage_comptabilite+edition_comptabilite
                        +affichage_examens+edition_examens
                        +affichage_parametres_panier_soins+edition_parametres_panier_soins+affichage_parametres_profils_utilisateurs+edition_parametres_profils_utilisateurs+affichage_parametres_utilisateurs+edition_parametres_utilisateurs+affichage_parametres_chambres+edition_parametres_chambres;
        if (code_profil) {
            $("#button_habilitations_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_region_naissance_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/Parametres/ProfilsUtilisateurs/submit_edition_habilitations.php',
                type: 'POST',
                data: {
                    'code_profil': code_profil,
                    'modules': modules,
                    'sous_modules': sous_modules
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_habilitations_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#form_etablissement_profil_utilisateur_habilitations").hide();
                    $("#p_etablissement_profil_utilisateur_habilitations_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
            });
        }
        return false;
    });
});
$("#table_profils").dataTable();
$('.modal').modal({
    show: false,
    backdrop: 'static'
});
