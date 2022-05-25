<form id="form_search_patients">
    <div class="row">
        <div class="col-sm-2">
            <label for="num_secu_search_input" class="form-label">Numéro Sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_search_input" maxlength="13" placeholder="Numéro Sécu" aria-describedby="numSecuSearchHelp" autocomplete="off">
            <div id="numSecuSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="nip_search_input" class="form-label">NIP</label>
            <input type="text" class="form-control form-control-sm" id="nip_search_input" maxlength="16" placeholder="Numéro d'identification personnel" aria-describedby="nipSearchHelp" autocomplete="off">
            <div id="nipSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_prenom_search_input" class="form-label">Nom & prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="nom_prenom_search_input" maxlength="100" placeholder="Nom & prénom(s)" aria-describedby="nomPrenomsSearchHelp" autocomplete="off">
            <div id="nomPrenomsSearchHelp" class="form-text"></div>
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
