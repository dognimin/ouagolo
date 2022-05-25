<p id="p_organisme_produit_resultats"></p>
<form id="form_organisme_produit">
    <div class="row">
        <div class="col-sm-6">
            <label for="code_input" class="form-label">Code du produit</label>
            <input type="text" class="form-control form-control-sm" id="code_input" value="<?= isset($produit)? $produit['code']: null;?>" placeholder="Code du produit" aria-describedby="codeHelp" autocomplete="off" maxlength="10" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé du produit</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" value="<?= isset($produit)? $produit['libelle']: null;?>" placeholder="Libellé du produit" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="description_input" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" id="description_input" maxlength="100" placeholder="Description" aria-describedby="descriptionHelp" autocomplete="off"><?= isset($produit)? $produit['description']: null;?></textarea>
            <div id="descriptionHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_panier_soins_input" class="form-label"><strong class="text-primary">Panier de soins</strong></label>
            <select class="form-select form-select-sm" id="code_panier_soins_input" aria-label=".form-select-sm" aria-describedby="codePanierSoinsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($paniers as $panier) {
                    ?>
                    <option value="<?= $panier['code']; ?>" <?= (isset($produit) && $produit['code_panier_soins'] === $panier['code'])? 'selected': null;?>><?= $panier['libelle']; ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codePanierSoinsHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_reseau_soins_input" class="form-label"><strong class="text-primary">Réseau de soins</strong></label>
            <select class="form-select form-select-sm" id="code_reseau_soins_input" aria-label=".form-select-sm" aria-describedby="codeReseauSoinsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($reseaux as $reseau) {
                    ?>
                    <option value="<?= $reseau['code']; ?>" <?= (isset($produit) && $produit['code_reseau_soins'] === $reseau['code'])? 'selected': null;?>><?= $reseau['libelle']; ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codeReseauSoinsHelp" class="form-text"></div>
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