<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);

            require_once "../../../../Classes/TYPESCOORDONNEES.php";
            require_once "../../../../Classes/PATIENTS.php";
            $PATIENTS = new PATIENTS();
            $TYPESCOORDONNEES = new TYPESCOORDONNEES();
            $typescoordonnees = $TYPESCOORDONNEES->lister();
            $patients = $PATIENTS->lister_coordonnees($parametres['code']);
            if ($patients){
                $nb= 2;
                $i= 1;
                foreach ($patients as $patient) {
                    ?>
                    <div class="col-sm-6" id="div_type_coordonnee_<?= $i ?>>">
                        <label for="type_coordonnee_<?= $i ?>_input" class="form-label">Types coordonnees</label>
                        <select class="form-select form-select-sm type_coordonnee"  name="names" id="type_coordonnee_<?= $i ?>_input" aria-label=".form-select-sm" aria-describedby="type_coordonnee_<?= $i ?>_input">
                            <option value="">Sélectionnez la lettre clé</option>
                            <?php
                            foreach ($typescoordonnees AS $typecoordonnee){ ?>
                                <option value="<?= $typecoordonnee['code'] ?>" <?php if (isset($_POST['code']) && $typecoordonnee['code'] == $patient['code_type']){ echo 'selected'; } ?>><?= $typecoordonnee['libelle'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="typeCoordonneeHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm-5" id="div_valeur_coordonnee_<?= $i ?>">
                        <label for="valeur_coordonnee_<?= $i ?>_input" class="form-label">Valeur</label>
                        <input type="text" name="name" placeholder="Coefficient" id="valeur_coordonnee_<?= $i ?>_input"  value="<?= $patient['valeur'] ?>" class="form-control form-control-sm valeur_coordonnee" />
                    </div>
                    <?php if ($nb == 2) { ?>
                        <div class="col-sm-1">
                            <label for="button" class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="button" name="add" id="plus_champs_coordonnees" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                    <?php }else{?>

                        <div class="col-sm-1" id="button_remove_coordonnee_<?= $i ?>">
                            <label for="button" class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="button" name="remove" id="<?= $i ?>" class="btn btn-danger btn-sm btn_remove_coordonnee" ><i class="bi bi-dash"></i></button>
                            </div>
                        </div>
                        <?php
                    }
                    $nb++;
                    $i++;

                }
            }else{ ?>
                <div class="col-sm-9" id="div_type_coordonnee_'+i+'">
                    <label for="code_lettre_cle_1_input" class="form-label">Lettre clé</label>
                    <select class="form-select form-select-sm code_lettre"  name="names" id="code_lettre_cle_1_input" aria-label=".form-select-sm" aria-describedby="code_lettre_cle_1_input">
                        <option value="">Sélectionnez la lettre clé</option>
                        <?php
                        foreach ($lettres as $lettre) {
                            echo '<option value="'.$lettre['code'].'">'.$lettre['libelle'].'</option>';
                        }
                        ?>
                    </select>
                    <div id="CodeLettreHelp" class="form-text"></div>
                </div>
                <div class="col-sm-2" id="div_valeur_coordonnee_'+i+'">
                    <label for="coefficient_1_input" class="form-label">Coefficient</label>
                    <input type="text" name="name" placeholder="Coefficient" id="coefficient_1_input" class="form-control form-control-sm coefficient_lettre" />
                </div>
                <div class="col-sm-1">
                    <label for="button" class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="button" name="add" id="plus_champs_coordonnees" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
            <?php }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else{
        $json = count($parametres);
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
} ?>

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
    $('#plus_champs_coordonnees').click(function(){
        if(i <= 4) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Centre/Patients/search_types_coordonnees.php',
                type: 'post',
                data: {
                },
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $("#code_type_coordonnee_input").append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });

            $('#div_coordonnees').append(
                '<div class="col-sm-5" id="div_type_coordonnee_'+i+'">' +
                '<label for="code_type_coordonnee_'+i+'_input" class="form-label">Types coordonnees</label>' +
                '<select class="form-select form-select-sm type_coordonnee"  name="names" id="code_type_coordonnee_input" aria-label=".form-select-sm" aria-describedby="code_type_cdoordonnee_'+i+'_input">' +
                '<option value="">Selectionner</option>' +

                '</select>' +
                '</div>' +
                '<div class="col-sm-6" id="div_valeur_coordonnee_'+i+'">' +
                '<label for="valeur_coordonnee_'+i+'_input" class="form-label">Valeur</label>' +
                '<input type="text" name="name" placeholder="Valeur" id="valeur_coordonnee_'+i+'_input" class="form-control form-control-sm valeur_coordonnee" />'
                +
                '</div>' +
                '<div class="col-sm-1" id="btn_remove_'+i+'">' +
                '<label for="button" class="form-label">&nbsp;</label>' +
                '<div class="d-grid gap-2">' +
                '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove"><i class="bi bi-dash"></i></button>' +
                '</div>' +
                '</div>');
            i++;
        }
        console.log(i);
    });
    $(document).on('click', '.btn_remove_coordonnee', function(){
        var button_id = $(this).attr("id");
        $('#div_type_coordonnee_'+button_id+'').remove();
        $('#div_valeur_coordonnee_'+button_id+'').remove();
        $('#button_remove_coordonnee_'+button_id+'').remove();
        i--;
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
</script>


