<?php
if(isset($_POST['code_patient'])) {
    $code_patient = $_POST['code_patient'];
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/PATIENTS.php";
    $UTILISATEURS = new UTILISATEURS();
    $PATIENTS = new PATIENTS();
    $patient = $PATIENTS->trouver($code_patient,null,null);
    if($patient) {
        require_once "../../../../Classes/TYPESCOORDONNEES.php";
        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
        $types_coordonnees = $TYPESCOORDONNEES->lister();
        ?>
        <br/>
        <div id="div_patient_coordonnees">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_patient_coordonnees"><i class="bi bi-plus-square-fill"></i></button>
            </p>
            <br/>
            <?php
            $patient_coordonnees = $PATIENTS->lister_coordonnees($patient['code_patient']);
            $nb_coordonnees = count($patient_coordonnees);
            if ($nb_coordonnees == 0) {
                ?>
                <p class="align_center alert alert-warning">Aucune coordonnée n'a encore été enregistrée pour ce patient. <br/>Cliquez sur <a href="" class="btn_add_patient_coordonnees"><i class="bi bi-plus-square-fill"></i></a>pour en ajouter une</p>
                <?php
            }
            else {
                ?>
                <div class="row">
                    <p id="p_patient_coordonnees_resultats"></p>

                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th>TYPE</th>
                            <th>VALEUR</th>
                            <th width="100">DATE D'EFFET</th>
                            <th width="5"></th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($patient_coordonnees as $patient_coordonnee) {
                            $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($patient_coordonnee['date_debut'])));
                            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                            if (strtotime($date_fin) > strtotime($date_edition)) {
                                $validite_edition = 1;
                            } else {
                                $validite_edition = 0;
                            }
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne; ?></td>
                                <td><?= strtoupper($patient_coordonnee['libelle']); ?></td>
                                <td>
                                    <?php
                                    $tableau_tel = array('TELFIX', 'MOBPRO');
                                    $tableau_mail = array('MELPRO','MELPER');
                                    $tableau_site = array('SITWEB');
                                    if (in_array($patient_coordonnee['code_type'], $tableau_tel)) {
                                        $donnee_c = chunk_split($patient_coordonnee['valeur'], 2, ' ');
                                    }elseif (in_array($patient_coordonnee['code_type'], $tableau_mail)) {
                                        $donnee_c = '<a href="mailto:' . $patient_coordonnee['valeur'] . '">' . $patient_coordonnee['valeur'] . '</a>';
                                    }elseif (in_array($patient_coordonnee['code_type'], $tableau_site)) {
                                        $donnee_c = '<a target="_blank" href="' . $patient_coordonnee['valeur'] . '">' . $patient_coordonnee['valeur'] . '</a>';
                                    }else {
                                        $donnee_c = $patient_coordonnee['valeur'];
                                    }
                                    echo $donnee_c;
                                    ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($patient_coordonnee['date_debut'])); ?></td>
                                <td>
                                    <button type="button" class="badge bg-danger btn_remove" id="<?= $patient['code_patient'].'|'.$patient_coordonnee['code_type']?>"><i class="bi bi-trash-fill"></i></button>
                                </td>
                                <td>
                                    <button type="button" id="<?= $patient_coordonnee['code_type'].'|'.$patient_coordonnee['valeur'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit_coordonnee" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
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
        <div id="div_patient_coordonnees_form">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../../_Forms/form_patient_coordonnee.php";?>
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
    $(".btn_edit_coordonnee").click(function () {
        $("#div_patient_coordonnees").hide();
        $("#div_patient_coordonnees_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            code = tableau[0],
            libelle = tableau[1];

        $("#code_type_coordonnee_input").val(code).prop('disabled',true);
        $("#valeur_patient_coordonnee_input").val(libelle);



        $(".card-title").html("Edition d'une coordonnée");

    });

    $(".btn_remove").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            type = tableau[1],
            code = tableau[0];
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_retirer_coordonnee.php',
            type: 'post',
            data: {
                'code': code,
                'type': type,
            },
            dataType: 'json',
            success: function (data) {
                if (data['success'] === true) {
                    setTimeout(function () {
                        display_patient_coordonnees(code);
                    });
                }else {
                    $("#p_patient_coordonnees_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
    });

    $("#div_patient_coordonnees_form").hide();
    $(".btn_add_patient_coordonnees").click(function () {
        $("#div_patient_coordonnees").hide();
        $("#div_patient_coordonnees_form").slideDown();
        $(".card-title").html('Nouvelle coordonnée');
        return false;
    });

    $("#button_patient_coordonnees_retourner").click(function () {
        $("#div_patient_coordonnees_form").hide();
        $("#div_patient_coordonnees").slideDown();
        return false;
    });

    $("#form_patient_coordonnee").submit(function () {
        let code_patient    = '<?= $code_patient;?>',
            type_coord  = $("#code_type_coordonnee_input").val().trim(),
            valeur      = $("#valeur_patient_coordonnee_input").val().trim();

        if(code_patient && type_coord && valeur) {
            $("#button_patient_coordonnees_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_patient_coordonnee.php',
                type: 'POST',
                data: {
                    'code_patient': code_patient,
                    'type_coord': type_coord,
                    'valeur': valeur,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_patient_coordonnees_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_patient_coordonnee").hide();
                        $("#p_patient_coordonnee_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_patient_coordonnees(code_patient);
                        },5000);
                    }else {
                        $("#p_patient_coordonnee_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }

        return false;
    });
</script>
