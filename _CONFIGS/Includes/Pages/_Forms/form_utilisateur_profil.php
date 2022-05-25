<p id="p_utilisateur_profil_resultats"></p>
<form id="form_utilisateur_profil">
    <div class="row">
        <div class="col">
            <label for="code_profil_input" class="form-label">Profil</label>
            <select class="form-select form-select-sm" id="code_profil_input" aria-label=".form-select-sm"
                    aria-describedby="profilsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($profils as $profil_utilisateur) {
                    ?>
                    <option value="<?= $profil_utilisateur['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['code_profil'] == $profil_utilisateur['code']) {
                        echo 'selected';
                                   } ?>><?= $profil_utilisateur['libelle'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="profilsHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row" id="div_user_etablissement" <?php if (!in_array($user_profil['code_profil'], $tableau_profil_ets)) {
        echo 'hidden';
                                                 } ?>>
        <div class="col-sm-12">
            <label for="code_etablissement_input" class="form-label">Code établissement</label>
            <input type="text" class="form-control form-control-sm" id="code_etablissement_input" value="<?= $utilisateur_ets?$utilisateur_ets['code_etablissement']: null;?>" maxlength="9" placeholder="Code" aria-describedby="codeEtabHelp" autocomplete="off">
        </div>
        <div class="col-sm-12">
            <label for="raison_sociale_etablissement_input" class="form-label">Raison sociale</label>
            <textarea class="form-control form-control-sm" id="raison_sociale_etablissement_input" placeholder="Raison sociale" aria-describedby="raisonSocialeEtabHelp" autocomplete="off" readonly><?= $utilisateur_ets? $utilisateur_ets['raison_sociale']: null;?></textarea>
        </div>
    </div>
    <div class="row" id="div_user_organisme" <?= (!in_array($user_profil['code_profil'], $tableau_profil_organisme))? 'hidden': null;?>>
        <div class="col-sm-12">
            <label for="code_organisme_input" class="form-label">Code organisme</label>
            <input type="text" class="form-control form-control-sm" id="code_organisme_input" value="<?= $utilisateur_organisme? $utilisateur_organisme['code_organisme']: null;?>" maxlength="8" placeholder="Code" aria-describedby="codeOrganismeHelp" autocomplete="off">
        </div>
        <div class="col-sm-12">
            <label for="libelle_organisme_input" class="form-label">Libellé</label>
            <textarea class="form-control form-control-sm" id="libelle_organisme_input" placeholder="Raison sociale" aria-describedby="libelleOrganismeHelp" autocomplete="off" readonly><?= $utilisateur_organisme? $utilisateur_organisme['libelle']: null; ?></textarea>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_utilisateur_profil" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if (isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-md-6 d-grid">
                        <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>
