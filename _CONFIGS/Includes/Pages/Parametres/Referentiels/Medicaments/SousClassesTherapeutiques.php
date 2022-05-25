<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/MEDICAMENTS.php";
$CLASSES_THERAPEUTHIQUES = new MEDICAMENTS();
$classes_therapeuthiques = $CLASSES_THERAPEUTHIQUES->lister_classes_therapeutiques();
$sous_classes_therapeuthiques = $CLASSES_THERAPEUTHIQUES->lister_sous_classes_therapeutiques(null);
$nb_sous_classes_therapeuthiques = count($sous_classes_therapeuthiques);
?>
<p class="h4">Sous-classes thérapeutiques</p>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
    <button type="button" id="med_cth" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Classes thérapeutiques</button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../../../_Forms/form_medicament_sous_classe_therapeutique.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_sous_classes_therapeuthiques == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucune sous-classe thérapeutique n'a encore été enregistrée. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter une nouvelle</p>
        <?php
    }else {
        include "../../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th style="width: 5px">N°</th>
                <th style="width: 100px">CODE CLASSE</th>
                <th style="width: 10px">CODE</th>
                <th>LIBELLE</th>
                <th style="width: 100px">DATE EFFET</th>
                <th style="width: 5px"></th>
                <th style="width: 5px"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($sous_classes_therapeuthiques as $sous_classe_therapeuthique) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($sous_classe_therapeuthique['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $sous_classe_therapeuthique['code_classe'];?></td>
                    <td><?= $sous_classe_therapeuthique['code'];?></td>
                    <td><?= $sous_classe_therapeuthique['libelle'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($sous_classe_therapeuthique['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $sous_classe_therapeuthique['code'].'|'.$sous_classe_therapeuthique['libelle'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $classe_therapeuthique['code'];?>|med_cth" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
        $(".card-title").html('Nouvelle sous-classe');
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

    $("#form_sous_classe_therapeutique").submit(function () {
        let code_classe = $("#code_classe_input").val().trim(),
            code        = $("#code_input").val().trim(),
            libelle     = $("#libelle_input").val().trim();
        if(code_classe && libelle) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_sous_classe_therapeutique.php',
                type: 'POST',
                data: {
                    'code_classe': code_classe,
                    'code': code,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_sous_classe_therapeutique").hide();
                        $("#p_classe_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_medicaments('med_scth');
                        },5000);
                    }else {
                        $("#p_classe_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_classe) {
                $("#code_classe_input_input").addClass('is-invalid');
                $("#codeClasseHelpHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le code de la classe SVP.");
            }
            if(!libelle) {
                $("#libelle_input").addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le libellé SVP.");
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


        $(".card-title").html('Edition de classe therapeuthique');

    });

    $("#med_cth").click(function () {
        display_medicaments('med_cth');
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
            window.open("../exporter-referentiels.php?type="+code_export+"&data=med_cth", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
