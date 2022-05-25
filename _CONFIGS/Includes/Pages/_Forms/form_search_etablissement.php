<form id="form_search_etablissement">
    <div class="row">
        <div class="col-sm-3">
            <label for="type_input" class="form-label">Type</label>
            <select class="form-select form-select-sm" id="type_input"  aria-label=".form-select-sm" aria-describedby="typeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types_ets AS $type_ets){ ?>
                    <option value="<?= $type_ets['code'] ?>"> <?= $type_ets['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="typeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="niveau_input" class="form-label">niveau saniatire</label>
            <select class="form-select form-select-sm" id="niveau_input"  aria-label=".form-select-sm" aria-describedby="niveauHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($niveaux_ets AS $niveau_ets){ ?>
                    <option value="<?= $niveau_ets['code'] ?>"> <?= $niveau_ets['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="niveauHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_search_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_search_input" maxlength="9" placeholder="Code" aria-describedby="codeSearchHelp" autocomplete="off">
            <div id="codeSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_search_input" class="form-label">Raison sociale</label>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_search_input" maxlength="100" placeholder="Raison sociale" aria-describedby="raisonSocialeSearchHelp" autocomplete="off">
            <div id="raisonSocialeSearchHelp" class="form-text"></div>
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