<form id="form_search_ets_bordereaux">
    <div class="row">
        <div class="col-sm-2">
            <label for="date_debut_search_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_search_input" placeholder="Date début" value="<?= date('d/m/Y', strtotime('-1 WEEK', time()));?>" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutSearchHelp>" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_fin_search_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_search_input" placeholder="Date fin" value="<?= date('d/m/Y', time());?>" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_type_facture_search_input" class="form-label">Type facture</label>
            <select class="form-select form-select-sm" id="code_type_facture_search_input" aria-label=".form-select-sm" aria-describedby="codeTypeFactureSearchHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeTypeFactureSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_organisme_search_input" class="form-label">Organisme</label>
            <select class="form-select form-select-sm" id="code_organisme_search_input" aria-label=".form-select-sm" aria-describedby="codeOrganismeSearchHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeOrganismeSearchHelp" class="form-text"></div>
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
