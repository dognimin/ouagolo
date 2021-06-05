<?php
if(isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ETABLISSEMENTSSERVICES.php";
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver_etablissement($code_ets);
    if($ets) {
        $ETABLISSEMENTSSERVICES = new ETABLISSEMENTSSERVICES();
        $services = $ETABLISSEMENTSSERVICES->lister();
        ?>
        <br/>
        <div id="div_ets_service">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_ets_service"><i class="bi bi-plus-square-fill"></i></button>
            </p>
            <br/>
            <?php
            $ets_services = $ETABLISSEMENTS->lister_ets_servies($ets['code']);
            $nb_ets_services = count($ets_services);
            if ($nb_ets_services == 0) {
                ?>
                <p class="align_center alert alert-warning">Aucun service n'a encore été enregistré pour ce centre. <br/>Cliquez sur <a href="" class="btn_add_ets_service"><i class="bi bi-plus-square-fill"></i></a> pour en ajouter un</p>
                <?php
            }
            else {
                ?>
                <div class="row">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th width="10">CODE</th>
                            <th>LIBELLE</th>
                            <th width="100">DATE D'EFFET</th>
                            <th width="5"></th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($ets_services as $ets_service) {
                            $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($ets_service['date_debut'])));
                            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                            if (strtotime($date_fin) > strtotime($date_edition)) {
                                $validite_edition = 1;
                            } else {
                                $validite_edition = 0;
                            }
                            ?>
                            <tr>
                                <td><?= $ligne;?></td>
                                <td><?= $ets_service['code_service'];?></td>
                                <td><?= $ets_service['libelle'];?></td>
                                <td><?= date('d/m/Y',strtotime($ets_service['date_debut']));?></td>
                                <td>
                                    <button type="button" class="badge bg-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td>
                                    <button type="button" id="<?= $ets_service['code_service'] . '|' . $ets_service['libelle']; ?>" class="badge bg-<?php if ($validite_edition == 0) {echo 'secondary';} else {echo 'warning';} ?> btn_edit" <?php if ($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                                </td>
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
        <div id="div_ets_service_form">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../../_Forms/form_ets_services.php"; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    $(".btn_add_ets_service").click(function () {
        $("#div_ets_service").hide();
        $("#div_ets_service_form").slideDown();
        $(".card-title").html('Nouveau service');
        return false;
    });
    $("#button_ets_service_retourner").click(function () {
        $("#div_ets_service_form").hide();
        $("#div_ets_service").slideDown();
        return false;
    });

    $("#form_ets_services").submit(function () {
        let code_ets        = $("#code_ets_input").val().trim(),
            code_service    = $("#code_service_input").val().trim();

        if(code_ets) {
            $("#button_service_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_ets_service.php',
                type: 'POST',
                data: {
                    'code_ets': code_ets,
                    'code_service': code_service

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_service_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_ets_services").hide();
                        $("#p_service_hospitalier_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_ets_services(code_ets);
                        },5000);
                    }else {
                        $("#p_service_hospitalier_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        // else {
        //     if(!nom_utilisateur) {
        //         $("#nom_utilisateur_input").addClass('is-invalid');
        //         $("#nomUtilisateurHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner le nom utilisateur s'il vous plait.");
        //     }
        //     if(!email) {
        //         $("#email_input").addClass('is-invalid');
        //         $("#emailHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner l'adesse email s'il vous plait.");
        //     }
        //     if(!nom) {
        //         $("#nom_input").addClass('is-invalid');
        //         $("#nomHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner le nom de famille s'il vous plait.");
        //     }
        //     if(!prenoms) {
        //         $("#prenoms_input").addClass('is-invalid');
        //         $("#prenomsHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner le(s) prénom(s) s'il vous plait.");
        //     }
        //     if(!date_naissance) {
        //         $("#date_naissance_input").addClass('is-invalid');
        //         $("#dateNaissanceHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner la date de naissance s'il vous plait.");
        //     }
        //     if(!civilite) {
        //         $("#civilites_input").addClass('is-invalid');
        //         $("#civilitesHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner une civilite s'il vous plait.");
        //     }
        //     if(!sexe) {
        //         $("#sexes_input").addClass('is-invalid');
        //         $("#sexesHelp")
        //             .addClass('text-danger')
        //             .html("Veuillez renseigner un sexe s'il vous plait.");
        //     }
        // }

        return false;
    });
</script>
