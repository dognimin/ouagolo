<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);

            require_once "../../../../Classes/TYPESPERSONNES.php";
            require_once "../../../../Classes/PATIENTS.php";
            $PATIENTS = new PATIENTS();
            $TYPESPERSONNES = new TYPESPERSONNES();
            $types_personnes = $TYPESPERSONNES->lister();
            $patients = $PATIENTS->lister_ecu($parametres['code']);
            if ($patients){
                $nb= 2;
                $i= 1;
                foreach ($patients as $patient) {
                    ?>
                    <br>
                    <hr>

                    <div class="col-sm-6" id="div_type_ecu_<?= $i ?>>">
                        <label for="type_ecu_<?= $i ?>_input" class="form-label">Qui es-ce ?</label>
                        <select class="form-select form-select-sm type_ecu"  name="names" id="type_ecu" aria-label=".form-select-sm" aria-describedby="type_ecu_<?= $i ?>_input">
                            <option value="">Sélectionnez </option>
                            <?php
                            foreach ($types_personnes AS $type_personne){ ?>
                                <option value="<?= $type_personne['code'] ?>" <?php if (isset($_POST['code']) && $type_personne['code'] == $patient['type_code']){ echo 'selected'; } ?>><?= $type_personne['libelle'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="typeEcuHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm-5" id="div_numero_ecu_<?= $i ?>">
                        <label for="numero_ecu_<?= $i ?>_input" class="form-label">Numéro</label>
                        <input type="text" name="name" placeholder="Coefficient" id="numero_ecu_<?= $nb ?>_input"  value="<?= $patient['telephone'] ?>" class="form-control form-control-sm numero_ecu" />
                    </div>
                    <div class="col-sm-6" id="div_nume_ecu_<?= $i ?>">
                        <label for="nom_ecu_<?= $i ?>_input" class="form-label">Nom</label>
                        <input type="text" name="name" placeholder="Coefficient" id="nom_ecu_<?= $i ?>_input"  value="<?= $patient['nom_ecu'] ?>" class="form-control form-control-sm nom_ecu" />
                    </div>
                    <div class="col-sm-5" id="div_prenoms_ecu_<?= $i ?>">
                        <label for="prenoms_ecu_<?= $i ?>_input" class="form-label">Prénom(s)</label>
                        <input type="text" name="name" placeholder="Prénom(s)" id="prenoms_ecu_<?= $i ?>_input"  value="<?= $patient['prenoms_ecu'] ?>" class="form-control form-control-sm prenoms_ecu" />
                    </div>
                    <?php if ($nb == 2) { ?>
                        <div class="col-sm-1">
                            <label for="button" class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="button" name="add" id="plus_champs" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                    <?php }else{?>

                        <div class="col-sm-1" id="button_remove_<?= $nb ?>">
                            <label for="button" class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="button" name="remove" id="<?= $nb ?>" class="btn btn-danger btn-sm btn_remove" ><i class="bi bi-dash"></i></button>
                            </div>
                        </div>
                        <?php
                    }
                    $nb++;
                    $i++;

                }
            }else{ ?>
                <div class="col-md-5" id="div_type_ecu_1">
                    <label for="type_ecu_1_input" class="form-label">Qui es-ce ?</label>
                    <select class="form-select form-select-sm type_ecu" id="type_ecu_1_input" aria-label=".form-select-sm" aria-describedby="typeEcuHelp">
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($types_ecu AS $type_ecu){ ?>
                            <option value="<?= $type_ecu['code'] ?>"><?= $type_ecu['libelle'] ?></option>
                        <?php }  ?>
                    </select>
                    <div id="typeEcuHelp" class="form-text"></div>
                </div>
                <div class="col-md-6" id="div_numero_ecu_1">
                    <label for="numero_ecu_1_input" class="form-label">Numéro</label>
                    <input type="text" name="name" placeholder="Numéro" id="numero_ecu_1_input" class="form-control form-control-sm numero_ecu" />
                    <div id="numeroEcuHelp" class="form-text"></div>
                </div> <div class="col-md-1">
                    <label for="button" class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="button" name="add" id="plus_champs_ecu" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-5" id="div_nume_ecu_1">
                    <label for="nom_ecu_1_input" class="form-label">Nom</label>
                    <input type="text" name="name" placeholder="Nom" id="nom_ecu_1_input" class="form-control form-control-sm nom_ecu" />
                    <div id="numeroEcuHelp" class="form-text"></div>
                </div>
                <div class="col-md-6" id="div_prenoms_ecu_1">
                    <label for="prenoms_ecu_1_input" class="form-label">Prénom(s)</label>
                    <input type="text" name="name" placeholder="Prénoms" id="prenoms_ecu_1_input" class="form-control form-control-sm prenoms_ecu" />
                    <div id="numeroEcuHelp" class="form-text"></div>
                </div>
                <div class="col-md-1">

                    <div class="d-grid gap-2">
                        <button type="button" name="add" id="plus_champs_ecu" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
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




