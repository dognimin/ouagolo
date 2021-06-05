jQuery(function () {
    $("#form_search_utilisateurs").submit(function () {
        let nom_prenoms     = $('#nom_prenom_input').val().trim(),
            email       = $('#email_search_input').val().trim(),
            num_secu     = $('#num_secu_input').val().trim(),
            nom_utilisateur     = $('#nom_utilisateur_search_input').val().trim();

        if(nom_prenoms || email || num_secu || nom_utilisateur) {
            $("#div_resultats").html(loading_gif(2));
            $("#btn_search").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Utilisateurs/search_utilisateurs.php',
                type: 'post',
                data: {
                    'nom_prenoms': nom_prenoms,
                    'email': email,
                    'nom_utilisateur': nom_utilisateur,
                    'num_secu': num_secu
                },
                success: function(data) {
                    $("#btn_search").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .html('<i class="bi bi-search"></i>');
                    $("#div_resultats").html(data);
                }
            });
        }
        return false;
    });

    $(".btn_add").click(function () {
        $("#div_resultats").hide();
        $("#div_utilisateur").slideDown();
        $(".card-title").html('Nouvel Utilisateur');
        return false;
    });
    $(".btn_edit").click(function () {
        $("#div_resultats").hide();
        $("#div_detail").hide();
        $("#div_utilisateur").slideDown();

        $(".card-title").html('Edition Utilisateur');
        return false;

    });


    /**
     * Aucun utilisateur existant, création d'un nouvel utilisateur
     */
    $("#pays_input").change(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#region_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/search_localisation.php',
                type: 'post',
                data: {
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#region_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#region_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#pays_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#paysHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#pays_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#paysHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#departement_input").change(function () {
        let code_departement     = $(this).val().trim(),
            code_pays     = $("#pays_input").val().trim(),
            code_region     = $("#region_input").val().trim();
        if(code_departement) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#commune_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/search_localisation.php',
                type: 'post',
                data: {
                    'code_pays': code_pays,
                    'code_region': code_region,
                    'code_departement': code_departement
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#commune_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#commune_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#departement_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#departementHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#departement_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#departementHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });
    $("#region_input").change(function () {
        let code_region     = $(this).val().trim(),
            code_pays     = $("#pays_input").val().trim();

        if(code_region) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#departement_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/search_localisation.php',
                type: 'post',
                data: {
                    'code_region': code_region,
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#departement_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#departement_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#region_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#regionHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#region_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#regionHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une region SVP.");
        }
    });
    $("#nom_utilisateur_input").keyup(function () {
        let nom_utilisateur     = $(this).val().trim();
        if(nom_utilisateur) {
            $("#nom_utilisateur_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#nomUtilisateurHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#nom_utilisateur_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#nomUtilisateurHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un nom utilisateur s'il vous plait.");
        }
    });
    $("#email_input").keyup(function () {
        let email   = $(this).val().trim();
        if(isValidEmailAddress(email)) {
            $("#email_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#emailHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#email_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#emailHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une adesse email correcte s'il vous plait.");
        }
    });
    $("#nom_input").keyup(function () {
        let nom                  = $(this).val().trim();
        if(nom) {
            $("#nom_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#nomHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#nom_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#nomHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un nom de famille s'il vous plait.");
        }
    });
    $("#civilites_input").keyup(function () {
        let code_civilite     = $(this).val().trim();
        if(code_civilite) {
            $("#civilites_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#civilitesHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#civilites_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#civilitesHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une civilite SVP.");
        }
    });
    $("#sexes_input").keyup(function () {
        let code_sexe     = $(this).val().trim();
        if(code_sexe) {
            $("#sexes_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#sexesHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#sexes_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#sexesHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un sexe SVP.");
        }
    });
    $("#prenoms_input").keyup(function () {
        let prenoms             = $(this).val().trim();
        if(prenoms) {
            $("#prenoms_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#prenomsHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#prenoms_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#prenomsHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le(s) prénom(s) s'il vous plait.");
        }
    });
    $("#date_naissance_input").change(function () {
        let date_naissance      = $(this).val().trim();
        if(date_naissance) {
            $("#date_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#dateNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#date_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#dateNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une date de naissance s'il vous plait.");
        }
    }).datepicker({
        maxDate: "-228M -0D"
    });

    $("#form_utilisateur").submit(function () {
        let id_user             = $("#id_user_input").val().trim(),
            num_secu            = $("#num_secu_input").val().trim(),
            num_matricule       = $("#num_matricule_input").val().trim(),
            nom_utilisateur     = $("#nom_utilisateur_input").val().toLowerCase().trim(),
            email               = $("#email_input").val().toLowerCase().trim(),
            civilite            = $("#civilites_input").val().trim(),
            nom                 = $("#nom_input").val().toUpperCase().trim(),
            nom_patronymique    = $("#nom_patronymique_input").val().toUpperCase().trim(),
            prenoms             = $("#prenoms_input").val().toUpperCase().trim(),
            date_naissance      = $("#date_naissance_input").val().trim(),
            adresse_postale      = $("#adresse_postale_input").val().toLowerCase().trim(),
            adresse_geographique = $("#adresse_geo_input").val().toLowerCase().trim(),
            sexe                = $("#sexes_input").val().trim(),
            pays                 = $("#pays_input").val().toUpperCase().trim(),
            region               = $("#region_input").val().toUpperCase().trim(),
            departement          = $("#departement_input").val().toUpperCase().trim(),
            commune              = $("#commune_input").val().trim();

        if(nom_utilisateur && email && nom && prenoms && date_naissance) {
            $("#button_utilisateur").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'num_secu': num_secu,
                    'num_matricule': num_matricule,
                    'nom_utilisateur': nom_utilisateur,
                    'email': email,
                    'civilite': civilite,
                    'nom': nom,
                    'nom_patronymique': nom_patronymique,
                    'prenoms': prenoms,
                    'date_naissance': date_naissance,
                    'region': region,
                    'pays': pays,
                    'commune': commune,
                    'departement': departement,
                    'adresse_postale': adresse_postale,
                    'adresse_geographique': adresse_geographique,
                    'sexe': sexe
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_utilisateur").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_utilisateur").hide();
                        $("#p_utilisateur_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_utilisateur_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!nom_utilisateur) {
                $("#nom_utilisateur_input").addClass('is-invalid');
                $("#nomUtilisateurHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom utilisateur s'il vous plait.");
            }
            if(!email) {
                $("#email_input").addClass('is-invalid');
                $("#emailHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'adesse email s'il vous plait.");
            }
            if(!nom) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom de famille s'il vous plait.");
            }
            if(!prenoms) {
                $("#prenoms_input").addClass('is-invalid');
                $("#prenomsHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le(s) prénom(s) s'il vous plait.");
            }
            if(!date_naissance) {
                $("#date_naissance_input").addClass('is-invalid');
                $("#dateNaissanceHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date de naissance s'il vous plait.");
            }
            if(!civilite) {
                $("#civilites_input").addClass('is-invalid');
                $("#civilitesHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner une civilite s'il vous plait.");
            }
            if(!sexe) {
                $("#sexes_input").addClass('is-invalid');
                $("#sexesHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner un sexe s'il vous plait.");
            }
        }

        return false;
    });


    $("#profils_input").change(function () {
        let code_profil = $(this).val().trim();
        $("#code_etablissement").empty();
        if ( code_profil == 'CSAGNT' ||  code_profil == 'CSAGNT' || code_profil == 'CSRESP') {
                        $('#code_etablissement').append(
                        '<div class="col-sm" id="">' +
                        '<label for="code_etablissement_input" class="form-label">Code établissement</label>' +
                        '<input type="text" class="form-control form-control-sm" id="code_etablissement_input" maxlength="9" placeholder="Code" aria-describedby="codeEtabHelp" autocomplete="off">' +
                        '</div>' +
                        '<div>' +
                        '<div class="col-sm" id="">' +
                        '<label for="raison_sociale_etablissement_input" class="form-label">Raison sociale</label>' +
                        '<textarea type="text" class="form-control form-control-sm" id="raison_sociale_etablissement_input" placeholder="Raison sociale" aria-describedby="raisonSocialeEtabHelp" autocomplete="off"></textarea>' +
                        '</div>' +
                        '</div>');

            $("#code_etablissement_input").keyup(function () {
                let code_etablissement   = $(this).val().trim();
                if(code_etablissement.length === 9) {
                    $("#code_etablissement_input").removeClass('is-invalid')
                        .addClass('is-valid');
                    $("#codeEtabHelp")
                        .removeClass('text-danger')
                        .html("");
                    $.ajax({
                        url: '../../_CONFIGS/Includes/Searches/Parametres/Etablissements/search_etablissement.php',
                        type: 'post',
                        data: {
                            'code': code_etablissement,
                        },
                        dataType:'json',
                        success: function(data) {
                            $("#btn_search").prop('disabled', false)
                                .removeClass('btn-warning')
                                .addClass('btn-success')
                                .html('<i class="bi bi-search"></i>');
                            $("#raison_sociale_etablissement_input").prop('disabled',true).val(data['raison_sociale']);
                        }
                    });
                }else {
                    $("#raison_sociale_etablissement_input").prop('disabled',false).val('');
                }
            }).blur(function () {
                let code_etablissement   = $(this).val().trim();
            });
        }
        else{
            $('#code_etablissement').empty();
        }

        if(code_profil) {
            $("#profils_input")
                .removeClass('is-invalid')
                .addClass('is-valid');
            $("#profilsHelp")
                .removeClass('text-danger')
                .addClass('text-success')
                .html("");
        }
        else {
            $("#profils_input")
                .removeClass('is-valid')
                .addClass('is-invalid');
            $("#profilsHelp")
                .removeClass('text-success')
                .addClass('text-danger')
                .html("Veuillez sélectionner le profil s'il vous plait.");
        }

    });


    $("#form_utilisateur_profil").submit(function () {
        let code_profil = $("#profils_input").val().trim(),
            id_user = $("#id_user_input").val().trim(),
            code_etablissement = $("#code_etablissement_input").val().trim();
        if(code_profil && id_user) {
            $("#button_utilisateur_profil").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_profil.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'code_etablissement': code_etablissement,
                    'code_profil': code_profil
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_utilisateur_profil").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_utilisateur_profil").hide();
                        $("#p_utilisateur_profil_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },5000);
                    }else {
                        $("#p_utilisateur_profil_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            $("#profils_input").addClass('is-invalid');
            $("#profilsHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner le profil s'il vous plait.");
        }

        return false;
    });
    $("#form_utilisateur_reinitialiser_mot_de_passe").submit(function () {
        let id_user = $("#id_user_input").val().trim();
        if(id_user) {
            $("#button_reinitialiser").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_reinitialiser_mot_de_passe.php',
                type: 'POST',
                data: {
                    'id_user': id_user
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_reinitialiser").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('OUI');
                    if (data['success'] === true) {
                        $("#form_utilisateur_reinitialiser_mot_de_passe").hide();
                        $("#p_utilisateur_reinitialiser_mot_de_passe_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        },7000);
                    }else {
                        $("#p_utilisateur_reinitialiser_mot_de_passe_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        return false;
    });

    $("#statut_check_input").change(function () {
        let id_user = $("#id_user_input").val().trim();
        if(id_user) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_statut.php',
                type: 'POST',
                data: {
                    'id_user': id_user
                },
                dataType: 'json',
                success: function (data) {
                    if(data['success'] === true) {
                        $("#div_resultats_user").html('<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                            data['message']+
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                            '</div>');
                        setTimeout(function () {
                            display_parametres_utilisateur_details_page(id_user);
                        },3000);
                    }else {
                        $("#div_resultats_user").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                            data['message']+
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
                            '</div>');
                        setTimeout(function () {
                            display_parametres_utilisateur_details_page(id_user);
                        },3000);
                    }
                }
            });
        }
    });



});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});