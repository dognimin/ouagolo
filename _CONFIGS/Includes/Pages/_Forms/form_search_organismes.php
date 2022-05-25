<form id="form_search_organismes">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_organisme_input" class="form-label">Code organisme</label>
            <input type="text" class="form-control form-control-sm" id="code_organisme_input" maxlength="8" placeholder="Code de l'organisme" aria-describedby="codeOrganismeHelp" autocomplete="off">
            <div id="codeOrganismeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_rgb_organisme_input" class="form-label">Code RGB</label>
            <input type="text" class="form-control form-control-sm" id="code_rgb_organisme_input" maxlength="8" placeholder="Code RGB" aria-describedby="codeRGBOrganismeHelp" autocomplete="off">
            <div id="codeRGBOrganismeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_organisme_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_organisme_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleOrganismeHelp" autocomplete="off">
            <div id="libelleOrganismeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="code_pays_input" class="form-label">Pays</label>
            <select class="form-select form-select-sm" id="code_pays_input" aria-label=".form-select-sm" aria-describedby="codePaysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($pays_organismes as $pays) {
                    echo '<option value="'.$pays['code_pays'].'">'.$pays['nom_pays'].'</option>';
                }
                ?>
            </select>
            <div id="codePaysHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm" title="Rechercher"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>