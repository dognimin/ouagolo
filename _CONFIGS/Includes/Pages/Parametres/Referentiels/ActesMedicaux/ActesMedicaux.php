<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/ACTESMEDICAUX.php";
$ACTESMEDICAUX = new ACTESMEDICAUX();
$actes_medicaux = $ACTESMEDICAUX->lister_actes_medicaux(null);
$titres = $ACTESMEDICAUX->lister_titres();
$lettres = $ACTESMEDICAUX->lister_lettres_cles();
$cle_coef = $ACTESMEDICAUX->lister_coefficient(null);
$nb_actes_medicaux = count($actes_medicaux);
?>
<p class="h4">Actes Medicaux</p>
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
                        <?php include "../../../_Forms/form_acte_medical.php";?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="div_datas">
    <?php
    if($nb_actes_medicaux == 0) {
        ?>
        <p class="align_center alert alert-warning">Aucun acte medical n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
        <?php
    }else {
        include "../../../_Forms/form_export.php";
        ?>
        <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
            <thead class="bg-info">
            <tr>
                <th width="5">N°</th>
                <th width="10">CODE</th>
                <th width="10">ARTICLE</th>
                <th>LIBELLE</th>
                <th width="100">DATE EFFET</th>
                <th width="5"></th>
                <th width="5"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ligne = 1;
            foreach ($actes_medicaux as $acte_medical) {
                $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($acte_medical['date_debut'])));
                $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                if(strtotime($date_fin) > strtotime($date_edition)) {
                    $validite_edition = 1;
                }else {
                    $validite_edition = 0;
                }
                ?>
                <tr>
                    <td class="align_right"><?= $ligne;?></td>
                    <td><strong><?= $acte_medical['code'];?></strong></td>
                    <td><?= $acte_medical['code_article'];?></td>
                    <td><?= $acte_medical['libelle'];?></td>
                    <td class="align_center"><?= date('d/m/Y',strtotime($acte_medical['date_debut']));?></td>
                    <td>
                        <button type="button" id="<?= $acte_medical['code'].'|'.$acte_medical['libelle'].'|'.$acte_medical['code_titre'].'|'.$acte_medical['code_chapitre'].'|'.$acte_medical['code_section'].'|'.$acte_medical['code_article'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                    </td>
                    <td>
                        <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $acte_medical['code'];?>|act_med" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
        $(".card-title").html('Nouvel acte médical');
        return false;
    });

    $("#code_titre_input").change(function () {
        let code_titre     = $(this).val().trim();
        if(code_titre) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_chapitres_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
                type: 'post',
                data: {
                    'code_titre': code_titre
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_chapitres_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_chapitres_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_titre_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeTitreHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_titre_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeTitreHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un titre SVP.");
        }
    });

    $("#code_chapitres_input").change(function () {
        let code_titre     = $('#code_titre_input').val().trim(),
            code_chapitre     = $(this).val().trim();
        if(code_titre) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_sections_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
                type: 'post',
                data: {
                    'code_titre': code_titre,
                    'code_chapitre': code_chapitre
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_sections_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_sections_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_chapitres_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeChapitresHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_chapitres_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeChapitresHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un chapitre SVP.");
        }
    });

    $("#code_sections_input").change(function () {

        let code_titre     = $('#code_titre_input').val().trim(),
            code_chapitre     = $('#code_chapitres_input').val().trim(),
            code_section     = $(this).val().trim();
        if(code_section) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $("#code_article_input").prop('disabled',false)
                .empty();
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
                type: 'post',
                data: {
                    'code_titre': code_titre,
                    'code_chapitre': code_chapitre,
                    'code_section': code_section
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#code_article_input").prop('disabled',false)
                        .append('<option value="">Sélectionnez</option>');


                    $.each(json, function(index, value) {
                        $("#code_article_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
            $("#code_section_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeSectionHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_section_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeChapitresHelp")
                .addClass('text-danger')
                .html("Veuillez sélectionner un chapitre SVP.");
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

    $("#code_sections_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_sections_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeSectionHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_sections_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeSectionHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner une section SVP.");
        }
    });

    $("#code_chapitres_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_chapitres_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeChapitresHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_chapitres_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeChapitresHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });

    $("#code_article_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_article_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#codeArticleHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_article_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#codeArticleHelp")
                .addClass('text-danger')
                .html("Veuillez renseigner un code SVP.");
        }
    });

    $("#code_lettre_cle_1_input").keyup(function () {
        let code     = $(this).val().trim();
        if(code) {
            $("#code_lettre_cle_1_input").removeClass('is-invalid')
                .addClass('is-valid');
            $("#CodeLettreHelp")
                .removeClass('text-danger')
                .html("");
        }else {
            $("#code_lettre_cle_1_input").removeClass('is-valid')
                .addClass('is-invalid');
            $("#CodeLettreHelp")
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

    $("#form_acte_medical").submit(function () {
        let code    = $("#code_input").val().trim(),
            article  = $("#code_article_input").val().trim(),
            valeur  = [],
            code_lettre  = [],
            libelle = $("#libelle_input").val().trim();
        $('.code_lettre').each(function () {
            if ($("#"+this.id).val().trim()){
                code_lettre.push($("#"+this.id).val().trim());
            }
        });
        $('.coefficient_lettre').each(function () {
            if ($("#"+this.id).val().trim()){
                valeur.push($("#"+this.id).val().trim());
            }
        });
        if(article && code_lettre && libelle) {
            $("#button_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');

            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/ActesMedicaux/submit_acte_medical.php',
                type: 'POST',
                data: {
                    'code': code,
                    'code_article': article,
                    'valeur': valeur,
                    'code_lettre': code_lettre,
                    'libelle': libelle
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    if (data['success'] === true) {
                        $("#form_acte_medical").hide();
                        $("#p_acte_medical_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_actes_medicaux('act_med');
                        },5000);
                    }else {
                        $("#p_acte_medical_resultats").removeClass('alert alert-success')
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
            }  if(!code_article) {
                $("#code_article_input").addClass('is-invalid');
                $("#codeArticleHelp")
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
            libelle = tableau[1],
            titre = tableau[2],
            chapitre = tableau[3],
            section = tableau[4],
            article = tableau[5];
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
            type: 'post',
            data: {
                'code_titre': titre
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === chapitre){
                        $("#code_chapitres_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_chapitres_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }
        });
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
            type: 'post',
            data: {
                'code_titre': titre,
                'chapitre_code': chapitre
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === chapitre){
                        $("#code_sections_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_sections_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }
        });
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_actes_medicaux.php',
            type: 'post',
            data: {
                'code_titre': titre,
                'chapitre_code': chapitre,
                'section_code': section
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === section){
                        $("#code_article_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_article_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }
        });
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_lettre_cle_acte_medicale.php',
            type: 'post',
            data: {
                'code': code,
            },
            success: function(data) {
                $("#dynamic_field").html(data);
            }
         /*   dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');

                $.each(json, function(index, value) {
                    if (index === section){
                        $("#code_article_input").append('<option value="'+ index +'" selected >'+ value +'</option>');
                    }else{
                        $("#code_article_input").append('<option value="'+ index +'">'+ value +'</option>');
                    }
                });
            }*/
        });
        $("#code_input").val(code).prop('disabled',true);
        $("#code_titre_input").val(titre);
        $("#code_chapitre_input").val(chapitre);
        $("#code_sections_input").val(section);
        $("#code_article_input").val(article);
        $("#libelle_input").val(libelle);


        $(".card-title").html('Edition de Acte Medical');

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
            window.open("../exporter-referentiels.php?type="+code_export+"&data=act_med", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
        }
    });

    var i = 2;
    $('#plus_champs').click(function(){
        if(i <= 4) {

                $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_lettres_cles.php',
                type: 'post',
                data: {
                },
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $("#code_lettre_cle_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });

            $('#dynamic_field').append(
                '<div class="col-sm-9" id="div_lettre_cle_'+i+'">' +
                '<label for="code_lettre_cle_'+i+'_input" class="form-label">Lettre clé</label>' +
                '<select class="form-select form-select-sm code_lettre"  name="names" id="code_lettre_cle_input" aria-label=".form-select-sm" aria-describedby="code_lettre_cle_'+i+'_input">' +
                '<option value="">Sélectionnez la lettre clé</option>' +

                '</select>' +
                '</div>' +
                '<div class="col-sm-2" id="div_coefficient_'+i+'">' +
                '<label for="coefficient_'+i+'_input" class="form-label">Coefficient</label>' +
                '<input type="text" name="name" placeholder="Coefficient" id="coefficient_'+i+'_input" class="form-control form-control-sm name_list coefficient_lettre"  />' +
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
