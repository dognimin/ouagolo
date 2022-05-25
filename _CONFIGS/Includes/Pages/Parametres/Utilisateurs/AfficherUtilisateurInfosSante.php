<?php
if(isset($_POST['uid'])) {
    $id_user = $_POST['uid'];
    require_once "../../../../Classes/UTILISATEURS.php";
    $UTILISATEURS = new UTILISATEURS();
    $user = $UTILISATEURS->trouver($id_user,null);
    if($user) {
        require_once "../../../../Classes/GROUPESSANGUINS.php";
        $GROUPESSANGUINS = new GROUPESSANGUINS();
        $rhesuss = $GROUPESSANGUINS->lister_rhesus();
        $groupes_sanguins = $GROUPESSANGUINS->lister();
        ?>
        <br />
        <div class="row">
            <p class="display-3">
                NIP: <strong><?= $user['nip'];?></strong>
            </p>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-indigo">
                        Groupe sanguin
                    </div>
                    <div class="card-body">
                        <div id="div_user_groupe_sanguin">
                            <table class="table table-bordered table-sm table-striped">
                                <tr>
                                    <td>Groupe sanguin</td>
                                    <td>
                                        <?php
                                        if ($user['groupe_sanguin']) {
                                            echo '<strong>'.$user['groupe_sanguin'].'<sup>'.$user['code_rhesus'].'</sup></strong> <a href="" class="btn_add_user_groupe_sanguin"><i class="bi bi-pencil-square"></i></a>';
                                        }else {
                                            echo '<i class="alert-warning">Aucun groupe sanguin n\'a encore été défini pour '.ucwords(strtolower($user['prenoms'])).' cliquez sur <a href="" class="btn_add_user_groupe_sanguin"><i class="bi bi-plus-square-fill"></i></a> pour en ajouter un</i>';
                                        }
                                        ?>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="div_user_groupe_sanguin_form">
                            <div class="row justify-content-md-center">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-body row">
                                            <h5 class="card-title"></h5>
                                            <div class="row justify-content-md-center">
                                                <?php include "../../_Forms/form_utilisateur_groupe_sanguin.php";?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br />
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-indigo">
                        Allergies
                    </div>
                    <div class="card-body">
                        <div id="div_user_allergies">

                        </div>
                        <div id="div_user_allergie_form">
                            <div class="row justify-content-md-center">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-body row">
                                            <h5 class="card-title"></h5>
                                            <div class="row justify-content-md-center">

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    $(".btn_add_user_groupe_sanguin").click(function () {
        $("#div_user_groupe_sanguin").hide();
        $("#div_user_groupe_sanguin_form").slideDown();
        $(".card-title").html('Edition du groupe sanguin');
        return false;
    });
    $("#button_user_groupe_sanguin_retourner").click(function () {
        $("#div_user_groupe_sanguin_form").hide();
        $("#div_user_groupe_sanguin").slideDown();
        return false;
    });
    $("#form_utilisateur_groupe_sanguin").submit(function () {
        let id_user     = $("#id_user_input").val().trim(),
            code_groupe = $("#code_groupe_sanguin_input").val().trim(),
            code_rhesus = $("#code_rhesus_input").val().trim();
        if(id_user && code_groupe && code_rhesus) {
            $("#button_groupe_sanguin_enregistrer").prop('disabled', true)
                .removeClass('btn-primary')
                .addClass('btn-warning')
                .html('<i>Traitement...</i>');
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_utilisateur_groupe_sanguin.php',
                type: 'POST',
                data: {
                    'id_user': id_user,
                    'code_groupe': code_groupe,
                    'code_rhesus': code_rhesus,
                },
                dataType: 'json',
                success: function (data) {
                    $("#button_groupe_sanguin_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('Enregistrer');
                    if (data['success'] === true) {
                        $("#form_utilisateur_groupe_sanguin").hide();
                        $("#p_utilisateur_groupe_sanguin_resultats").removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .html(data['message']);
                        setTimeout(function () {
                            display_utilisateur_infos_sante(id_user);
                        },5000);
                    }else {
                        $("#p_utilisateur_groupe_sanguin_resultats").removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .html(data['message']);
                    }
                }
            });
        }
        else {
            if(!code_groupe) {
                $("#code_groupe_sanguin_input").addClass('is-invalid');
                $("#groupeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le groupe sanguin de l'utilisateur s'il vous plait.");
            }
            if(!code_rhesus) {
                $("#code_rhesus_input").addClass('is-invalid');
                $("#rhesusHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le rhésus de l'utilisateur s'il vous plait.");
            }

        }

        return false;
    });
</script>
