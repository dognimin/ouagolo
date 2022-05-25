<p id="p_utilisateur_groupe_sanguin_resultats"></p>
<form id="form_utilisateur_groupe_sanguin">
    <div class="row">
        <div class="col">
            <label for="code_groupe_sanguin_input" class="form-label">Groupe Sanguin</label>
            <select class="form-select form-select-sm" id="code_groupe_sanguin_input"  aria-label=".form-select-sm" aria-describedby="groupeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($groupes_sanguins AS $groupe_sanguin){ ?>
                    <option value="<?= $groupe_sanguin['code'] ?>" <?php if (isset($_POST['uid']) && $user['groupe_sanguin'] == $groupe_sanguin['code']){ echo 'selected'; } ?>><?= $groupe_sanguin['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="groupeHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="code_rhesus_input" class="form-label">Rhesus Sanguin</label>
            <select class="form-select form-select-sm" id="code_rhesus_input"  aria-label=".form-select-sm" aria-describedby="rhesusHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($rhesuss AS $rhesus){ ?>
                    <option value="<?= $rhesus['code'] ?>" <?php if (isset($_POST['uid']) && $user['code_rhesus'] == $rhesus['code']){ echo 'selected'; } ?>><?= $rhesus['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="rhesusHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3 d-grid">
                    <input type="hidden" id="id_user_input" value="<?= $user['id_user'];?>">
                    <button type="submit" id="button_groupe_sanguin_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" id="button_user_groupe_sanguin_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>

    </div>
</form>