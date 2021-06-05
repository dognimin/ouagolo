<p id="p_utilisateur_profil_resultats"></p>
<form id="form_utilisateur_profil">
    <div class="row">
        <div class="col">
            <label for="profils_input" class="form-label">Profil</label>
            <select class="form-select form-select-sm" id="profils_input"  aria-label=".form-select-sm" aria-describedby="profilsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($profils AS $profil){ ?>
                    <option value="<?= $profil['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['code_profil_utilisateur'] == $profil['code']){ echo 'selected'; } ?>><?= $profil['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="profilsHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row" id="code_etablissement">
        <?php if ($utilisateur['code_profil_utilisateur'] == 'CSRESP'){ ?>
        <div class="col-sm" id="">
            <label for="code_etablissement_input" class="form-label">Code établissement</label>
            <input type="text" class="form-control form-control-sm" id="code_etablissement_input" value="<?= $etablissement_responsable['code_etablissement']?>" maxlength="9" placeholder="Code" aria-describedby="codeEtabHelp" autocomplete="off">
            </div>
        <div>
            <div class="col-sm" id="">
                <label for="raison_sociale_etablissement_input" class="form-label">Raison sociale</label>
                <textarea type="text" class="form-control form-control-sm" id="raison_sociale_etablissement_input" placeholder="Raison sociale" aria-describedby="raisonSocialeEtabHelp" autocomplete="off" disabled="true">
                    <?= $etablissement_responsable['raison_sociale']; ?>
                </textarea>
                </div>
            </div>
        <?php }elseif ($utilisateur['code_profil_utilisateur'] == 'CSAGNT') { ?>
        <div class="col-sm" id="">
            <label for="code_etablissement_input" class="form-label">Code établissement</label>
            <input type="text" class="form-control form-control-sm" id="code_etablissement_input" value="<?= $etablissement_agent['code_etablissement']; ?>" maxlength="9" placeholder="Code" aria-describedby="codeEtabHelp" autocomplete="off">
        </div>
        <div>
            <div class="col-sm" id="">
                <label for="raison_sociale_etablissement_input" class="form-label">Raison sociale</label>
                <textarea type="text" class="form-control form-control-sm" id="raison_sociale_etablissement_input" placeholder="Raison sociale" aria-describedby="raisonSocialeEtabHelp" autocomplete="off" disabled="true">
                    <?= $etablissement_agent['raison_sociale']; ?>
                </textarea>
            </div>
        </div>
        <?php } ?>
    </div>
    <div id="codeEtabHelp" class="form-text"></div>
    <div id="div_resultat_etablissement" class="form-text">

    </div>

    <hr />
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_utilisateur_profil" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
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