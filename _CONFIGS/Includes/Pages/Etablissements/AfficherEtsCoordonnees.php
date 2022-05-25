<?php
if(isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Classes/ETABLISSEMENTS.php";
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver($code_ets,null);
    if($ets) {
        require_once "../../../Classes/TYPESCOORDONNEES.php";
        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
        $types_coordonnees = $TYPESCOORDONNEES->lister();
        ?>
        <div id="div_ets_coordonnees">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_ets_coordonnees"><i class="bi bi-plus-square-fill"></i></button>
            </p>
            <?php
            $coordonnees = $ETABLISSEMENTS->lister_coordonnees($ets['code']);
            $nb_coordonnees = count($coordonnees);
            if ($nb_coordonnees == 0) {
                ?>
                <p class="align_center alert alert-warning">Aucune coordonnée n'a encore été enregistrée pour ce centre. <br/>Cliquez sur <a href="" class="btn_add_ets_coordonnees"><i class="bi bi-plus-square-fill"></i></a>pour en ajouter une</p>
                <?php
            }
            else {
                ?>
                <div class="row">
                    <table class="table table-bordered table-hover table-sm table-striped" id="table_coordonnees">
                        <thead class="bg-info">
                        <tr>
                            <th style="width: 5px">N°</th>
                            <th>TYPE</th>
                            <th>VALEUR</th>
                            <th style="width: 100px">DATE D'EFFET</th>
                            <th style="width: 5px"></th>
                            <th style="width: 5px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($coordonnees as $coordonnee) {
                            $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($coordonnee['date_debut'])));
                            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                            if (strtotime($date_fin) > strtotime($date_edition)) {
                                $validite_edition = 1;
                            } else {
                                $validite_edition = 0;
                            }
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne; ?></td>
                                <td><?= strtoupper($coordonnee['libelle']); ?></td>
                                <td>
                                    <?php
                                    $tableau_tel = array('TELFIX', 'TELFAX', 'MOBPER', 'MOBPRO');
                                    $tableau_mail = array('MELPRO','MELPER');
                                    $tableau_site = array('SITWEB');
                                    if (in_array($coordonnee['code_type'], $tableau_tel)) {
                                        $donnee_c = chunk_split($coordonnee['valeur'], 2, ' ');
                                    }elseif (in_array($coordonnee['code_type'], $tableau_mail)) {
                                        $donnee_c = '<a href="mailto:' . $coordonnee['valeur'] . '">' . $coordonnee['valeur'] . '</a>';
                                    }elseif (in_array($coordonnee['code_type'], $tableau_site)) {
                                        $donnee_c = '<a target="_blank" href="' . $coordonnee['valeur'] . '">' . $coordonnee['valeur'] . '</a>';
                                    }else {
                                        $donnee_c = $coordonnee['valeur'];
                                    }
                                    echo $donnee_c;
                                    ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($coordonnee['date_debut'])); ?></td>
                                <td>
                                    <button type="button" class="badge bg-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td>
                                    <button type="button" id="<?= $coordonnee['code_type'] . '|' . $coordonnee['libelle']; ?>" class="badge bg-<?php if ($validite_edition == 0) {echo 'secondary';} else {echo 'warning';} ?> btn_edit" <?php if ($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
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
        <div id="div_ets_coordonnees_form">
            <div class="row justify-content-md-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../_Forms/form_etablissement_coordonnee.php";?>
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
    $(".btn_add_ets_coordonnees").click(function () {
        $("#div_ets_coordonnees").hide();
        $("#div_ets_coordonnees_form").slideDown();
        $(".card-title").html('Nouvelle coordonnée');
        return false;
    });
    $("#button_ets_coordonnees_retourner").click(function () {
        $("#div_ets_coordonnees_form").hide();
        $("#div_ets_coordonnees").slideDown();
        return false;
    });

    $("#code_type_coordonnee_input").change(function () {
        let code = $(this).val().trim(),
            code_telephone = ['MOBPER','MOBPRO','TELFAX','TELPRO'],
            code_email = ['MELPER','MELPRO'],
            code_web = ['SITWEB'];

        if(code_telephone.includes(code)) {
            $("#valeur_ets_coordonnee_input")
                .prop('disabled',false)
                .attr('type','tel')
                .attr('maxLength','10')
                .val('')
                .focus();
        }else if(code_email.includes(code)) {
            $("#valeur_ets_coordonnee_input")
                .prop('disabled',false)
                .attr('type','email')
                .attr('maxLength','100')
                .val('')
                .focus();
        }else if(code_web.includes(code)) {
            $("#valeur_ets_coordonnee_input")
                .prop('disabled',false)
                .attr('type','url')
                .attr('maxLength','150')
                .val('')
                .focus();
        }else {
            $("#valeur_ets_coordonnee_input")
                .prop('disabled',true)
                .val('');
        }
    });

    $("#form_etablissement_coordonnee").submit(function () {
        let code_ets    = '<?= $code_ets;?>',
            type        = $("#code_type_coordonnee_input").val().trim(),
            valeur      = $("#valeur_ets_coordonnee_input").val().trim();

        if(code_ets && type && valeur) {
            $("#button_ets_coordonnees_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../_CONFIGS/Includes/Submits/Etablissements/submit_etablissement_coordonnee.php',
                type: 'POST',
                data: {
                    'code_ets': code_ets,
                    'type': type,
                    'valeur': valeur,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_ets_coordonnees_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_etablissement_coordonnee").hide();
                        $("#p_etablissement_coordonnee_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_ets_coordonnees(1, code_ets);
                        },5000);
                    }else {
                        $("#p_etablissement_coordonnee_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!type) {
                $("#code_type_coordonnee_input").addClass('is-invalid');
                $("#typeCoordHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de coordonnée s'il vous plait.");
            }
            if(!valeur) {
                $("#valeur_ets_coordonnee_input").addClass('is-invalid');
                $("#valeurCoordonneeHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner la valeur de la coordonnée s'il vous plait.");
            }
        }
        return false;
    });
    $("#table_coordonnees").DataTable();
</script>
