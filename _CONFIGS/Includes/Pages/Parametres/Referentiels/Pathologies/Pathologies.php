<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/PATHOLOGIES.php";
$PATHOLOGIES = new PATHOLOGIES();
$pathologies = $PATHOLOGIES->lister_pathologies(null,null);
$chapitres = $PATHOLOGIES->lister_chapitres();
$nb_pathologie = count($pathologies);
?>
<p class="h4">Pathologies</p>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../../../_Forms/form_pathologie.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_pathologie == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucune pathologie n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
        <?php
    }else {
        include "../../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th width="10">CODE</th>
                <th>CHAPITRE</th>
                <th>SOUS-CHAPITRE</th>
                <th>LIBELLE</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($pathologies as $pathologie) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($pathologie['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $pathologie['code'];?></td>
                    <td><?= $pathologie['code_chapitre'];?></td>
                    <td><?= $pathologie['code_sous_chapitre'];?></td>
                    <td><?= $pathologie['libelle'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($pathologie['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $pathologie['code'].'|'.$pathologie['libelle'].'|'.$pathologie['chapitre'].'|'.$pathologie['code_sous_chapitre'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $pathologie['code'];?>|pat" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
        $(".card-title").html('Nouvelle pathologie');
        return false;
    });

    $("#code_chapitre_input").change(function () {
        let code_chapitre     = $(this).val().trim();
        if(code_chapitre) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_sous_chapitre_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_pathologie.php',
                type: 'post',
                data: {
                    'code_chapitre': code_chapitre
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_sous_chapitre_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_sous_chapitre_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_chapitre_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeChapitresHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_chapitre_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeChapitresHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un chapitre svp SVP.");
        }
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

    $("#code_sous_chapitre_input").keyup(function () {
        let code_sous_chapitre     = $(this).val().trim();
        if(code_sous_chapitre) {
            $("#code_sous_chapitre_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codesousChapitresHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sous_chapitre_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codesousChapitresHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un sous categorie SVP.");
        }
    });

    $("#libelle_input").keyup(function () {
        let libelle     = $(this).val().trim();
        if(libelle) {
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

    $("#form_pathologie").submit(function () {
        let code                  = $("#code_input").val().trim(),
            code_sous_chapitre    = $("#code_sous_chapitre_input").val().trim(),
            code_chapitre    = $("#code_chapitre_input").val().trim(),
            libelle               = $("#libelle_input").val().trim();
        if(code && libelle && code_sous_chapitre) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Pathologies/submit_pathologie.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_sous_chapitre': code_sous_chapitre,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_pathologie").hide();
                        $("#p_pathologie_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_pathologies('pat');
                        },5000);
                    }else {
                        $("#p_pathologie_resultats").removeClass('alert alert-success')
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
            if(!code_sous_chapitre) {
                $("#code_sous_chapitre_input").addClass('is-invalid');
                $("#codesousChapitresHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le sous chapitre code SVP.");
            }
            if(!code_chapitre) {
                $("#code_chapitre_input").addClass('is-invalid');
                $("#codeChapitresHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner  chapitre code SVP.");
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
            libelle = tableau[1],
            chapitre = tableau[2],
            code_sous_chapitre = tableau[3];
        $("#code_input").val(code).prop('disabled',true);
        $("#libelle_input").val(libelle);
        $("#code_chapitre_input").val(chapitre);
        $("#code_sous_chapitre_input").val(code_sous_chapitre);


        $(".card-title").html('Edition de patologie');

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
            window.open("../exporter-referentiels.php?type="+code_export+"&data=pat", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
