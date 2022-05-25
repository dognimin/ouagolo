<form id="form_search_produits">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_produit_search_input" class="form-label">Réf.</label>
            <input type="text" class="form-control form-control-sm" id="code_produit_search_input" maxlength="20" placeholder="Code produit" aria-describedby="codeProduitHelp" autocomplete="off">
            <div id="codeProduitHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_search_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_search_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="nature_search_input" class="form-label">Nature</label>
            <select class="form-select form-select-sm" id="nature_search_input"  aria-label=".form-select-sm" aria-describedby="natureHelp">
                <option value="">Sélectionnez</option>
                <option value="MED">MEDICAMENT</option>
                <option value="AUT">AUTRE</option>
            </select>
            <div id="natureHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="type_search_input" class="form-label">Type</label>
            <select class="form-select form-select-sm" id="type_search_input"  aria-label=".form-select-sm" aria-describedby="natureHelp">
                <option value="">Sélectionnez</option>
                <option value="0">Non périssable</option>
                <option value="1">Périssable</option>
            </select>
            <div id="natureHelp" class="form-text"></div>
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