<?php
if (isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Classes/ETABLISSEMENTS.php";
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver($code_ets, null);
    if ($ets) {
        require_once "../../../Classes/ETABLISSEMENTSSERVICES.php";
        $ETABLISSEMENTSSERVICES = new ETABLISSEMENTSSERVICES();
        $services = $ETABLISSEMENTSSERVICES->lister();
        ?>
        <div id="div_ets_services">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_ets_service"><i class="bi bi-plus-square-fill"></i></button>
            </p>
            <?php
            $ets_services = $ETABLISSEMENTS->lister_servies($ets['code']);
            $nb_services = count($ets_services);
            if ($nb_services == 0) {
                ?>
                <p class="align_center alert alert-warning">Aucun service n'a encore été enregistré pour ce centre. <br/>Cliquez sur <a href="" class="btn_add_ets_service"><i class="bi bi-plus-square-fill"></i></a>pour en ajouter un</p>
                <?php
            } else {
                ?>
                <div class="row">
                    <table class="table table-bordered table-hover table-sm table-striped" id="table_services">
                        <thead class="bg-info">
                        <tr>
                            <th style="width: 5px">N°</th>
                            <th style="width: 100px">CODE</th>
                            <th>LIBELLE</th>
                            <th style="width: 100px">DATE D'EFFET</th>
                            <th style="width: 5px"></th>
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
                                <td class="align_right"><?= $ligne; ?></td>
                                <td><?= strtoupper($ets_service['code']); ?></td>
                                <td><?= $ets_service['libelle'];?></td>
                                <td><?= date('d/m/Y', strtotime($ets_service['date_debut'])); ?></td>
                                <td>
                                    <button type="button" id="<?= $ets_service['code'] . '|' . $ets_service['libelle']; ?>" class="badge bg-danger btn_remove" data-bs-toggle="modal" data-bs-target="#removeModal"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                            <?php
                            $ligne++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="removeModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php include "../_Forms/form_retrait_service_hospitalier.php";?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="div_ets_service_form">
            <div class="row justify-content-md-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../_Forms/form_service_hospitalier.php";?>
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
        $("#div_ets_services").hide();
        $("#div_ets_service_form").slideDown();
        $(".card-title").html('Nouveau service');
        return false;
    });
    $("#button_ets_service_retourner").click(function () {
        $("#div_ets_service_form").hide();
        $("#div_ets_services").slideDown();
        return false;
    });

    $(".btn_remove").click(function () {
        let thid_id = this.id,
            tableau = thid_id.split('|'),
            code    = tableau[0],
            libelle = tableau[1];
        $("#removeModalLabel").html("Retrait du service "+libelle);
        $("#code_service_retrait_input").val(code).prop('disabled', true);
    });

    $("#form_service_hospitalier").submit(function () {
        let code_ets        = '<?= $code_ets;?>',
            code_service    = $("#code_service_input").val().trim();

        if(code_ets && code_service) {
            $("#button_service_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement_service.php',
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
                        $("#form_service_hospitalier").hide();
                        $("#p_service_hospitalier_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_ets_services(1, code_ets);
                        },3000);
                    }else {
                        $("#p_service_hospitalier_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_service) {
                $("#code_service_input").addClass('is-invalid');
                $("#codeServiceHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le service s'il vous plait.");
            }
        }

        return false;
    });
    $("#form_retrait_service_hospitalier").submit(function () {
        let code_ets        = '<?= $code_ets;?>',
            code_service    = $("#code_service_retrait_input").val().trim();

        if(code_ets && code_service) {
            $("#button_service_retrait_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement_retrait_service.php',
                type: 'POST',
                data: {
                    'code_ets': code_ets,
                    'code_service': code_service

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_service_retrait_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_retrait_service_hospitalier").hide();
                        $("#p_retrait_service_hospitalier_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_ets_services(1, code_ets);
                        },3000);
                    }else {
                        $("#p_retrait_service_hospitalier_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_service) {
                $("#code_service_retrait_input").addClass('is-invalid');
                $("#codeServiceRetraitHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le service s'il vous plait.");
            }
        }
        return false;
    });
    $("#table_services").DataTable();

    $('.modal').modal({
        show: false,
        backdrop: 'static'
    });
</script>
