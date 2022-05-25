jQuery(function () {
    $("#email_input").keyup(function () {
        $("#code_ps_input").val('');
    }).blur(function () {
        let email = $(this).val().trim().toLowerCase();
       if(email) {
           $("#button_utilisateur").prop('disabled', true)
               .removeClass('btn-primary')
               .addClass('btn-warning')
               .html('<i>Vérification...</i>');
           $.ajax({
               url: '../../_CONFIGS/Includes/Searches/Parametres/Utilisateurs/search_utilisateur.php',
               type: 'POST',
               data: {
                   'type': 'PS',
                   'email': email
               },
               dataType: 'json',
               success: function (data) {
                   $("#button_utilisateur").prop('disabled', false)
                       .removeClass('btn-warning')
                       .addClass('btn-primary')
                       .html('<i class="bi bi-save"></i> Enregistrer');
                   if(data['success'] === true) {
                       $("#code_ps_input").val(data['infos_ps']['code']);
                       $("#code_specialite_input").val(data['infos_ps']['code_specialite']);
                       $("#sexes_input").val(data['code_sexe']);
                       $("#civilites_input").val(data['code_civilite']);
                       $("#nom_input").val(data['nom']);
                       $("#nom_patronymique_input").val(data['nom_patronymique']);
                       $("#prenoms_input").val(data['prenoms']);
                       $("#date_naissance_input").val(data['date_naissance']);
                       $("#id_user_input").val(data['id_user']);
                   }
               }
           });
       }
    });
    $("#form_utilisateur").submit(function () {
        let id_user             = $("#id_user_input").val().trim(),
            code_etablissement  = $("#code_etablissement_input").val().trim(),
            code_profil         = $("#code_profil_input").val().trim(),
            code_specialite     = $("#code_specialite_input").val().trim(),
            code_ps_rgb         = $("#code_ps_rgb_input").val().trim(),
            code_ps             = $("#code_ps_input").val().trim(),
            num_secu            = $("#num_secu_input").val().trim(),
            email               = $("#email_input").val().toLowerCase().trim(),
            civilite            = $("#civilites_input").val().trim(),
            nom                 = $("#nom_input").val().toUpperCase().trim(),
            nom_patronymique    = $("#nom_patronymique_input").val().toUpperCase().trim(),
            prenoms             = $("#prenoms_input").val().toUpperCase().trim(),
            date_naissance      = $("#date_naissance_input").val().trim(),
            sexe                = $("#sexes_input").val().trim();

        if (code_etablissement && code_profil && code_specialite && email && nom && prenoms && date_naissance) {
            $("#button_utilisateur").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/ProfessionnelsDeSante/submit_professionnel_de_sante.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'code_etablissement': code_etablissement,
                    'code_profil': code_profil,
                    'code_specialite': code_specialite,
                    'code_ps_rgb': code_ps_rgb,
                    'code_ps': code_ps,
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
                        .html('<i class="bi bi-save"></i> Enregistrer');
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
        }
        else {
            if (!code_profil) {
                $("#code_profil_input").addClass('is-invalid');
                $("#codeProfilHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le profil de l'utilisateur s'il vous plait.");
            }
            if (!code_specialite) {
                $("#code_specialite_input").addClass('is-invalid');
                $("#codeSpecialiteHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la spécialité de l'utilisateur s'il vous plait.");
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
});
$("#table_professionnels_sante").DataTable();
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