<p id="p_etablissement_reception_commande_resultats"></p>
<form id="form_etablissement_reception_commande">
    <div class="row">
        <div class="col">
            <table class="table table-sm">
                <tr>
                    <td style="width: 150px">
                        <input type="text" class="form-control form-control-sm" id="code_commande_input" value="<?= $commande['code'];?>" maxlength="20" placeholder="Code" aria-describedby="codeCommandeHelp" autocomplete="off" readonly>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-sm">
                <thead class="bg-indigo text-white">
                <tr>
                    <th style="width: 150px">CODE</th>
                    <th>DESIGNATION</th>
                    <th style="width: 80px">PRIX UN.</th>
                    <th style="width: 80px">QTE CMDEE</th>
                    <th style="width: 100px">QTE RCPT</th>
                    <th style="width: 80px">MONTANT</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($produits as $produit) {
                    ?>
                    <tr>
                        <td><input type="text" aria-label="code_input" id="code_<?= $produit['code'];?>_input" class="form-control form-control-sm code_produit" value="<?= $produit['code'];?>" readonly></td>
                        <td><input type="text" aria-label="libelle_input" id="libelle_<?= $produit['code'];?>_input" class="form-control form-control-sm" value="<?= $produit['libelle'];?>" readonly></td>
                        <td><input type="text" style="text-align: right" aria-label="prix_unitaire_<?= $produit['code'];?>_input" id="prix_unitaire_<?= $produit['code'];?>_input" class="form-control form-control-sm" value="<?= $produit['prix_unitaire'];?>" readonly></td>
                        <td><input type="text" style="text-align: right" aria-label="quantite_commandee_<?= $produit['code'];?>_input" id="quantite_commandee_<?= $produit['code'];?>_input" class="form-control form-control-sm" value="<?= $produit['quantite'];?>" readonly></td>
                        <td>
                            <select class="form-select form-select-sm quantite_receptionnee" id="<?= $produit['code'];?>"  aria-label=".form-select-sm" aria-describedby="quantiteReceptionneeHelp">
                                <option value="0">0</option>
                                <?php
                                for ($q = 1; $q < 100; $q++) {
                                    ?>
                                    <option value="<?= $q;?>"<?= $produit['quantite'] == $q?'selected':'';?>><?= $q;?></option>
                                    <?php
                                }
                                for ($q2 = 100; $q2 < 1000; $q2 += 100) {
                                    ?>
                                    <option value="<?= $q2;?>"<?= $produit['quantite'] == $q2?'selected':'';?>><?= $q2;?></option>
                                    <?php
                                }
                                for ($q3 = 1000; $q3 <= 10000; $q3 += 1000) {
                                    ?>
                                    <option value="<?= $q3;?>"<?= $produit['quantite'] == $q3?'selected':'';?>><?= $q3;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" style="text-align: right" aria-label="montant_<?= $produit['code'];?>_input" id="montant_<?= $produit['code'];?>_input" class="form-control form-control-sm" value="<?= (int)($produit['prix_unitaire'] * $produit['quantite']);?>" readonly></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot class="bg-indigo text-white">
                <tr>
                    <th colspan="5">TOTAL</th>
                    <th></th>
                </tr>
                </tfoot>
            </table><hr />
        </div>
    </div>
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