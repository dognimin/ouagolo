<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/MEDICAMENTS.php";
$MEDICAMENTS = new MEDICAMENTS();
$dcis = $MEDICAMENTS->lister_dci(null);
$groupes = $MEDICAMENTS->lister_groupes();
$classes = $MEDICAMENTS->lister_classes_therapeutiques();
$unites = $MEDICAMENTS->lister_unites_dosages();
$formes = $MEDICAMENTS->lister_formes();
$nb_dci = count($dcis);
?>
<p class="h4">Dénominations communes internationales (DCI)</p>
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
                        <?php include "../../../_Forms/form_medicaments_dci.php";?>
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
                <th style="width: 5px">N°</th>
                <th style="width: 90px">CODE</th>
                <th style="width: 150px">FORME</th>
                <th>LIBELLE</th>
                <th style="width: 110px">DOSAGE</th>
                <th style="width: 90px">DATE EFFET</th>
                <th style="width: 5px"></th>
                <th style="width: 5px"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($dcis as $dci) {
                $dosages = $MEDICAMENTS->lister_dci_dosages($dci['code']);
                $nb_dosages = count($dosages);
                if($nb_dosages > 1) {
                    $separateur = '/';
                }else {
                    $separateur = null;
                }
                $afficher_dosage = null;
                foreach ($dosages as $dosage) {
                    $afficher_dosage = $afficher_dosage.$dosage['dosage'].$dosage['unite'].$separateur;
                }
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($dci['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $dci['code'];?></td>
                    <td><?= $dci['code_forme'];?></td>
                    <td><?= $dci['libelle'];?></td>
                    <td><?= $afficher_dosage;?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($dci['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $dci['code'].'|'.$dci['libelle'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $dci['code'];?>|med_dci" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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

    $("#code_groupe_input").change(function () {
        let code_groupe     = $(this).val().trim();
        if(code_groupe) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_sous_groupe_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_medicaments_sous_groupes.php',
                type: 'POST',
                data: {
                    'code_groupe': code_groupe
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_sous_groupe_input").prop('disabled',false)
                        .removeClass('is-valid is-invalid')
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_sous_groupe_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_groupe_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeGroupeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sous_groupe_input").prop('disabled',true)
                .empty()
                .append('<option value="">Sélectionnez</option>')
                .removeClass('is-valid')
                .addClass('is-invalid');
            $("#code_groupe_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeGroupeHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un groupe SVP.");
        }
    });
    $("#code_sous_groupe_input").change(function () {
        let code_sous_groupe = $(this).val().trim();
        if(code_sous_groupe) {
            $("#code_sous_groupe_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeSousGroupeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sous_groupe_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeSousGroupeHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un sous-groupe SVP.");
        }
    });
    $("#code_classe_input").change(function () {
        let code_classe = $(this).val().trim();
        if(code_classe) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Recherche...</i>');
            $("#code_sous_classe_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_medicaments_sous_classes_therapeutiques.php',
                type: 'POST',
                data: {
                    'code_classe': code_classe
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_sous_classe_input").prop('disabled',false)
                        .removeClass('is-valid is-invalid')
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_sous_classe_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });

            $("#code_classe_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeClasseHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sous_classe_input").prop('disabled',true)
                .empty()
                .append('<option value="">Sélectionnez</option>')
                .removeClass('is-valid')
                .addClass('is-invalid');
            $("#code_classe_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeClasseHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une classe thérapeutique SVP.");
        }
    });
    $("#code_sous_classe_input").change(function () {
        let code_sous_classe = $(this).val().trim();
        if(code_sous_classe) {
            $("#code_sous_classe_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeSousClasseHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sous_classe_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeSousClasseHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une sous-classe thérapeutique SVP.");
        }
    });
    $("#code_forme_input").change(function () {
        let code_forme = $(this).val().trim();
        if(code_forme) {
            $("#code_forme_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeFormeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_forme_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeFormeHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une forme SVP.");
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


    $("#btn_ajouter_dosage").click(function () {
        let nombre_dosages = $(".dosage_input").length;
        if(nombre_dosages <= 2) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_medicaments_unites_dosage.php',
                type: 'POST',
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $(".unite_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#div_dosages").append('<div class="row" id="div_nouveau_dosage_'+nombre_dosages+'">\n' +
                '                        <div class="col-sm-3" id="div_dosage_'+nombre_dosages+'">\n' +
                '                            <label for="dosage_'+nombre_dosages+'_input" class="form-label">Dosage</label>\n' +
                '                            <input type="text" name="name" placeholder="Dosage" id="dosage_'+nombre_dosages+'_input" class="form-control form-control-sm dosage_input" aria-describedby="dosage'+nombre_dosages+'Help" />\n' +
                '                            <div id="dosage'+nombre_dosages+'Help" class="form-text"></div>\n' +
                '                        </div>\n' +
                '                        <div class="col-sm-2" id="div_code_unite_'+nombre_dosages+'">\n' +
                '                            <label for="code_unite_'+nombre_dosages+'_input" class="form-label">Unité</label>\n' +
                '                            <select class="form-select form-select-sm unite_input" id="code_unite_'+nombre_dosages+'_input" aria-label=".form-select-sm" aria-describedby="codeUnite'+nombre_dosages+'Help">\n' +
                '                                <option value="">Sélectionnez</option>\n' +
                '                            </select>\n' +
                '                            <div id="codeUnite'+nombre_dosages+'Help" class="form-text"></div>\n' +
                '                        </div>\n' +
                '                        <div class="col-sm-1">\n' +
                '                            <label for="button" class="form-label">&nbsp;</label>\n' +
                '                            <div class="d-grid gap-2">\n' +
                '                                <button type="button" id="'+nombre_dosages+'" class="btn btn-danger btn-sm btn_retirer_dosage"><i class="bi bi-dash"></i></button>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                    </div>');
            nombre_dosages++;
        }
        return false;
    });

    $(document).on('click', '.btn_retirer_dosage', function(){
        let nombre_dosages = ($(".dosage_input").length - 1);
        $("#div_nouveau_dosage_"+nombre_dosages).remove();
        return false;
    });

    $("#form_medicaments_dci").submit(function () {

        let code_groupe         = $("#code_groupe_input").val().trim(),
            code_sous_groupe    = $("#code_sous_groupe_input").val().trim(),
            code_classe         = $("#code_classe_input").val().trim(),
            code_sous_classe    = $("#code_sous_classe_input").val().trim(),
            code_forme          = $("#code_forme_input").val().trim(),
            code                = $("#code_input").val().trim(),
            libelle             = $("#libelle_input").val().trim().toUpperCase(),
            dosage              = $(".dosage_input").map((_,el) => el.value).get(),
            unite               = $(".unite_input").map((_,el) => el.value).get();
        if(code_groupe && code_sous_groupe && code_classe && code_sous_classe && code_forme && libelle && dosage && unite) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_dci.php',
                type: 'POST',
                data: {
                    'code_sous_groupe': code_sous_groupe,
                    'code_sous_classe': code_sous_classe,
                    'code_forme': code_forme,
                    'code': code,
                    'libelle': libelle,
                    'dosage': dosage,
                    'unite': unite
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_medicaments_dci").hide();
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
