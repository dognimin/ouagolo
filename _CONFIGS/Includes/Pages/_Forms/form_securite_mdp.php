<p id="p_securite_mdp_resultats"></p>
<form id="form_securite_mdp">
    <div class="mb-3 row">
        <label for="longueur_minimale_input" class="col-sm-9 col-form-label">Longueur minimale du mot de passe</label>
        <div class="col-sm-3">
            <select class="form-select form-select-sm" aria-label=".form-select-sm" aria-describedby="longueurMinimaleHelp" id="longueur_minimale_input">
                <option value="">N/A</option>
                <?php
                for ($l = 6; $l <= 12; $l++) {
                    ?>
                    <option value="<?= $l; ?>" <?php if($securite['longueur_minimale'] == $l){echo 'selected';} ?>><?= $l; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="caracteres_speciaux_input" class="col-sm-9 col-form-label">Exiger les caractères spéciaux</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="caracteresSpeciauxHelp" id="caracteres_speciaux_input" <?php if($securite['caracteres_speciaux'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="caracteresSpeciauxHelp"></label>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="minuscules_input" class="col-sm-9 col-form-label">Exiger les miniscules</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="minusculesHelp" id="minuscules_input" <?php if($securite['minuscules'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="minusculesHelp"></label>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="majuscules_input" class="col-sm-9 col-form-label">Exiger les majuscules</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="majusculesHelp" id="majuscules_input" <?php if($securite['majuscules'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="majusculesHelp"></label>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="chiffres_input" class="col-sm-9 col-form-label">Exiger les chiffres</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="chiffresHelp" id="chiffres_input" <?php if($securite['chiffres'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="chiffresHelp"></label>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm d-grid">
        <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
    </div>
        <div class="col-sm d-grid">
        <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
    </div>
    </div>


</form>