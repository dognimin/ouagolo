<p id="p_college_produit_resultats"></p>
<form id="form_college_produit">
    <div class="row">
        <div class="col-sm">
            <label for="code_produit_input" class="form-label"><strong class="text-primary">Produit</strong></label>
            <select class="form-select form-select-sm" id="code_produit_input" aria-label=".form-select-sm" aria-describedby="codeProduitHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($produits as $produit) {
                    ?>
                    <option value="<?= $produit['code']; ?>" <?= ($college_produit && $produit['code'] == $college_produit['code_produit'])? 'selected': null;?>><?= $produit['libelle']; ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codeProduitHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_produit_enregistrer" class="btn btn-primary btn-sm"><i
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