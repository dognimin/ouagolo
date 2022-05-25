<form id="form_search_dossiers" style="margin: 10px;">
    <div class="row">
        <div class="col-sm">
            <input type="text" class="form-control form-control-sm date" id="date_debut_search_input" aria-label="date_debut_search_input" placeholder="Date début" value="<?= date('01/01/Y', time())?>" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutSearchHelp>" class="form-text"></div>
        </div>
        <div class="col-sm">
            <input type="text" class="form-control form-control-sm date" id="date_fin_search_input" aria-label="date_fin_search_input" placeholder="Date fin" value="<?= date('d/m/Y', time())?>" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="button" name="search" id="btn_export" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>