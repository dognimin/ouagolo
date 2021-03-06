<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
$LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
$regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(NULL);
$etats = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
$nb_regions = count($regions);
?>
<p class="h4">Régions</p>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
    <button type="button" id="lge" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Pays</button>
    <button type="button" id="dep" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Départements</button>
    <button type="button" id="com" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-right-square"></i> Communes</button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">

        <div class="col-md-10">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../../_Forms/form_region.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_regions == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucune region n'a encore été enregistrée. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter une nouvelle</p>
        <?php
    }else {
        include "../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th>PAYS</th>
                <th width="10">CODE</th>
                <th>NOM</th>
                <th width="120">COORDONNEES</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($regions as $region) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($region['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $region['code_pays'];?></td>
                    <td><?= $region['code'];?></td>
                    <td><?= $region['nom'];?></td>
                    <td class="align_right"><a href=""><?= $region['latitude'].','.$region['longitude'];?></a></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($region['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $region['code'].'|'.$region['nom'].'|'.$region['code_pays'].'|'.$region['longitude'].'|'.$region['latitude'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $region['code'];?>|reg" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
        $(".card-title").html('Nouvelle région');
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

    $("#code_pays_input").keyup(function () {
        let code_pays     = $(this).val().trim();
        if(code_pays) {
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

    $("#form_region").submit(function () {
        let code_pays   = $("#code_pays_input").val().trim(),
            code        = $("#code_input").val().trim(),
            nom         = $("#nom_input").val().trim(),
            latitude    = $("#latitude_input").val().trim(),
            longitude   = $("#longitude_input").val().trim();
        if(code_pays && code && nom && nom.length > 3 && latitude && latitude.length > 5 && longitude && longitude.length > 5) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Parametres/TablesDeValeurs/submit_geo_region.php',
                type: 'POST',
                data: {
                    'code_pays': code_pays,
                    'code': code,
                    'nom': nom,
                    'latitude': latitude,
                    'longitude': longitude
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_region").hide();
                        $("#p_region_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_tables_de_valeurs('reg');
                        },5000);
                    }else {
                        $("#p_region_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_pays) {
                $("#code_pays_input").addClass('is-invalid');
                $("#codePaysHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le pays SVP.");
            }
            if(!code) {
                $("#code_input").addClass('is-invalid');
                $("#codeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le code SVP.");
            }
            if(!nom) {
                $("#nom_input").addClass('is-invalid');
                $("#nomHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le nom SVP.");
            }
            if(!latitude) {
                $("#latitude_input").addClass('is-invalid');
                $("#latitudeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner les coordonnées géographiques (Latitude) SVP.");
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
            libelle = tableau[1],
            pays = tableau[2],
            longitude = tableau[3],
            latitude = tableau[4];
        $("#code_input").val(code).prop('disabled',true);
        $("#nom_input").val(libelle);
        $("#code_pays_input").val(pays);
        $("#longitude_input").val(longitude);
        $("#latitude_input").val(latitude);


        $(".card-title").html('Edition de région');

    });

    $("#lge").click(function () {
        display_tables_de_valeurs('lge');
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
            window.open("exporter-table-de-valeurs.php?type="+code_export+"&data=reg", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });
</script>
