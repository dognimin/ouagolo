<p id="p_commande_resultats"></p>
<form id="form_commande">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code de la commande</label>
            <input type="text" class="form-control form-control-sm" id="code_input" placeholder="Code de la commande" aria-describedby="codeHelp" autocomplete="off" maxlength="20" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_fournisseur_input" class="form-label"><strong class="text-primary">Fournisseur</strong></label>
            <select class="form-select form-select-sm" id="code_fournisseur_input"  aria-label=".form-select-sm" aria-describedby="codeFournisseurHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($fournisseurs as $fournisseur) {
                    echo '<option value="'.$fournisseur['code'].'">'.$fournisseur['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeFournisseurHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-3">
            <label for="code_produit_input" class="form-label">Code du produit</label>
            <input type="text" class="form-control form-control-sm" id="code_produit_input" placeholder="Code du produit" aria-describedby="codeProduitHelp" autocomplete="off" maxlength="20">
            <div id="codeProduitHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_produit_input" class="form-label">Désignation</label>
            <input type="text" class="form-control form-control-sm" id="libelle_produit_input" placeholder="Libellé du produit" aria-describedby="libelleProduitHelp" autocomplete="off" maxlength="20">
            <div id="libelleProduitHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="quantite_en_stock_input" class="form-label">Quantité en stock</label>
            <input type="text" class="form-control form-control-sm" id="quantite_en_stock_input" placeholder="Prix unitaire" aria-describedby="quantiteStockHelp" autocomplete="off" readonly>
            <div id="quantiteStockHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="prix_unitaire_input" class="form-label">Prix Unitaire</label>
            <input type="text" class="form-control form-control-sm" id="prix_unitaire_input" placeholder="Prix unitaire" value="0" aria-describedby="prixUnitaireHelp" autocomplete="off">
            <div id="prixUnitaireHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="quantite_input" class="form-label"><strong class="text-primary">Quantité</strong></label>
            <select class="form-select form-select-sm" id="quantite_input"  aria-label=".form-select-sm" aria-describedby="quantiteHelp">
                <?php
                for ($q = 1; $q < 100; $q++) {
                    echo '<option value="'.$q.'">'.$q.'</option>';
                }
                for ($q2 = 100; $q2 < 1000; $q2 += 100) {
                    echo '<option value="'.$q2.'">'.$q2.'</option>';
                }
                for ($q3 = 1000; $q3 <= 10000; $q3 += 1000) {
                    echo '<option value="'.$q3.'">'.$q3.'</option>';
                }
                ?>
            </select>
            <div id="quantiteHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="remise_input" class="form-label"><strong class="text-primary">Remise</strong></label>
            <select class="form-select form-select-sm" id="remise_input"  aria-label=".form-select-sm" aria-describedby="remiseHelp">
                <?php
                for ($r = 0; $r <= 100; $r += 5) {
                    echo '<option value="'.$r.'">'.$r.'%</option>';
                }
                ?>
            </select>
            <div id="remiseHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="montant_ht_input" class="form-label">Montant HT</label>
            <input type="text" class="form-control form-control-sm" id="montant_ht_input" placeholder="Montant" value="0" aria-describedby="montantHTHelp" autocomplete="off" readonly>
            <div id="montantHTHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <div class="row">
                <div class="col-sm d-grid">
                    <label for="" class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-success btn-sm" id="button_ajouter_produit"><i class="bi bi-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div id="div_commandes_produits">
        <p id="p_erreur_commande"></p>
        <table class="table table-sm table-hover stable-stripped table-bordered" id="table_commande_produits">
            <thead class="bg-secondary">
            <tr>
                <th style="width: 5px">#</th>
                <th style="width: 40px">CODE</th>
                <th>DESIGNATION</th>
                <th style="width: 70px">PRIX U.</th>
                <th style="width: 5px">QTE</th>
                <th style="width: 5px">-%</th>
                <th style="width: 80px">MONTANT T.</th>
                <th style="width: 5px"></th>
            </tr>
            </thead>
            <tbody id="tbody_produits"></tbody>
            <tfoot>
            <tr>
                <th colspan="6">TOTAL</th>
                <th id="th_montant_commande" class="align_right">0</th>
            </tr>
            </tfoot>
        </table>
    </div><hr />
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
