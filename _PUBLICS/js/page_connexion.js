jQuery(function () {
    /**
     * Connexion Utilisateur
     */
    $("#a_connexion").click(function () {
        $("#div_email").hide();
        $("#div_connexion").slideDown();
        return false;
    });
    $("#email_connexion_input").keyup(function () {
        let email = $(this).val().trim();
        if (isValidEmailAddress(email)) {
            $("#email_connexion_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#emailConexionHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#email_connexion_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#emailConexionHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une adesse email correcte s'il vous plait.");
        }
    });
    $("#mot_de_passe_input").keyup(function () {
        let mot_de_passe = $(this).val().trim();
        if (mot_de_passe.length >= 8) {
            $("#mot_de_passe_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#passwordHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#mot_de_passe_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#passwordHelp")
                .addClass('text-danger')
                .html("Le mot de passe doit contenir au moins 8 caractères.");
        }
    });
    $("#form_connexion").submit(function () {
        let email = $("#email_connexion_input").val().trim(),
            mot_de_passe = $("#mot_de_passe_input").val().trim();
        if (email && mot_de_passe) {
            $("#button_connexion").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Vérification...</i>');
            $.ajax({
                url: '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/Json/submit_utilisateur_connexion.php',
                type: 'POST',
                data: {
                    'email': email,
                    'mot_de_passe': mot_de_passe
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_connexion").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Connexion');
                    if (data['success'] === true) {
                        $("#form_connexion").hide();
                        $("#p_connexion_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 1000);
                    } else {
                        $("#p_connexion_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!email) {
                $("#email_connexion_input").addClass('is-invalid')
                    .focus();
                $("#emailConexionHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'adesse email s'il vous plait.");
            }
            if (!mot_de_passe) {
                $("#mot_de_passe_input").addClass('is-invalid')
                    .focus();
                $("#passwordHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le mot de passe s'il vous plait.");
            }
        }

        return false;
    });


    /**
     * Mot de passe oublié, envoi d'email de reinitialisation
     */
    $("#a_email").click(function () {
        $("#div_connexion").hide();
        $("#div_email").slideDown();
        return false;
    });
    $("#email_recovery_input").keyup(function () {
        let email = $(this).val().trim();
        if (isValidEmailAddress(email)) {
            $("#email_recovery_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#emailRecoveryHelp")
                .removeClass('text-danger')
                .html("");
        } else {
            $("#email_recovery_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#emailRecoveryHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une adesse email correcte s'il vous plait.");
        }
    });
    $("#form_email").submit(function () {
        let email = $("#email_recovery_input").val().trim();
        if (email) {
            $("#button_email").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Vérification...</i>');
            $.ajax({
                url: '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_email.php',
                type: 'POST',
                data: {
                    'email': email
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_email").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Envoyer');
                    if (data['success'] === true) {
                        $("#form_email").hide();
                        $("#p_email_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 5000);
                    } else {
                        $("#p_email_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!email) {
                $("#email_recovery_input").addClass('is-invalid')
                    .focus();
                $("#emailRecoveryHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner une adesse email s'il vous plait.");
            }
        }
        return false;
    });


    /**
     * Aucun utilisateur existant, création d'un nouvel utilisateur
     */
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
    $("#date_naissance_input")
        .change(function () {
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
        let id_user = $("#id_user_input").val().trim(),
            num_secu = $("#num_secu_input").val().trim(),
            email = $("#email_input").val().toLowerCase().trim(),
            civilite = $("#civilites_input").val().trim(),
            nom = $("#nom_input").val().toUpperCase().trim(),
            nom_patronymique = $("#nom_patronymique_input").val().toUpperCase().trim(),
            prenoms = $("#prenoms_input").val().toUpperCase().trim(),
            date_naissance = $("#date_naissance_input").val().trim(),
            sexe = $("#sexes_input").val().trim();

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
                    'code_profil': null,
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
        }

        return false;
    });

    /**
     * Mise à jour du mot de passe
     */
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