<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/MEDICAMENTS.php";
$DCI = new MEDICAMENTS();
$denominations_communes_internationales = $DCI->lister_dci(null);
$unites = $DCI->lister_unites_dosages();
$formes = $DCI->lister_formes();
$nb_dci = count($denominations_communes_internationales);
?>
<p class="h4">Dénominations communes internationales (DCI)</p>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">

        <div class="col-md-10">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../../../_Forms/form_medicaments_denomination_commune_internationale.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_dci == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucune DCI de dosage n'a encore été enregistrée. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
        <?php
    }else {
        include "../../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th width="200">CODE</th>
                <th width="200">DOSAGE</th>
                <th width="200">FORME</th>
                <th>LIBELLE</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($denominations_communes_internationales as $denomination_commune_internationale) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($denomination_commune_internationale['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $denomination_commune_internationale['code'];?></td>
                    <td><?= $denomination_commune_internationale['dosage'].$denomination_commune_internationale['code_unite'];?></td>
                    <td><?= $denomination_commune_internationale['code_forme'];?></td>
                    <td><?= $denomination_commune_internationale['libelle'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($denomination_commune_internationale['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $denomination_commune_internationale['code'].'|'.$denomination_commune_internationale['libelle'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $denomination_commune_internationale['code'];?>|med_dci" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
                    </td>
                </tr>
                <?php
                $ligne++;
            }
            ?>
            </tbody>
        </table>
        <div class="modal fade" id="historiqueModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="historiqueModalLabel"><i class="bi bi-clock-history"></i> Historique des modifications</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="div_historique"></div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<script>
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouvelle Dénomination commune internationale');
        return false;
    });

    $("#code_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });
    $("#dosage_input").keyup(function () {
        let dosage     = $(this).val().trim();
        if(dosage) {
            $("#dosage_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#dosageHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#dosage_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#dosageHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un dosage SVP.");
        }
    });

    $("#forme_input").keyup(function () {
        let forme     = $(this).val().trim();
        if(forme) {
            $("#forme_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#formeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#forme_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#formeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une forme SVP.");
        }
    });
    $("#unite_input").keyup(function () {
        let unite     = $(this).val().trim();
        if(unite) {
            $("#unite_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#uniteHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#unite_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#uniteHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une unité de dosage SVP.");
        }
    });

    $("#libelle_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle && libelle.length > 3) {
            $("#libelle_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#libelleHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#libelle_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#libelleHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un libellé SVP.");
        }
    });

    $("#form_dci").submit(function () {
        let code    = $("#code_input").val().trim(),
         unite    = $("#unite_input").val().trim(),
         dosage    = $("#dosage_input").val().trim(),
         forme    = $("#forme_input").val().trim(),
            libelle = $("#libelle_input").val().trim();
        if(code && libelle && unite && forme && dosage) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_denomination_commune_internationale.php',
                type: 'POST',
                data: {
                    'code': code,
                    'unite': unite,
                    'dosage': dosage,
                    'forme': forme,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_dci").hide();
                        $("#p_dci_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_medicaments('med_dci');
                        },5000);
                    }else {
                        $("#p_dci_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code) {
                $("#code_input").addClass('is-invalid');
                $("#codeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code SVP.");
            }
            if(!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
            }
            if(!unite) {
                $("#unite_input").addClass('is-invalid');
                $("#uniteHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner une unité de dosage SVP.");
            }
            if(!dosage) {
                $("#dosage_input").addClass('is-invalid');
                $("#dosageHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner un dosage SVP.");
            }
            if(!forme) {
                $("#forme_input").addClass('is-invalid');
                $("#formeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner une forme SVP.");
            }
        }
        return false;
    });

    $(".btn_edit").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            libelle = tableau[1];
        $("#code_input").val(code).prop('disabled',true);
        $("#libelle_input").val(libelle);


        $(".card-title").html('Edition Dénomination commune internationale  ');

    });

    $('#historiqueModal').modal({
        show: false,
        backdrop: 'static'
    });

    $(".button_historique").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            donnee = tableau[0],
            type_donnee = tableau[1];
        if(donnee && type_donnee) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
                type: 'POST',
                data: {
                    'donnee': donnee,
                    'type': type_donnee
                },
                success: function (data) {
                    $("#div_historique").html(data);
                }
            });
        }
    });

    $('#tableDeValeurs').DataTable();

    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("../exporter-referentiels.php?type="+code_export+"&data=med_dci", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
