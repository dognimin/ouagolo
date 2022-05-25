jQuery(function () {

    $("#email_input").keyup(function () {
        let email = $(this).val().trim();
        if (isValidEmailAddress(email)) {
            $("#email_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#emailHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#email_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#emailHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une adesse email correcte s'il vous plait.");
        }
    });
    $("#nom_input").keyup(function () {
        let nom = $(this).val().trim();
        if (nom) {
            $("#nom_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#nomHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#nom_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#nomHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un nom de famille s'il vous plait.");
        }
    });
    $("#civilites_input").keyup(function () {
        let code_civilite = $(this).val().trim();
        if (code_civilite) {
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
        let code_sexe = $(this).val().trim();
        if (code_sexe) {
            $("#sexes_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#sexesHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#sexes_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#sexesHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un sexe SVP.");
        }
    });
    $("#prenoms_input").keyup(function () {
        let prenoms = $(this).val().trim();
        if (prenoms) {
            $("#prenoms_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#prenomsHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#prenoms_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#prenomsHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le(s) prénom(s) s'il vous plait.");
        }
    });
    $("#date_naissance_input").change(function () {
        let date_naissance = $(this).val().trim();
        if (date_naissance) {
            $("#date_naissance_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#dateNaissanceHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#date_naissance_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#dateNaissanceHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une date de naissance s'il vous plait.");
        }
    });

    $("#form_utilisateur").submit(function () {
        let id_user             = $("#id_user_input").val().trim(),
            num_secu            = $("#num_secu_input").val().trim(),
            email               = $("#email_input").val().toLowerCase().trim(),
            civilite            = $("#civilites_input").val().trim(),
            nom                 = $("#nom_input").val().toUpperCase().trim(),
            prenoms             = $("#prenoms_input").val().toUpperCase().trim(),
            nom_patronymique    = $("#nom_patronymique_input").val().toUpperCase().trim(),
            date_naissance      = $("#date_naissance_input").val().trim(),
            sexe                = $("#sexes_input").val().trim();

        if (email && nom && prenoms && date_naissance) {
            $("#button_utilisateur").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'code_etablissement': null,
                    'code_organisme': null,
                    'code_profil': 'ADMN',
                    'num_secu': num_secu,
                    'email': email,
                    'civilite': civilite,
                    'nom': nom,
                    'nom_patronymique': nom_patronymique,
                    'prenoms': prenoms,
                    'date_naissance': date_naissance,
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
                        }, 5000);
                    } else {
                        $("#p_utilisateur_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!nom_utilisateur) {
                $("#nom_utilisateur_input").addClass('is-invalid');
                $("#nomUtilisateurHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom utilisateur s'il vous plait.");
            }
            if (!email) {
                $("#email_input").addClass('is-invalid');
                $("#emailHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'adesse email s'il vous plait.");
            }
            if (!nom) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom de famille s'il vous plait.");
            }
            if (!prenoms) {
                $("#prenoms_input").addClass('is-invalid');
                $("#prenomsHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le(s) prénom(s) s'il vous plait.");
            }
            if (!date_naissance) {
                $("#date_naissance_input").addClass('is-invalid');
                $("#dateNaissanceHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date de naissance s'il vous plait.");
            }
            if (!civilite) {
                $("#civilites_input").addClass('is-invalid');
                $("#civilitesHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner une civilite s'il vous plait.");
            }
            if (!sexe) {
                $("#sexes_input").addClass('is-invalid');
                $("#sexesHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner un sexe s'il vous plait.");
            }
        }

        return false;
    });

    function log_utilisateur(id_user) {
        if(id_user) {
            $("#div_logs").html(loading_gif(0));
            $.ajax({
                url: '_CONFIGS/Includes/Searches/Parametres/Utilisateurs/search_utilisateur_logs.php',
                type: 'POST',
                data: {
                    'id_user': id_user
                },
                success: function (data) {
                    $("#div_logs").html(data);
                }
            });
        }

    }

    $(".button_logs").click(function () {
        let id_user = this.id;
        log_utilisateur(id_user);
    });

    $("#form_utilisateur_photo").submit(function () {
        let form_data = new FormData(this);
        $("#button_enregistrer_photo").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Traitement...</i>');
        $.ajax({
            url: '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_photo.php',
            type: 'POST',
            data: form_data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $("#button_enregistrer_photo").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('Enregistrer');
                if (data['success'] === true) {
                    $("#form_utilisateur_photo").hide();
                    $("#p_utilisateur_photo_resultats").removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html(data['message']);
                    setTimeout(function () {
                        window.location.reload();
                    },5000);
                }else {
                    $("#p_utilisateur_photo_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
        return false;
    });

    $("#nouveau_mot_de_passe_input").keyup(function () {
        $("#confirmer_mot_de_passe_input").val('');
        let actuel_mot_de_passe = $("#actuel_mot_de_passe_input").val().trim(),
            mot_de_passe = $(this).val().trim();
        if (actuel_mot_de_passe === mot_de_passe) {
            $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
            $("#passwordNewHelp").addClass('text-danger')
                .html('<i class="fa fa-dot-circle"></i> Le mot de passe actuel et le nouveau mot de passe doivent être différents.');
        } else {
            passwordChecker(mot_de_passe);
        }
    });
    $("#confirmer_mot_de_passe_input").keyup(function () {
        let nouveau_mot_de_passe = $("#nouveau_mot_de_passe_input").val().trim(),
            confirmer_mot_de_passe = $(this).val().trim();
        if (nouveau_mot_de_passe !== confirmer_mot_de_passe) {
            $("#confirmer_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
            $("#passwordNewConfirmHelp").addClass('text-danger')
                .html('<i class="fa fa-dot-circle"></i> Les 2 nouveaux mots de passe doivent être identiques.');
        } else {
            $("#confirmer_mot_de_passe_input").removeClass('is-invalid').addClass('is-valid');
            $("#passwordNewConfirmHelp").addClass('text-danger')
                .html('');
        }
    });
    $("#form_mot_de_passe").submit(function () {
        let actuel_mot_de_passe = $("#actuel_mot_de_passe_input").val().trim(),
            nouveau_mot_de_passe = $("#nouveau_mot_de_passe_input").val().trim(),
            confirmer_mot_de_passe = $("#confirmer_mot_de_passe_input").val().trim();
        if (actuel_mot_de_passe && nouveau_mot_de_passe && confirmer_mot_de_passe) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Vérification...</i>');
            $.ajax({
                url: '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_mot_de_passe.php',
                type: 'POST',
                data: {
                    'actuel_mot_de_passe': actuel_mot_de_passe,
                    'nouveau_mot_de_passe': nouveau_mot_de_passe
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_mot_de_passe").hide();
                        $("#p_mot_de_passe_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 5000);
                    } else {
                        $("#p_mot_de_passe_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!actuel_mot_de_passe) {
                $("#actuel_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid')
                    .focus();
                $("#passwordHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le mot de passe actuel s'il vous plait.");
            }
            if (!nouveau_mot_de_passe) {
                $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid')
                    .focus();
                $("#passwordNewHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nouveau mot de passe s'il vous plait.");
            }
            if (!confirmer_mot_de_passe) {
                $("#confirmer_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid')
                    .focus();
                $("#passwordNewConfirmHelp")
                    .addClass('text-danger')
                    .html("Veuillez confirmer le nouveau mot de passe s'il vous plait.");
            }
        }
        return false;
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