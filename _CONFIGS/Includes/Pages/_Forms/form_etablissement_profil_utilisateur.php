<p id="p_etablissement_profil_utilisateur_resultats"></p>
<form id="form_etablissement_profil_utilisateur">
    <div class="row">
        <div class="col-sm">
            <label for="code_etablissement_profil_input" class="form-label"><strong class="text-primary">Profil utilisateur</strong></label>
            <select class="form-select form-select-sm" id="code_etablissement_profil_input"  aria-label=".form-select-sm" aria-describedby="codeEtablissementProfilHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($etablissement_profils as $etablissement_profil) {
                    ?>
                    <option value="<?= $etablissement_profil['code'];?>" <?= $utilisateur_habilitations && $utilisateur_habilitations['code_profil'] === $etablissement_profil['code']? 'selected': null;?>><?= $etablissement_profil['libelle'];?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codeEtablissementProfilHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm d-grid">
            <button type="submit" id="button_profil_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
