<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/MEDICAMENTS.php";
$MEDICAMENTS = new MEDICAMENTS();
$medicaments = $MEDICAMENTS->lister_medicaments();
$classes_therapeutiques = $MEDICAMENTS->lister_classes_therapeutiques();
$dci = $MEDICAMENTS->lister_dci(null);
$familles_formes = $MEDICAMENTS->lister_familles_formes();
$formes = $MEDICAMENTS->lister_formes();
$formes_administrations = $MEDICAMENTS->lister_formes_administrations();
$laboratoires_pharmaceutiques = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
$presentations = $MEDICAMENTS->lister_presentations();
$dosages = $MEDICAMENTS->lister_unites_dosages();
$types_medicaments = $MEDICAMENTS->lister_types_medicaments();
$unites_dosages = $MEDICAMENTS->lister_unites_dosages();
$nb_medicaments = count($medicaments);
?>
<p class="h4">Mediacements</p>
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
                        <?php include "../../../_Forms/form_medicament.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_medicaments == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucun medicament n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
        <?php
    }else {
        include "../../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th width="10">CODE</th>
                <th>LIBELLE</th>
                <th>FORME</th>
                <th>EAN13</th>
                <th>DCI</th>
                <th>DOSAGE</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($medicaments as $medicament) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($medicament['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $medicament['code'];?></td>
                    <td><?= $medicament['libelle'];?></td>
                    <td><?= $medicament['code_forme'];?></td>
                    <td align="right"><?= $medicament['code_ean13'];?></td>
                    <td><?= $medicament['code_dci'];?></td>
                    <td align="right
"><?= $medicament['dosage'].$medicament['code_unite_dosage'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($medicament['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $medicament['code'].'|'.$medicament['libelle'].'|'.$medicament['dosage'].'|'.$medicament['code_ean13'].'|'.$medicament['code_forme'].'|'.$medicament['code_dci'].'|'.$medicament['code_laboratoire'].'|'.$medicament['code_classe_therapeutique'].'|'.$medicament['code_famille'].'|'.$medicament['code_forme_administration'].'|'.$medicament['code_type_medicament'].'|'.$medicament['code_presentation'].'|'.$medicament['code_unite_dosage'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $medicament['code'];?>|med" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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

    $("#forme_code").change(function () {

        let code_forme     = $(this).val().trim();

        if(code_forme) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#dci_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_dci.php',
                type: 'post',
                data: {
                    'code_forme': code_forme,
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#dci_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#dci_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#forme_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeSectionHelp")
                .removeClass('text-danger')
                .html("");
        }


    });
    $("#button_retourner").click(function () {
        $("#div_form").hide();
        $("#div_datas").slideDown();
        return false;
    });

    $(".btn_add").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau medicament');
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
    $("#forme_code").keyup(function () {
        let forme_code     = $(this).val().trim();
        if(forme_code) {
            $("#forme_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#formeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#forme_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#formeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la forme du medicament SVP.");
        }
    });
    $("#aen13_code").keyup(function () {
        let aen13_code     = $(this).val().trim();
        if(aen13_code) {
            $("#aen13_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#aen13Help")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#aen13_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#aen13Help")
                .addClass('text-danger')
                .html("Veuillez renseigner le AEN13 du medicament SVP.");
        }
    });
    $("#dci_input").keyup(function () {
        let dci     = $(this).val().trim();
        if(dci) {
            $("#dci_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#dciHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#dci_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#dciHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le DCI du medicament SVP.");
        }
    });
    $("#laboratoire_code").keyup(function () {
        let labo     = $(this).val().trim();
        if(labo) {
            $("#laboratoire_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#laboHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#laboratoire_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#laboHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le laboratoire pharmaceutique SVP.");
        }
    });
    $("#classe_therapeuthique_code").keyup(function () {
        let classe     = $(this).val().trim();
        if(classe) {
            $("#classe_therapeuthique_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#classHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#classe_therapeuthique_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#classHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la classe theurapeutique SVP.");
        }
    });
    $("#famille_forme_code").keyup(function () {
        let famille     = $(this).val().trim();
        if(famille) {
            $("#famille_forme_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#familleFormeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#famille_forme_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#familleFormeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la famille de forme du medicament SVP.");
        }
    });
    $("#forme_administration_code").keyup(function () {
        let forme_administration     = $(this).val().trim();
        if(forme_administration) {
            $("#forme_administration_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#formeAdministrationHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#forme_administration_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#formeAdministrationHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la forme d\'administration du medicament SVP.");
        }
    });
    $("#type_medicament_code").keyup(function () {
        let type     = $(this).val().trim();
        if(type) {
            $("#type_medicament_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#typeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#type_medicament_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#typeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner le type du medicament SVP.");
        }
    });
    $("#presentations_code").keyup(function () {
        let presentation     = $(this).val().trim();
        if(presentation) {
            $("#presentations_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#presentationHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#presentations_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#presentationHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner la presentation SVP.");
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
                .html("Veuillez renseigner le dosage SVP.");
        }
    });
    $("#unite_dosage_code").keyup(function () {
        let unite_dosage     = $(this).val().trim();
        if(unite_dosage) {
            $("#unite_dosage_code").removeClass('is-invalid')
                .addClass('is-valid');
            $("#uniteDosageHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#unite_dosage_code").removeClass('is-valid')
                .addClass('is-invalid');
            $("#uniteDosageHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner l\'unité de dosage SVP.");
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
    $("#form_medicament").submit(function () {
        let code    = $("#code_input").val().trim(),
            libelle = $("#libelle_input").val().trim(),
            aen13 = $("#aen13_code").val().trim(),
            forme = $("#forme_code").val().trim(),
            dci = $("#dci_input").val().trim(),
            dosage = $("#dosage_input").val().trim(),
            unite_doage_code = $("#unite_dosage_code").val().trim(),
            laboratoire = $("#laboratoire_code").val().trim(),
            classe = $("#classe_therapeuthique_code").val().trim(),
            famille_forme = $("#famille_forme_code").val().trim(),
            forme_administration = $("#forme_administration_code").val().trim(),
            type = $("#type_medicament_code").val().trim(),
            presenation = $("#presentations_code").val().trim();
        if(code && libelle && forme && dci && laboratoire && classe && famille_forme && forme_administration && type && presenation ) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_medicament.php',
                type: 'POST',
                data: {
                    'code': code,
                    'forme': forme,
                    'dci': dci,
                    'dosage': dosage,
                    'unite_dosage_code': unite_doage_code,
                    'laboratoire': laboratoire,
                    'classe': classe,
                    'famille_forme': famille_forme,
                    'forme_administration': forme_administration,
                    'type': type,
                    'presentation': presenation,
                    'aen13': aen13,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_medicament").hide();
                        $("#p_medicament_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_medicaments('med');
                        },5000);
                    }else {
                        $("#p_medicament_resultats").removeClass('alert alert-success')
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
            if(!forme) {
                $("#forme_code").addClass('is-invalid');
                $("#formeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la forme du medicament SVP.");
            }
            if(!aen13) {
                $("#aen13_code").addClass('is-invalid');
                $("#aen13Help")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le AEN13 SVP.");
            }
            if(!dci) {
                $("#dci_input").addClass('is-invalid');
                $("#dciHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le DCI du médicament SVP.");
            }
            if(!laboratoire) {
                $("#laboratoire_code").addClass('is-invalid');
                $("#laboHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le laboratoire  SVP.");
            }
            if(!classe) {
                $("#classe_therapeuthique_code").addClass('is-invalid');
                $("#classHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la classe  SVP.");
            }
            if(!famille_forme) {
                $("#famille_forme_code").addClass('is-invalid');
                $("#familleFormeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la famille forme  SVP.");
            }
            if(!forme_administration) {
                $("#forme_administration_code").addClass('is-invalid');
                $("#formeAdministrationHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la forme d'administration  SVP.");
            }
            if(!type) {
                $("#type_medicament_code").addClass('is-invalid');
                $("#typeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le type du médicament  SVP.");
            }
            if(!presenation) {
                $("#presentations_code").addClass('is-invalid');
                $("#presentationHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la présentation  SVP.");
            }
            if(!dosage) {
                $("#dosage_input").addClass('is-invalid');
                $("#dosageHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le dosage  SVP.");
            }
            if(!unite_doage_code) {
                $("#unite_dosage_code").addClass('is-invalid');
                $("#uniteDosageHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner l'unité de dosage  SVP.");
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
            aen13 = tableau[3],
            dosage = tableau[2],
            forme = tableau[4],
            dci = tableau[5],
            labo = tableau[6],
            classe = tableau[7],
            famille_forme = tableau[8],
            forme_administration = tableau[9],
            type = tableau[10],
            presentation = tableau[11],
            unite_dosage = tableau[12];
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_dci.php',
            type: 'post',
            data: {
                'code_forme': forme,
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                $("#dci_input").prop('disabled',false)
                $.each(json, function(index, value) {
                        $("#dci_input").append('<option value="' + index + ' ">' + value + '</option>');
                });
            }
        });

        $("#code_input").val(code).prop('disabled',true);
        $("#libelle_input").val(libelle);
        $("#dosage_input").val(dosage);
        $("#forme_code").val(forme);
        $("#aen13_code").val(aen13);
        $("#forme_code").val(forme);
        $("#dci_input").val(dci);
        $("#laboratoire_code").val(labo);
        $("#classe_therapeuthique_code").val(classe);
        $("#famille_forme_code").val(famille_forme);
        $("#forme_administration_code").val(forme_administration);
        $("#type_medicament_code").val(type);
        $("#presentations_code").val(presentation);
        $("#unite_dosage_code").val(unite_dosage);


        $(".card-title").html('Edition d\'un médicament');

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
            window.open("../exporter-referentiels.php?type="+code_export+"&data=med", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
