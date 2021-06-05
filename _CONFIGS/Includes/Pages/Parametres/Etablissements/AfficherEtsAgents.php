<?php
if (isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/TYPESCOORDONNEES.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $types_coordonnees = $TYPESCOORDONNEES->lister();
    $ets = $ETABLISSEMENTS->trouver_etablissement($code_ets);
    $agents = $ETABLISSEMENTS->lister_agents_libres();
    $agents_etablissement = $ETABLISSEMENTS->lister_agents_etablissement($ets['code']);
    if ($ets) {
        ?>
        <br/>
        <div id="div_ets_agents">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_ets_agents"><i
                            class="bi bi-plus-square-fill"></i></button>
            </p>
            <br/>
            <?php
            $nb_agents = count($agents_etablissement);
            if ($nb_agents == 0) {
                ?>
                <p class="align_center alert alert-warning">Aucun agent n'a encore été enregistré pour ce centre. <br/>Cliquez
                    sur <a href="" class="btn_add_ets_coordonnees"><i class="bi bi-plus-square-fill"></i></a>pour en
                    ajouter un</p>
                <?php
            } else {
                ?>
                <div class="row">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th>NOM & PRENOMS</th>
                            <th width="100">DATE D'EFFET</th>
                            <th width="5"></th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($agents_etablissement as $agent_etablissement) {
                            $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($agent_etablissement['date_debut'])));
                            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                            if (strtotime($date_fin) > strtotime($date_edition)) {
                                $validite_edition = 1;
                            } else {
                                $validite_edition = 0;
                            }
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne; ?></td>
                                <td><?= strtoupper($agent_etablissement['nom'] . ' ' . $agent_etablissement['prenoms']); ?></td>
                                <td><?= date('d/m/Y', strtotime($agent_etablissement['date_debut'])); ?></td>
                                <td>
                                    <button type="button" class="badge bg-danger"><i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button"
                                            id="<?= $agent_etablissement['code_etablissement'] . '|' . $agent_etablissement['utilisateur_id']; ?>"
                                            class="badge bg-<?php if ($validite_edition == 0) {
                                                echo 'secondary';
                                            } else {
                                                echo 'warning';
                                            } ?> btn_edit" <?php if ($validite_edition == 0) {
                                        echo 'disabled';
                                    } ?>><i class="bi bi-brush"></i></button>
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
        <div id="div_ets_agents_form">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../../_Forms/form_etablissement_agent.php"; ?>
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
    $(".btn_add_ets_agents").click(function () {
        $("#div_ets_agents").hide();
        $("#div_ets_agents_form").slideDown();
        $(".card-title").html('Nouvel agent');
        return false;
    });
    $("#button_ets_agents_retourner").click(function () {
        $("#div_ets_agents_form").hide();
        $("#div_ets_agents").slideDown();
        return false;
    });

    $("#form_etablissement_agent").submit(function () {
        let code_ets = '<?= $ets['code'];?>',
            agent = $("#agent_id_input").val().trim();

        if (code_ets && agent) {
            $("#button_ets_agents_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_etablissement_agent.php',
                type: 'POST',
                data: {
                    'etablissement': code_ets,
                    'agent': agent,

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_agent").hide();
                        $("#p_etablissement_agent_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_ets_agents(code_ets);
                        }, 5000);
                    } else {
                        $("#p_etablissement_agent_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        } else {
            if (!agent) {
                $("#code_type_agent_input").addClass('is-invalid');
                $("#typeCoordHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner un agent  s'il vous plait.");
            }

        }
        return false;
    });
</script>
