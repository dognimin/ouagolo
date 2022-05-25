<p id="p_vente_resultats"></p>
<form id="form_pharmacie_vente">
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm">
                    <label for="num_facture_initiale_input" class="form-label">N° Facture initiale</label>
                    <input type="text" class="form-control form-control-sm" id="num_facture_initiale_input" maxlength="20" placeholder="N° Facture" aria-describedby="numFactureHelp" autocomplete="off">
                    <div id="numFactureHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="num_ip_input" class="form-label">NIP / N° sécu</label>
                    <input type="text" class="form-control form-control-sm" id="num_ip_input" maxlength="16" placeholder="NIP / N° sécu" aria-describedby="numIPHelp" autocomplete="off">
                    <div id="numIPHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="col-sm">
                        <label for="nom_prenoms_input" class="form-label">Nom & Prénom(s)</label>
                        <input type="text" class="form-control form-control-sm" id="nom_prenoms_input" placeholder="Nom & Prénom(s)" aria-describedby="nomPrenomsHelp" autocomplete="off">
                        <div id="nomPrenomsHelp" class="form-text"></div>
                    </div>
                </div>
            </div><hr />
            <div class="row">
                <div class="col-sm">
                    <label for="code_assurance_input" class="form-label">Assurance</label>
                    <select class="form-select form-select-sm" id="code_assurance_input" aria-label=".form-select-sm" aria-describedby="codeAssuranceHelp">
                        <option value="">Sélectionnez</option>
                    </select>
                    <div id="codeAssuranceHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="taux_organisme_input" class="form-label">Taux</label>
                    <select class="form-select form-select-sm" id="taux_organisme_input" aria-label=".form-select-sm" aria-describedby="tauxOrganismeHelp">
                        <?php
                        for ($taux = 0; $taux <= 100; $taux = $taux + 5) {
                            ?>
                            <option value="<?= $taux;?>"><?= $taux.' %';?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div id="tauxOrganismeHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="code_collectivite_input" class="form-label">Sociétaire / Collectivité</label>
                    <select class="form-select form-select-sm" id="code_collectivite_input" aria-label=".form-select-sm" aria-describedby="codeCollectiviteHelp">
                        <option value="">Sélectionnez</option>
                    </select>
                    <div id="codeCollectiviteHelp" class="form-text"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-sm-3">
                    <label for="code_produit_input" class="form-label"><strong class="text-dark">Code du produit</strong></label>
                    <input type="text" class="form-control form-control-sm" id="code_produit_input" placeholder="Code du produit" aria-describedby="codeProduitHelp" autocomplete="off" maxlength="20">
                    <div id="codeProduitHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="libelle_produit_input" class="form-label"><strong class="text-dark">Désignation</strong></label>
                    <input type="text" class="form-control form-control-sm" id="libelle_produit_input" placeholder="Désignation du produit" aria-describedby="libelleProduitHelp" autocomplete="off">
                    <input type="hidden" id="code_ets_acte_input" value="<?= $ets['code'];?>">
                    <div id="libelleProduitHelp" class="form-text"></div>
                </div>
                <div class="col-sm-2">
                    <label for="quantite_en_stock_input" class="form-label">Quantité en stock</label>
                    <input type="text" class="form-control form-control-sm" id="quantite_en_stock_input" placeholder="Quantité en stock" value="0" aria-describedby="quantitestockHelp" autocomplete="off" readonly>
                    <div id="quantitestockHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="prix_unitaire_input" class="form-label">Prix unitaire</label>
                    <input type="text" class="form-control form-control-sm" id="prix_unitaire_input" placeholder="Prix unitaire" aria-describedby="prixUnitaireHelp" value="0" autocomplete="off" readonly>
                    <div id="prixUnitaireHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="taux_rgb_produit_input" class="form-label"><strong class="text-dark">Taux RGB</strong></label>
                    <select class="form-select form-select-sm" id="taux_rgb_produit_input"  aria-label=".form-select-sm" aria-describedby="tauxRGBProduitHelp" disabled>
                        <?php
                        for ($to = 0; $to <= 100; $to += 5) {
                            echo '<option value="'.$to.'">'.$to.'%</option>';
                        }
                        ?>
                    </select>
                    <div id="tauxRGBProduitHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="taux_organisme_produit_input" class="form-label"><strong class="text-dark">Taux AC</strong></label>
                    <select class="form-select form-select-sm" id="taux_organisme_produit_input"  aria-label=".form-select-sm" aria-describedby="tauxOrganismeProduitHelp" disabled>
                        <?php
                        for ($to = 0; $to <= 100; $to += 5) {
                            echo '<option value="'.$to.'">'.$to.'%</option>';
                        }
                        ?>
                    </select>
                    <div id="tauxOrganismeProduitHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="remise_produit_input" class="form-label"><strong class="text-dark">Remise</strong></label>
                    <select class="form-select form-select-sm" id="remise_produit_input"  aria-label=".form-select-sm" aria-describedby="remiseProduitHelp">
                        <?php
                        for ($r = 0; $r <= 100; $r += 5) {
                            echo '<option value="'.$r.'">'.$r.'%</option>';
                        }
                        ?>
                    </select>
                    <div id="remiseProduitHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="quantite_input" class="form-label"><strong class="text-dark">Quantité</strong></label>
                    <select class="form-select form-select-sm" id="quantite_input"  aria-label=".form-select-sm" aria-describedby="quantiteHelp" >
                        <?php
                        for ($quantite = 1; $quantite <= 100; $quantite++) {
                            echo '<option value="'.$quantite.'">'.$quantite.'</option>';
                        }
                        ?>
                    </select>
                    <div id="quantiteHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="montant_depense_input" class="form-label">Montant</label>
                    <input type="text" class="form-control form-control-sm" id="montant_depense_input" placeholder="Montant" aria-describedby="montantDepenseHelp" value="0" autocomplete="off" readonly>
                    <div id="montantDepenseHelp" class="form-text"></div>
                </div>
                <div class="col-sm-1">
                    <div class="row">
                        <div class="col-sm d-grid">
                            <label for="" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm border-white" id="button_ajouter_produit"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div><hr />
            <div id="div_liste_produits">
                <div class="col">
                    <p id="p_erreur_produits"></p>
                    <table class="table table-sm table-hover stable-stripped table-bordered" id="table_facture_produits">
                        <thead class="bg-indigo text-white">
                        <tr>
                            <th style="width: 5px">#</th>
                            <th style="width: 120px">CODE</th>
                            <th>DESIGNATION</th>
                            <th style="width: 70px">PRIX U.</th>
                            <th style="width: 70px">MT. RGB</th>
                            <th style="width: 70px">MT. AC</th>
                            <th style="width: 70px">%R</th>
                            <th style="width: 70px">QUANTITE</th>
                            <th style="width: 80px">MONTANT T.</th>
                            <th style="width: 5px"></th>
                        </tr>
                        </thead>
                        <tbody id="tbody_produits"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   <hr />
    <div class="row">
        <div class="col-sm">
            <label for="montant_facture_input" class="form-label"><strong>Total</strong></label>
            <input type="text" class="total_resultat_input text-danger" id="montant_facture_input" value="0" readonly>
        </div>
        <div class="col-sm-2">
            <label for="montant_rgb_input" class="form-label"><strong>Montant RGB</strong></label>
            <input type="text" class="total_resultat_input text-dark" id="montant_rgb_input" value="0" readonly>
        </div>
        <div class="col-sm-2">
            <label for="montant_organisme_input" class="form-label"><strong>Montant assurance</strong></label>
            <input type="text" class="total_resultat_input text-dark" id="montant_organisme_input" value="0" readonly>
        </div>
        <div class="col-sm-2">
            <label for="remise_facture_input" class="form-label"><strong>Remise %</strong></label>
            <input type="number" class="total_resultat_input text-dark" id="remise_facture_input" min="0" max="100" value="0">
        </div>
        <div class="col-sm">
            <label for="montant_net_input" class="form-label"><strong>NET à payer</strong></label>
            <input type="text" class="total_resultat_input text-success" id="montant_net_input" value="0" readonly>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block" id="button_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
