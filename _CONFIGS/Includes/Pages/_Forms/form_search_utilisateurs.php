<form id="form_search_utilisateurs">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_profil_search_input" class="form-label">Profil utilisateur</label>
            <select class="form-select form-select-sm" id="code_profil_search_input" aria-label=".form-select-sm" aria-describedby="codeProfilSearchHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($profil_utilisateurs AS $profil_utilisateur){ ?>
                    <option value="<?= $profil_utilisateur['code'] ?>"><?= $profil_utilisateur['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="codeProfilSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="num_secu_input" class="form-label">Numéro Sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" maxlength="20" placeholder="Numéro Sécu" aria-describedby="numSecuHelp" autocomplete="off">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="email_search_input" class="form-label">Email</label>
            <input type="text" class="form-control form-control-sm" id="email_search_input" maxlength="100" placeholder="Email" aria-describedby="emailSearchHelp" autocomplete="off">
            <div id="emailSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_prenom_input" class="form-label">Nom & prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="nom_prenom_input" maxlength="100" placeholder="Nom & prénom(s)" aria-describedby="nomPrenomsHelp" autocomplete="off">
            <div id="nomPrenomsHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm" title="Recherche"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>