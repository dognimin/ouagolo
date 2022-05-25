<?php
if(isset($_POST['code_patient'])) {
$code_patient = $_POST['code_patient'];
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/PATIENTS.php";
$UTILISATEURS = new UTILISATEURS();
$PATIENTS = new PATIENTS();
$patient = $PATIENTS->trouver($code_patient,null,null);
if($patient) {
require_once "../../../../Classes/TYPESPERSONNES.php";
require_once "../../../../Classes/PATIENTS.php";
require_once "../../../../Classes/ALLERGIES.php";
$TYPESPERSONNES = new TYPESPERSONNES();
$ALLERGIES = new ALLERGIES();
$PATIENTS = new PATIENTS();
$types_personnes = $TYPESPERSONNES->lister();
    $patient_allergies = $PATIENTS->lister_allergies($patient['code_patient']);
    $allergies = $ALLERGIES->lister();

?>
<br />
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-indigo">
                Allergie(s)
            </div>
            <div class="card-body">
                <p class="align_right">
                    <button type="button" class="btn btn-primary btn-sm btn_add_patient_allergie"><i class="bi bi-plus-square-fill"></i></button>
                </p>

                <div class="row" id="div_infos_allergie">
                    <?php
                    $nb_allergies = count($patient_allergies);
                    if ($nb_allergies == 0) {
                        ?>
                        <p class="align_center alert alert-warning">Aucune allergie n'a encore été enregistrée pour ce patient. <br/>Cliquez sur <a href="" class="btn_add_patient_allergie"><i class="bi bi-plus-square-fill"></i></a>pour en ajouter une</p>
                        <?php
                    }
                    else { ?>
                <table class="table table-bordered table-hover table-sm table-striped">
                <thead class="bg-info">
                <tr>
                    <th width="5">N°</th>
                    <th>CODE</th>
                    <th>LIBELLE</th>
                    <th>DATE D'EFFET</th>
                    <th width="5"></th>
                </tr>
                </thead>
                <tbody>

                  <?php
                  $ligne = 1;
                    foreach ($patient_allergies as $allergie) {
                        $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($allergie['date_debut'])));
                        $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                        if (strtotime($date_fin) > strtotime($date_edition)) {
                            $validite_edition = 1;
                        } else {
                            $validite_edition = 0;
                        }
                        ?>
                        <tr>
                            <td class="align_right"><?= $ligne; ?></td>
                            <td><?= strtoupper($allergie['code_allergie']); ?></td>
                            <td>
                                <?= $allergie['libelle'] ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($allergie['date_debut'])); ?></td>
                            <td>
                                <button type="button" class="badge bg-danger btn_remove_allergie" id="<?= $patient['code_patient'].'|'.$allergie['code_allergie']?>"> <i class="bi bi-trash-fill"></i></button>                                   </td>

                        </tr>
                        <?php
                        $ligne++;
                    }
                }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="div_patient_info_allergie_form">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body row">
                                <h5 class="card-title"></h5>
                                <div class="row justify-content-md-center">
                                    <?php include "../../_Forms/form_patient_allergie.php";?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <br />
