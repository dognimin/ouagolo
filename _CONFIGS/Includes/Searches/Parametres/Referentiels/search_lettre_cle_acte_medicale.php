<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);

                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $PATHOLOGIES = new ACTESMEDICAUX();
            $lettres = $PATHOLOGIES->lister_lettres_cles();
                $coeffients = $PATHOLOGIES->lister_coefficient($parametres['code']);
                  if ($coeffients){
               $nb= 2;
                foreach ($coeffients as $coeffient) {
           ?>
                    <div class="col-sm-9" id="div_lettre_cle_1">
                        <label for="code_lettre_cle_1_input" class="form-label">Lettre clé</label>
                        <select class="form-select form-select-sm code_lettre"  name="names" id="code_lettre_cle_1_input" aria-label=".form-select-sm" aria-describedby="code_lettre_cle_1_input">
                            <option value="">Sélectionnez la lettre clé</option>
                            <?php
                            foreach ($lettres AS $lettre){ ?>
                                <option value="<?= $lettre['code'] ?>" <?php if (isset($_POST['code']) && $coeffient['code_cle'] == $lettre['code']){ echo 'selected'; } ?>><?= $lettre['libelle'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="CodeLettreHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm-2" id="div_coefficient_1">
                        <label for="coefficient_<?= $nb ?>_input" class="form-label">Coefficient</label>
                        <input type="text" name="name" placeholder="Coefficient" id="coefficient_<?= $nb ?>_input"  value="<?= $coeffient['valeur'] ?>" class="form-control form-control-sm coefficient_lettre" />
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
                                <button type="button" name="remove" id="<?= $nb ?>" class="btn btn-danger btn-sm btn_remove" disabled="true"><i class="bi bi-dash"></i></button>
                            </div>
                        </div>
                        <?php
                    }
                    $nb++;
                }
                  }else{ ?>
            <div class="col-sm-9" id="div_lettre_cle_1">
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
            <div class="col-sm-2" id="div_coefficient_1">
                <label for="coefficient_1_input" class="form-label">Coefficient</label>
                <input type="text" name="name" placeholder="Coefficient" id="coefficient_1_input" class="form-control form-control-sm coefficient_lettre" />
            </div>
            <div class="col-sm-1">
                <label for="button" class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="button" name="add" id="plus_champs" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
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
