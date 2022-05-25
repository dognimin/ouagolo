<form id="form_search_collectivites">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_secteur_collectivite_input" class="form-label">Secteur d'activité</label>
            <select class="form-select form-select-sm" id="code_secteur_collectivite_input" aria-label=".form-select-sm" aria-describedby="codeSecteurCollectiviteHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($collectivites_secteurs AS $collectivite_secteur){ ?>
                    <option value="<?= $collectivite_secteur['code'] ?>"><?= $collectivite_secteur['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="codeSecteurCollectiviteHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_collectivite_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_collectivite_input" maxlength="9" placeholder="Code" aria-describedby="codeCollectiviteHelp" autocomplete="off">
            <div id="codeCollectiviteHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_collectivite_input" class="form-label">Raison sociale</label>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_collectivite_input" maxlength="100" placeholder="Raison sociale" aria-describedby="raisonSocialeCollectiviteHelp" autocomplete="off">
            <div id="raisonSocialeCollectiviteHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>