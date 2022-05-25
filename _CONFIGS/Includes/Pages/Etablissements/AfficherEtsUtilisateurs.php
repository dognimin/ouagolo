<?php
if (isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Classes/PROFILSUTILISATEURS.php";
    require_once "../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../Classes/CIVILITES.php";
    require_once "../../../Classes/SEXES.php";
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $user = $UTILISATEURS->trouver($session['id_user'],null);
        if($user) {
            $SEXES = new SEXES();
            $CIVILITES = new CIVILITES();
            $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
            $ETABLISSEMENTS = new ETABLISSEMENTS();
            $sexes = $SEXES->lister();
            $civilites = $CIVILITES->lister();
            $profils = $PROFILSUTILISATEURS->lister();
            $etablissements = $ETABLISSEMENTS->lister(null, null);
            $ets = $ETABLISSEMENTS->trouver($code_ets,null);
            if ($ets) {
                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                ?>
                <div id="div_ets_utilisateurs">
                    <p class="align_right">
                        <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
                    </p>
                    <?php
                    $utilisateurs = $ETABLISSEMENTS->lister_utilisateurs($ets['code']);
                    $nb_utilisateurs = count($utilisateurs);
                    if ($nb_utilisateurs == 0) {
                        ?>
                        <p class="align_center alert alert-warning">Aucun utilisateur n'a encore été enregistré pour ce centre. <br/>Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour en ajouter un</p>
                        <?php
                    }else {
                        ?>
                        <div class="row">
                            <table class="table table-bordered table-hover table-sm table-striped" id="table_utilisateurs">
                                <thead class="bg-secondary">
                                <tr>
                                    <th style="width: 5px">N°</th>
                                    <th style="width: 80px">N° SECU</th>
                                    <th>NOM & PRENOM(S)</th>
                                    <th>EMAIL</th>
                                    <th style="width: 5px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ligne = 1;
                                foreach ($utilisateurs as $utilisateur) {
                                    ?>
                                    <tr>
                                        <td class="align_right"><?= $ligne; ?></td>
                                        <td><?= $utilisateur['num_secu']; ?></td>
                                        <td><?= $utilisateur['nom'] . ' ' . $utilisateur['prenoms']; ?></td>
                                        <td><strong><a href="mailto:<?= $utilisateur['email']; ?>"><?= $utilisateur['email']; ?></a></strong></td>
                                        <td><a href="<?= URL . 'etablissements/utilisateurs/?uid=' . $utilisateur['id_user']; ?>"
                                               class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                                    </tr>
                                    <?php
                                    $ligne++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div id="div_ets_utilisateurs_form">
                    <div class="row justify-content-md-center">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body row">
                                    <h5 class="card-title"></h5>
                                    <div class="row justify-content-md-center">
                                        <?php include "../_Forms/form_utilisateur.php";?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

}
?>
<script>
    $(".btn_add").click(function () {
        $("#div_ets_utilisateurs").hide();
        $("#div_ets_utilisateurs_form").slideDown();
        $(".card-title").html('Nouvel utilisateur');
        return false;
    });
    $("#button_ets_retourner").click(function () {
        $("#div_ets_utilisateurs_form").hide();
        $("#div_ets_utilisateurs").slideDown();
        return false;
    });

    $("#form_utilisateur").submit(function () {
        let id_user             = $("#id_user_input").val().trim(),
            code_ets            = $("#code_etablissement_input").val().trim(),
            code_profil         = $("#code_profil_input").val().trim(),
            num_secu            = $("#num_secu_input").val().trim(),
            email               = $("#email_input").val().toLowerCase().trim(),
            civilite            = $("#civilites_input").val().trim(),
            nom                 = $("#nom_input").val().toUpperCase().trim(),
            nom_patronymique    = $("#nom_patronymique_input").val().toUpperCase().trim(),
            prenoms             = $("#prenoms_input").val().toUpperCase().trim(),
            date_naissance      = $("#date_naissance_input").val().trim(),
            sexe                = $("#sexes_input").val().trim();

        if (code_ets && code_profil && email && nom && prenoms && date_naissance) {
            $("#button_utilisateur").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'code_etablissement': code_ets,
                    'code_organisme': null,
                    'code_profil': code_profil,
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
                            display_ets_utilisateurs(1,code_ets);
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
    $("#table_utilisateurs").DataTable();
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
        })
        .datepicker({
            maxDate: "-228M -0D",
            changeMonth: true,
            changeYear: true
        });
</script>
