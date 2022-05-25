<p id="p_utilisateur_sante_resultats"></p>
<form id="form_utilisateur_sante">
    <div class="row">
        <div class="col">
            <label for="groupe_input" class="form-label">Groupe Sanguin</label>
            <select class="form-select form-select-sm" id="groupe_input"  aria-label=".form-select-sm" aria-describedby="groupeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($groupes_sanguins AS $groupe_sanguin){ ?>
                    <option value="<?= $groupe_sanguin['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['groupe_sanguin_code'] == $groupe_sanguin['code']){ echo 'selected'; } ?>><?= $groupe_sanguin['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="groupeHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="rhesus_input" class="form-label">Rhesus Sanguin</label>
            <select class="form-select form-select-sm" id="rhesus_input"  aria-label=".form-select-sm" aria-describedby="rhesusHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($Rhesus AS $rhesus){ ?>
                    <option value="<?= $rhesus['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['rhesus_code'] == $rhesus['code']){ echo 'selected'; } ?>><?= $rhesus['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="rhesusHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3 d-grid">
                    <button type="submit" id="button_utilisateur_profil" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if(isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-sm-3 d-grid">
                        <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>