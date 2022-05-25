<?php

require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
$LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
$pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
$communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(NULL);
$regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(NULL);
$departements = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(NULL);
$nb_commune = count($communes);
?>


<p class="h4">Communes</p>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
    <button type="button" id="lge" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Pays</button>
    <button type="button" id="reg" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Regions</button>
    <button type="button" id="dep" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Départements</button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../../_Forms/form_commune.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_commune == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucune commune n'a encore été enregistrée. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter une nouvelle</p>
        <?php
    }else {
        include "../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th width="100">PAYS</th>
                <th width="100">REGION</th>
                <th width="100">DEPARTEMENT</th>
                <th width="10">CODE</th>
                <th>NOM</th>
                <th width="150">COORDONNEES</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($communes as $commune) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($commune['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $commune['code_pays'];?></td>
                    <td><?= $commune['code_region'];?></td>
                    <td><?= $commune['code_departement'];?></td>
                    <td><strong><?= $commune['code'];?></strong></td>
                    <td><?= $commune['nom'];?></td>
                    <td class="align_right"><a href=""><?= $commune['latitude'].','.$commune['longitude'];?></a></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($commune['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $commune['code'].'|'.$commune['nom'].'|'.$commune['latitude'].'|'.$commune['longitude'].'|'.$commune['code_pays'].'|'.$commune['code_region'].'|'.$commune['code_departement'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $commune['code'];?>|com" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
        $(".card-title").html('Nouvelle commune');
        return false;
    });

    $("#code_pays_input").change(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_region_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
                type: 'post',
                data: {
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_region_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_region_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_pays_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codePaysHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_pays_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codePaysHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un pays SVP.");
        }
    });

    $("#code_region_input").change(function () {
        let code_region     = $(this).val().trim(),
            code_pays     = $("#code_pays_input").val().trim();

        if(code_region) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_departement_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../_CONFIGS/Includes/Searches/Parametres/search_localisation.php',
                type: 'post',
                data: {
                    'code_region': code_region,
                    'code_pays': code_pays
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_departement_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_departement_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_region_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeRegionHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_region_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeRegionHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner une region SVP.");
        }
    });

    $("#code_departement_input").change(function () {
        let code_depart     = $(this).val().trim();
        if(code_depart) {
            $("#code_departement_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeDepartHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_region_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeDepartHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un departement SVP.");
        }
    });

    $("#nom_input").keyup(function () {
        let nom     = $(this).val().trim();
        if(nom) {
            $("#nom_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#nomHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#nom_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#nomHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un nom SVP.");
        }
    });

    $("#latitude_input").keyup(function () {
        let latitude     = $(this).val().trim();
        if(latitude && latitude.length > 5) {
            $("#latitude_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#latitudeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#latitude_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#latitudeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une latitude SVP.");
        }
    });

    $("#longitude_input").keyup(function () {
        let longitude     = $(this).val().trim();
        if(longitude && longitude.length > 5) {
            $("#longitude_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#longitudeHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#longitude_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#longitudeHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une longitude SVP.");
        }
    });

    $("#form_commune").submit(function () {
        let code_departement    = $("#code_departement_input").val().trim(),
            region               = $("#code_region_input").val().trim(),
            pays               = $("#code_pays_input").val().trim(),
            code                = $("#code_input").val().trim(),
            nom                 = $("#nom_input").val().trim(),
            latitude            = $("#latitude_input").val().trim(),
            longitude           = $("#longitude_input").val().trim();
            if(pays && region && code_departement && nom && nom.length >= 3 ) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_commune.php',
                type: 'POST',
                data: {
                    'code_departement': code_departement,
                    'code': code,
                    'nom': nom,
                    'latitude': latitude,
                    'longitude': longitude,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_commune").hide();
                        $("#p_commune_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_tables_de_valeurs('com');
                        },2000);
                    }else {
                        $("#p_commune_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
    else {
            if(!nom) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom SVP.");
            }
            if(!region) {
                $("#code_region_input").addClass('is-invalid');
                $("#codeRegionHelp")
                    .addClass('text-danger')
                    .html("Veuillez Selection une region  SVP.");
            }
            if(!pays) {
                $("#code_pays_input").addClass('is-invalid');
                $("#codePaysHelp")
                    .addClass('text-danger')
                    .html("Veuillez Selection un pays  SVP.");
            }
            if(!latitude) {
                $("#latitude_input").addClass('is-invalid');
                $("#latitudeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner les coordonnées géographiques (Latitude) SVP.");
            }
                if(!code_departement) {
                    $("#code_departement_input").addClass('is-invalid');
                    $("#codeDepartHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le nom SVP.");
                }
                if(!latitude) {
                    $("#latitude_input").addClass('is-invalid');
                    $("#latitudeHelp")
                        .addClass('text-danger')
                        .html("Veuillez selectionner le departement  SVP.");
                }
            if(!longitude) {
                $("#longitude_input").addClass('is-invalid');
                $("#longitudeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner les coordonnées géographiques (Longitude) SVP.");
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
            latitude = tableau[2],
            longitude = tableau[3],
            pays = tableau[4],
            region = tableau[5],
            departement = tableau[6],
            libelle = tableau[1];
        $.ajax({
            url: '../_CONFIGS/Includes/Searches/search_localisation.php',
            type: 'post',
            data: {
                'code_region': region,
                'code_departement': departement
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === departement){
                        $("#code_departement_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_departement_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }
        });
        $.ajax({
            url: '../_CONFIGS/Includes/Searches/search_localisation.php',
            type: 'post',
            data: {
                'code_pays': pays
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === region){
                        $("#code_region_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_region_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }
        });

        $("#code_input").val(code).prop('disabled',true);
        $("#nom_input").val(libelle);
        $("#latitude_input").val(latitude);
        $("#longitude_input").val(longitude);
        $("#code_pays_input").val(pays);
        $("#code_region_input").val(region);
        $("#code_departement_input").val(departement);


        $(".card-title").html('Edition de commune');

    });

    $("#lge").click(function () {
        display_tables_de_valeurs('lge');
    });
    $("#reg").click(function () {
        display_tables_de_valeurs('reg');
    });
    $("#dep").click(function () {
        display_tables_de_valeurs('dep');
    });
    $("#com").click(function () {
        display_tables_de_valeurs('com');
    });
    $(".button_historique").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            donnee = tableau[0],
            type_donnee = tableau[1];
        if(donnee && type_donnee) {
            $.ajax({
                url: '../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
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

    $('#historiqueModal').modal({
        show: false,
        backdrop: 'static'
    });
    $('#tableDeValeurs').DataTable();

    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("exporter-table-de-valeurs.php?type="+code_export+"&data=com", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
