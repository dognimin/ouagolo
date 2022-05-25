<p id="p_securite_compte_resultats"></p>
<form id="form_securite_compte">
    <div class="mb-3 row">
        <label for="nombre_essais_input" class="col-sm-9 col-form-label">Nombre d'echec d'authentification avant vérouillage</label>
        <div class="col-sm-3">
            <select class="form-select form-select-sm" aria-label=".form-select-sm" aria-describedby="nombreEssaisHelp" id="nombre_essais_input">
                <?php
                for ($l = 3; $l <= 10; $l++) {
                    ?>
                    <option value="<?= $l; ?>" <?php if($securite['nombre_essais'] == $l){echo 'selected';} ?>><?= $l; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="duree_mot_de_passe_input" class="col-sm-9 col-form-label">Durée de vie du mot de passe</label>
        <div class="col-sm-3">
            <select class="form-select form-select-sm" aria-label=".form-select-sm" aria-describedby="dureeMotDePasseHelp" id="duree_mot_de_passe_input">
                <?php
                for ($dmdp = 30; $dmdp <= 365; $dmdp++) {
                    ?>
                    <option value="<?= $dmdp; ?>" <?php if($securite['duree_mot_de_passe'] == $dmdp){echo 'selected';} ?>><?= $dmdp; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="minuscules_input" class="col-sm-9 col-form-label">Activer l'authentification à double facteur</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="doubleAuthentificationHelp" id="double_authentification_input" <?php if($securite['double_authentification'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="doubleAuthentificationHelp"></label>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="autoriser_sms_input" class="col-sm-9 col-form-label">Envoi d'SMS</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="autoriserSmsHelp" id="autoriser_sms_input" <?php if($securite['autoriser_sms'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="autoriserSmsHelp"></label>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="autoriser_email_input" class="col-sm-9 col-form-label">Envoi d'Email</label>
        <div class="col-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" aria-describedby="autoriserEmailHelp" id="autoriser_email_input" <?php if($securite['autoriser_email'] == 1){echo 'checked';} ?>>
                <label class="form-check-label" for="autoriserEmailHelp"></label>
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