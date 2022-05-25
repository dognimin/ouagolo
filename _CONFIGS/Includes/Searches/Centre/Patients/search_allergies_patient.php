<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);

            require_once "../../../../Classes/ALLERGIES.php";
            require_once "../../../../Classes/PATIENTS.php";
            $PATIENTS = new PATIENTS();
            $ALLERGIES = new ALLERGIES();
            $allergies = $ALLERGIES->lister();
            $patients = $PATIENTS->lister_allergies($parametres['code']);
            if ($patients){
                $nb= 2;
                $i= 1;
                foreach ($patients as $patient) {
                    ?>
                    <div class="col-sm-11" id="div_allergie">
                        <select class="form-select form-select-sm allergie"  name="names" id="allergie_<?= $i ?>_input" aria-label=".form-select-sm" aria-describedby="allergie_<?= $i ?>_input">
                            <option value="">Sélectionnez </option>
                            <?php
                            foreach ($allergies AS $allergie){ ?>
                                <option value="<?= $allergie['code'] ?>" <?php if (isset($_POST['code']) && $allergie['code'] == $patient['code_allergie']){ echo 'selected'; } ?>><?= $allergie['libelle'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="allergieHelp" class="form-text"></div>
                    </div>
                    <?php if ($nb == 2) { ?>
                        <div class="col-sm-1">
                            <div class="d-grid gap-2">
                                <button type="button" name="add" id="plus_champs_allergies" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                    <?php }else{?>

                        <div class="col-sm-1" id="button_remove_<?= $nb ?>">
                            <div class="d-grid gap-2">
                                <button type="button" name="remove" id="<?= $nb ?>" class="btn btn-danger btn-sm btn_remove" disabled="true"><i class="bi bi-dash"></i></button>
                            </div>
                        </div>
                        <?php
                    }
                    $nb++;
                    $i++;
                }
            }else{ ?>
                <div class="col-md-11">
                    <select class="form-select form-select-sm allergie" id="allergie_1_input" aria-label=".form-select-sm" aria-describedby="allergieHelp">
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($allergies AS $allergie){ ?>
                            <option value="<?= $allergie['code'] ?>"><?= $allergie['libelle'] ?></option>
                        <?php }  ?>
                    </select>
                    <div id="allergieHelp" class="form-text"></div>
                </div>
                <div class="col-md-1">

                    <div class="d-grid gap-2">
                        <button type="button" name="add" id="plus_champs_allergies" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
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
}
 ?>