<div class="row" id="div_ecu">

    <div class="col">
        <div class="card">

            <div class="card-header bg-indigo">
                Numéro(s) en cas d'urgence

            </div>
            <div class="card-body">
                <p class="align_right">
                    <button type="button" class="btn btn-primary btn-sm btn_add_patient_ecu"><i class="bi bi-plus-square-fill"></i></button>
                </p>
                <?php
                $personnes_ecu = $PATIENTS->lister_ecu($patient['code_patient']);
                $nb_personnes_ecu = count($personnes_ecu);
                if ($nb_personnes_ecu == 0) {
                    ?>
                    <p class="align_center alert alert-warning">Aucune personne n'a encore été enregistrée pour ce patient. <br/>Cliquez sur <a href="" class="btn_add_patient_ecu"><i class="bi bi-plus-square-fill"></i></a>pour en ajouter une</p>
                    <?php
                }
                else {
                    ?>
                    <div class="row" id="div_infos_ecu">
                        <p id="p_patient_ecu_resultat"></p>
                        <table class="table table-bordered table-hover table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th width="5">N°</th>
                                <th>TYPE</th>
                                <th>NOM PRENOMS</th>
                                <th>NUMERO DE TELEPHONE</th>
                                <th width="100">DATE D'EFFET</th>
                                <th width="5"></th>
                                <th width="5"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($personnes_ecu as $personne_ecu) {
                                $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($personne_ecu['date_debut'])));
                                $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                                if (strtotime($date_fin) > strtotime($date_edition)) {
                                    $validite_edition = 1;
                                } else {
                                    $validite_edition = 0;
                                }
                                ?>
                                <tr>
                                    <td class="align_right"><?= $ligne; ?></td>
                                    <td><?= strtoupper($personne_ecu['libelle']); ?></td>
                                    <td>
                                        <?=  ucwords(strtolower($personne_ecu['nom_ecu'])).' '.ucwords(strtolower($personne_ecu['prenoms_ecu'])) ?>
                                    </td>
                                    <td><?= $personne_ecu['telephone'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($personne_ecu['date_debut'])); ?></td>
                                    <td>
                                        <button type="button" class="badge bg-danger btn_remove_ecu" id="<?= $patient['code_patient'].'|'.$personne_ecu['telephone'].'|'.$personne_ecu['type_code']?>"> <i class="bi bi-trash-fill"></i></button>                                   </td>
                                    <td>
                                        <button type="button" id="<?= $personne_ecu['type_code'] . '|' . $personne_ecu['telephone']  . '|' . $personne_ecu['nom_ecu'] . '|' . $personne_ecu['prenoms_ecu']; ?>" class="badge bg-<?php if ($validite_edition == 0) {echo 'secondary';} else {echo 'warning';} ?> btn_edit_ecu" <?php if ($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                                    </td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="div_patient_info_ecu_form">
                        <div class="row justify-content-md-center">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-body row">
                                        <h5 class="card-title"></h5>
                                        <div class="row justify-content-md-center">
                                            <?php include "../../_Forms/form_patient_ecu.php";?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

    <?php
}
}
?>

