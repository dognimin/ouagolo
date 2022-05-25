<?php
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'date' => clean_data(date('Y-m-d', strtotime($_POST['date'])))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT RENDEZ-VOUS', json_encode($parametres));
                            if ($audit['success'] == true) {
                                $professionnels = $ETABLISSEMENTS->lister_professionnels_de_sante($ets['code']);
                                $date_du_jour = date('Y-m-d', time());
                                if (strtotime($date_du_jour) <= strtotime($parametres['date'])) {
                                    ?>
                                    <p class="align_right"><button type="button" id="button_nouveau_rdv" class="btn btn-sm btn-primary"><i class="bi bi-calendar2-plus-fill"></i> Nouveau rendez-vous</button></p>
                                    <?php
                                }
                                ?>
                                <div id="div_nouveau_rdv"><?php include "../../../Pages/_Forms/form_rendez_vous.php";?></div>
                                <div id="div_liste_rdv">
                                    <?php
                                    $rdvs = $ETABLISSEMENTS->lister_rendez_vous($ets['code'], null, null, $parametres['date']);
                                    $nb_rdvs = count($rdvs);
                                    if ($nb_rdvs != 0) {
                                        $pss = $ETABLISSEMENTS->lister_nombre_rendez_vous_ps($ets['code'], $parametres['date']);
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm bg-white table-bordered table-hover table-stripped">
                                                <thead>
                                                <tr>
                                                    <th style="width: 200px">MEDECIN</th>
                                                    <?php
                                                    $heure_debut = '08:00:00';
                                                    $heure_fin = '20:59:59';
                                                    for ($i = date('H:i', strtotime($heure_debut)); $i <= date('H:i', strtotime($heure_fin)); $i = date('H:i', strtotime('+30 minutes', strtotime($i)))) {
                                                        echo '<th>'.$i.'</th>';
                                                    }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($pss as $ps) {
                                                    ?>
                                                    <tr>
                                                        <td style="width: 200px"><?= $ps['nom'].' '.$ps['prenom'];?></td>
                                                        <?php
                                                        for ($i = date('H:i', strtotime($heure_debut)); $i <= date('H:i', strtotime($heure_fin)); $i = date('H:i', strtotime('+30 minutes', strtotime($i)))) {
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                    } else {
                                        $json = array(
                                            'success' => false,
                                            'message' => "Aucun rendez-vous n'a été trouvé pour ce jour."
                                        );
                                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                    }
                                    ?>
                                </div>
                                <?php
                            } else {
                                $json = $audit;
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
        }
    }
}
?>
<script>
    $("#button_nouveau_rdv").click(function () {
        $("#div_liste_rdv").hide();
        $("#div_nouveau_rdv").slideDown();
    });
    $("#button_retourner").click(function () {
        $("#div_nouveau_rdv").hide();
        $("#div_liste_rdv").slideDown();
    });

    $("#nom_prenoms_input")
        .autocomplete({
            source: function(request, response) {
                $.getJSON("../../_CONFIGS/Includes/Searches/Etablissement/search_liste_patients.php", {
                    nom_prenom: $('#nom_prenoms_input').val()
                    }, response
                );
            },
            minLength: 2,
            select: function(e, ui) {
                $("#num_patient_input").val(ui.item.value);
                $("#num_secu_input").val(ui.item.num_rgb);
                $("#nom_prenoms_input").val(ui.item.label);
                return false;
            }
        })
        .keyup(function () {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#num_patient_input").val('');
            $("#num_secu_input").val('');
        })
        .blur(function () {
            $("#button_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i> Enregistrer');
            let nip = $("#num_patient_input").val();
            if(!nip) {
                $("#num_secu_input").val('');
                $("#nom_prenoms_input").val('');
            }
        });
    $("#num_patient_input").keyup(function () {
        let num_patient = $(this).val().trim();
        if(num_patient.length === 16) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Etablissement/search_liste_patients.php',
                type: 'POST',
                data: {
                    'nip': num_patient
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if(data['success'] === true) {
                        $("#num_patient_input").val(data['num_population']);
                        $("#num_secu_input").val(data['num_rgb']);
                        $("#nom_prenoms_input").val(data['nom_prenom']);
                    }else {
                        $("#p_rendez_vous_resultats")
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html("Le N.I.P "+num_patient+" est incorrect. Veuillez saisir un numéro correct.");
                        $("#num_patient_input").val('').focus();
                        $("#num_secu_input").val('');
                        $("#nom_prenoms_input").val('');
                    }
                }
            });
        }
    });

    $("#form_rendez_vous").submit(function () {
        let code_rdv    = $("#code_rdv_input").val().trim(),
            date        = $("#date_input").val().trim(),
            heure_debut = $("#heure_debut_input").val().trim(),
            heure_fin   = $("#heure_fin_input").val().trim(),
            num_patient = $("#num_patient_input").val().trim(),
            num_secu    = $("#num_secu_input").val().trim(),
            nom_prenoms = $("#nom_prenoms_input").val().trim(),
            code_ps     = $("#code_ps_input").val().trim(),
            motif       = $("#motif_input").val().trim();
        if (date && heure_debut && heure_fin && num_patient && nom_prenoms && code_ps && motif) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Etablissement/RendezVous/submit_rdv.php',
                type: 'POST',
                data: {
                    'code_rdv': code_rdv,
                    'date': date,
                    'heure_debut': heure_debut,
                    'heure_fin': heure_fin,
                    'num_patient': num_patient,
                    'code_ps': code_ps,
                    'motif': motif
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_rendez_vous").hide();
                        $("#p_rendez_vous_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 3000);
                    } else {
                        $("#p_rendez_vous_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if(!date) {
                $("#date_input").addClass('is-invalid');
                $("#dateHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la date du RDV s'il vous plait.");
            }
            if(!heure_debut) {
                $("#heure_debut_input").addClass('is-invalid');
                $("#heureDebutHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'heure de début du RDV s'il vous plait.");
            }
            if(!heure_fin) {
                $("#heure_fin_input").addClass('is-invalid');
                $("#heureFinHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'heure de fin du RDV s'il vous plait.");
            }
            if(!num_patient) {
                $("#num_patient_input").addClass('is-invalid');
                $("#numPatientHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le numéro d'identification du patient s'il vous plait.");
            }
            if(!nom_prenoms) {
                $("#nom_prenoms_input").addClass('is-invalid');
                $("#nomPrenomsHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner les nom & prénom(s) du patient s'il vous plait.");
            }
            if(!code_ps) {
                $("#code_ps_input").addClass('is-invalid');
                $("#codePsHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le médecin s'il vous plait.");
            }
            if(!motif) {
                $("#motif_input").addClass('is-invalid');
                $("#motifHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le motif du RDV s'il vous plait.");
            }
        }
        return false;
    });
    $(".date").datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        minDate: 0,
        lang: 'fr'
    });
    $(".heure").datetimepicker({
        datepicker: false,
        timepicker: true,
        format: 'H:i',
        step: 30,
        lang: 'fr'
    });
    $("#heure_debut_input").datetimepicker({
        onShow:function( ct ){
            this.setOptions({
                maxTime:$('#heure_fin_input').val()?$('#heure_fin_input').val():false
            })
        }
    });
    $("#heure_fin_input").datetimepicker({
        onShow:function( ct ) {
            this.setOptions({
                minTime: $('#heure_debut_input').val() ? $('#heure_debut_input').val() : false
            })
        }
    });
</script>
