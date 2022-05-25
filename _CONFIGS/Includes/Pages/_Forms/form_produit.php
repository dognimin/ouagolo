<p id="p_produit_resultats"></p>
<form id="form_produit">
    <div class="row">
        <div class="col-sm">
            <label for="code_input" class="form-label">Code du produit</label>
            <input type="text" class="form-control form-control-sm" id="code_input" placeholder="Code du produit" aria-describedby="codeHelp" autocomplete="off" maxlength="20">
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nature_input" class="form-label"><strong class="text-primary">Nature</strong></label>
            <select class="form-select form-select-sm" id="nature_input"  aria-label=".form-select-sm" aria-describedby="natureHelp">
                <option value="">Sélectionnez</option>
                <option value="MED">MÉDICAMENT</option>
                <option value="AUT">AUTRE</option>
            </select>
            <div id="natureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="description_input" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" id="description_input" maxlength="100" placeholder="Description" aria-describedby="descriptionHelp" autocomplete="off"></textarea>
            <div id="descriptionHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="pays_input" class="form-label"></label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="produit_perissable_input">
                <label class="form-check-label" for="produit_perissable_input">Périssable</label>
            </div>
        </div>
        <div class="col-sm">
            <label class="form-label"></label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="produit_achat_input">
                <label class="form-check-label" for="produit_achat_input">Achat</label>
            </div>
        </div>
        <div class="col-sm">
            <label for="pays_input" class="form-label"></label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="produit_vente_input">
                <label class="form-check-label" for="produit_vente_input">Vente</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <label for="alert_limite_stock_input" class="form-label"><strong class="text-primary">Alert limite stock</strong></label>
            <input type="number" class="form-control form-control-sm" id="alert_limite_stock_input" min="5" value="5" placeholder="Limite stock pour alerte" aria-describedby="alertLimiteStockHelp" autocomplete="off">
            <div id="alertLimiteStockHelp" class="form-text"></div>
        </div>
        <div class="col-sm-4" id="div_prix_achat">
            <label for="prix_achat_input" class="form-label"><strong class="text-primary">Prix d'achat</strong></label>
            <input type="text" class="form-control form-control-sm" id="prix_achat_input" placeholder="Prix d'achat" aria-describedby="prixAchatHelp" autocomplete="off">
            <div id="prixAchatHelp" class="form-text"></div>
        </div>
        <div class="col-sm-4" id="div_prix_vente">
            <label for="prix_vente_input" class="form-label"><strong class="text-primary">Prix de vente</strong></label>
            <input type="text" class="form-control form-control-sm" id="prix_vente_input" placeholder="Prix de vente" aria-describedby="prixVenteHelp" autocomplete="off">
            <div id="prixVenteHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i
                            class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