<script>
    var i = 2;
    $('#plus_champs_allergies').click(function(){
        if(i <= 4) {

            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Centre/Patients/search_allergies.php',
                type: 'post',
                data: {
                },
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $("#allergie_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });

            $('#div_allergie').append(
                '<div class="col-sm-11" id="div_lettre_cle_'+i+'">' +
                '<label for="allergie_1_input'+i+'_input" class="form-label">Allergie</label>' +
                '<select class="form-select form-select-sm allergie"  name="names" id="allergie_input" aria-label=".form-select-sm" aria-describedby="allergie_1_input'+i+'_input">' +
                '<option value="">Sélectionnez une allergie</option>' +

                '</select>' +
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

    $(".btn_remove_ecu").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            telephone = tableau[1],
            type = tableau[2],
            code = tableau[0];
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_retirer_ecu.php',
            type: 'post',
            data: {
                'code': code,
                'type': type,
                'telephone': telephone,
            },
            dataType: 'json',
            success: function (data) {
                if (data['success'] === true) {
                    setTimeout(function () {
                        display_patient_infos_personnelles(code);
                    });
                }else {
                    $("#p_patient_ecu_resultat").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
    });
    $(".btn_remove_allergie").click(function () {
        let this_id = this.id,
            tableau = this_id.split('|'),
            code_allergie = tableau[1],
            code_patient = tableau[0];
        $.ajax({
            url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_retirer_allergie.php',
            type: 'post',
            data: {
                'code_allergie': code_allergie,
                'code_patient': code_patient,

            },
            dataType: 'json',
            success: function (data) {
                if (data['success'] === true) {
                    setTimeout(function () {
                        display_patient_infos_personnelles(code_patient);
                    });
                }else {
                    $("#p_patient_allergie_resultats").removeClass('alert alert-success')
                        .addClass('alert alert-danger')
                        .html(data['message']);
                }
            }
        });
    });

    $("#div_patient_info_ecu_form").hide();
    $("#div_patient_info_allergie_form").hide();
    $(".btn_add_patient_ecu").click(function () {
        $("#div_infos_ecu").hide();
        $("#div_patient_info_ecu_form").slideDown();
        $(".card-title").html("Nouveau contact en cas d'urgence");
        return false;
    });
    $(".btn_add_patient_allergie").click(function () {
        $("#div_infos_allergie").hide();
        $("#div_patient_info_allergie_form").slideDown();
        $(".card-title").html("Nouvelle allergie");
        return false;
    });

    $(".btn_edit_ecu").click(function () {
        $("#div_infos_ecu").hide();
        $("#div_patient_info_ecu_form").slideDown();

        let this_id = this.id,
            tableau = this_id.split('|'),
            type = tableau[0],
            numero = tableau[1],
            nom = tableau[2],
            prenom = tableau[3];
        $("#code_type_personne_ecu_input").val(type).prop('disabled',true);
        $("#numero_patient_ecu_input").val(numero);
        $("#nom_patient_ecu_input").val(nom);
        $("#prenoms_patient_ecu_input").val(prenom);
        $(".card-title").html("Edition contact d'urgence ");

    });

    $("#button_patient_ecu_retourner").click(function () {
        $("#div_patient_info_ecu_form").hide();
        $("#div_infos_ecu").slideDown();
        return false;
    });
    $("#button_patient_allergie_retourner").click(function () {
        $("#div_patient_info_allergie_form").hide();
        $("#div_infos_allergie").slideDown();
        return false;
    });

    $("#form_patient_ecu").submit(function () {
        let code_patient    = '<?= $code_patient;?>',
            type_personne = $("#code_type_personne_ecu_input").val().trim(),
            nom = $("#nom_patient_ecu_input").val().trim(),
            prenoms = $("#prenoms_patient_ecu_input").val().trim(),
            numero = $("#numero_patient_ecu_input").val().trim();
        if(code_patient && type_personne && numero && nom && prenoms) {
            $("#button_patient_ecu_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_patient_ecu.php',
                type: 'POST',
                data: {
                    'code_patient': code_patient,
                    'type_personne_ecu': type_personne,
                    'nom': nom,
                    'prenoms': prenoms,
                    'numero': numero,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_patient_ecu_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_patient_ecu").hide();
                        $("#p_patient_ecu_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_patient_infos_personnelles(code_patient);
                        },5000);
                    }else {
                        $("#p_patient_ecu_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!type_personne) {
                $("#code_type_personne_ecu_input").addClass('is-invalid');
                $("#typePersonneEcuHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de personne s'il vous plait.");
            }
            if(!numero) {
                $("#numero_patient_ecu_input").addClass('is-invalid');
                $("#numeroEcuHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner le numéro s'il vous plait.");
            }
        }
        return false;
    });
    $("#form_patient_allergie").submit(function () {
        let code_patient    = '<?= $code_patient;?>',
            allergie  = $("#code_allergie_input").val().trim();

        if(code_patient && allergie ) {
            $("#button_patient_ecu_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Centre/Patients/submit_patient_allergie.php',
                type: 'POST',
                data: {
                    'code_patient': code_patient,
                    'allergie': allergie,

                },
                dataType: 'json',
                success: function (data) {
                    $("#button_patient_allergie_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_patient_allergie").hide();
                        $("#p_patient_allergie_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_patient_infos_personnelles(code_patient);
                        },5000);
                    }else {
                        $("#p_patient_allergie_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!allergie) {
                $("#code_allergie_input").addClass('is-invalid');
                $("#allergieHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner une allergie s'il vous plait.");
            }
        }
        return false;
    });
</script>

