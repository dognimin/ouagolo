<form id="form_search_assures">
    <div class="row">
        <div class="col-sm-2">
            <label for="num_population_search_input" class="form-label">N° I.P</label>
            <input type="text" class="form-control form-control-sm" id="num_population_search_input" maxlength="16" placeholder="N° I.P" aria-describedby="numPopulationSearchHelp" autocomplete="off">
            <div id="numPopulationSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="num_secu_search_input" class="form-label">N° sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_search_input" maxlength="13" placeholder="N° sécu" aria-describedby="numSecuSearchHelp" autocomplete="off">
            <div id="numSecuSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_prenoms_input" class="form-label">Nom & Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="nom_prenoms_input" maxlength="80" placeholder="Nom & Prénom(s)" aria-describedby="nomPrenomsSearchHelp" autocomplete="off">
            <div id="nomPrenomsSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_collectivite_search_input" class="form-label">Collectivité / Sociétaire</label>
            <input type="hidden" id="code_collectivite_search_input">
            <input type="text" class="form-control form-control-sm" id="raison_sociale_collectivite_search_input" placeholder="Collectivite" aria-describedby="raisonSocialeCollectiviteSearchHelp" autocomplete="off">
            <div id="raisonSocialeCollectiviteSearchHelp" class="form-text"></div>
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