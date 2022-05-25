<p id="p_utilisateur_type_etablissements_resultats"></p>
<form id="form_etablissement_type">
    <div class="row">
        <div class="col">
            <label for="code_type_etablissement_input" class="form-label">Types d'etablissements</label>
            <select class="form-select form-select-sm" id="code_type_etablissement_input"  aria-label=".form-select-sm" aria-describedby="profilsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types AS $type){ ?>
                    <option value="<?= $type['code'] ?>" <?php if (isset($_POST['code']) && $etablissement['type'] == $type['code']){ echo 'selected'; } ?>><?= $type['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="typeEtablissementHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_etablissement_type" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if(isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-md-6 d-grid">
                        <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>