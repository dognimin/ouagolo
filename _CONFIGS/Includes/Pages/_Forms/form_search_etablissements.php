<form id="form_search_etablissements">
    <div class="row">
        <div class="col-sm-2">
            <label for="niveau_input" class="form-label">niveau saniatire</label>
            <select class="form-select form-select-sm" id="niveau_input"  aria-label=".form-select-sm" aria-describedby="niveauHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($niveaux AS $niveau){ ?>
                    <option value="<?= $niveau['code'] ?>"> <?= $niveau['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="niveauHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="type_input" class="form-label">Type</label>
            <select class="form-select form-select-sm" id="type_input"  aria-label=".form-select-sm" aria-describedby="typeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types AS $type){ ?>
                    <option value="<?= $type['code'] ?>"> <?= $type['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="typeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="9" placeholder="Code" aria-describedby="codeHelp" autocomplete="off">
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_input" class="form-label">Raison sociale</label>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_input" maxlength="100" placeholder="Raison sociale" aria-describedby="raisonSocialeHelp" autocomplete="off">
            <div id="raisonSocialeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button>
                </div>

            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>