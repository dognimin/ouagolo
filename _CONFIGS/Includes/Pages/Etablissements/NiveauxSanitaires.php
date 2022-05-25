<?php
require_once "../../../Classes/UTILISATEURS.php";
require_once "../../../Classes/ETABLISSEMENTS.php";
$ETABLISSEMENTS = new ETABLISSEMENTS();
$niveaux_sanitaires = $ETABLISSEMENTS->lister_niveaux_sanitaires();
$nb_niveaux_sanitaires = count($niveaux_sanitaires);
?>
<p class="align_right">
    <button type="button" class="btn btn-primary btn-sm btn_add_niveau_sanitaire"><i class="bi bi-plus-square-fill"></i></button>
</p>
<div id="div_form">
    <div class="row justify-content-md-center">

        <div class="col-md-10">
            <div class="card">
                <div class="card-body row">
                    <h5 class="card-title"></h5>
                    <div class="row justify-content-md-center">
                        <?php include "../_Forms/form_etablissements_niveaux_sanitaires.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_niveaux_sanitaires == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucun niveau sanitaire n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add_niveau_sanitaire"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
        <?php
    }else {
        include "../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped table_data">
            <thead class="bg-info">
            <tr>
                <th style="width: 5px">N°</th>
                <th style="width: 10px">CODE</th>
                <th>LIBELLES</th>
                <th style="width: 5px">NIVEAU</th>
                <th style="width: 100px">DATE EFFET</th>
                <th style="width: 5px"></th>
                <th style="width: 5px"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($niveaux_sanitaires as $niveau_sanitaire) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($niveau_sanitaire['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><?= $niveau_sanitaire['code'];?></td>
                    <td><?= $niveau_sanitaire['libelle'];?></td>
                    <td class="align_right"><?= $niveau_sanitaire['niveau'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($niveau_sanitaire['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $niveau_sanitaire['code'].'|'.$niveau_sanitaire['libelle'].'|'.$niveau_sanitaire['niveau'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $niveau_sanitaire['code'];?>|etab_niveau" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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

    $(".btn_add_niveau_sanitaire").click(function () {
        $("#div_datas").hide();
        $("#div_form").slideDown();
        $(".card-title").html('Nouveau niveau sanitaire');
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

    $("#niveau_input").keyup(function () {
        let niveau     = $(this).val().trim();
        if(niveau) {
            $("#niveau_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#niveauHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#niveau_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#niveauHelp")
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

    $("#form_niveau").submit(function () {
        let code    = $("#code_input").val().trim(),
            niveau  = $("#niveau_input").val().trim(),
            libelle = $("#libelle_input").val().trim();
        if(code) {
            $("#button_enregistrer_niveau_sanitaire").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Parametres/Etablissements/submit_niveau_sanitaire.php',
                type: 'POST',
                data: {
                    'code': code,
                    'libelle': libelle,
                    'niveau': niveau
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer_niveau_sanitaire").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_niveau").hide();
                        $("#p_niveau_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_niveaux_sanitaires();
                        },5000);
                    }else {
                        $("#p_niveau_resultats").removeClass('alert alert-success')
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
            }  if(!niveau) {
                $("#niveau_input").addClass('is-invalid');
                $("#niveauHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le niveau SVP.");
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
            niveau = tableau[2];
        $("#code_input").val(code).prop('disabled',true);
        $("#niveau_input").val(niveau);
        $("#libelle_input").val(libelle);


        $(".card-title").html('Edition de niveau sanitaire');

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

    $('.table_data').DataTable();

    $("#export_input").change(function () {
        let code_export = $("#export_input").val();
        if(code_export) {
            window.open("../exporter-etablissements.php?type="+code_export+"&data=etab_niveau", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });

    var i = 2;
    $('#plus_champs').click(function(){

        if(i <= 4) {
            $('#dynamic_field').append(
                '<div class="col-sm-9" id="div_lettre_cle_'+i+'">' +
                '<label for="code_lettre_cle_'+i+'_input" class="form-label">Lettre clé</label>' +
                '<select class="form-select form-select-sm"  name="names[]" id="code_lettre_cle_'+i+'_input" aria-label=".form-select-sm" aria-describedby="code_lettre_cle_'+i+'_input">' +
                '<option value="">Sélectionnez la lettre clé</option>' +

                '<option value=""></option>' +
                '</select>' +
                '</div>' +
                '<div class="col-sm-2" id="div_coefficient_'+i+'">' +
                '<label for="coefficient_'+i+'_input" class="form-label">Coefficient</label>' +
                '<input type="text" name="name[]" placeholder="Coefficient" id="coefficient_'+i+'_input" class="form-control form-control-sm name_list" />' +
                '</div>' +
                '<div class="col-sm-1" id="button_remove_'+i+'">' +
                '<label for="button" class="form-label">&nbsp;</label>' +
                '<div class="d-grid gap-2">' +
                '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove"><i class="bi bi-dash"></i></button>' +
                '</div>' +
                '</div>');
            i++;
        }
        console.log(i);
    });
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#div_lettre_cle_'+button_id+'').remove();
        $('#div_coefficient_'+button_id+'').remove();
        $('#button_remove_'+button_id+'').remove();
        i--;
        console.log(i);
    });
    $('#submit').click(function(){
        $.ajax({
            url:"name.php",
            method:"POST",
            data:$('#add_name').serialize(),
            success:function(data)
            {
                alert(data);
                $('#add_name')[0].reset();
            }
        });
    });
</script>
