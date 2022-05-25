<p id="p_etablissement_facture_resultats"></p>
<form id="form_etablissement_facture">
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm">
                    <label for="num_dossier_f_input" class="form-label"><strong class="text-primary">N° dossier</strong></label>
                    <select class="form-select form-select-sm" id="num_dossier_f_input"  aria-label=".form-select-sm" aria-describedby="numDossierFHelp">
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($dossiers_ouverts as $dossier_ouvert) {
                            echo '<option value="'.$dossier_ouvert['code_dossier'].'">'.$dossier_ouvert['code_dossier'].'</option>';
                        }
                        ?>
                    </select>
                    <div id="numDossierFHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="type_facture_f_input" class="form-label"><strong class="text-primary">Type de facture</strong></label>
                    <select class="form-select form-select-sm" id="type_facture_f_input"  aria-label=".form-select-sm" aria-describedby="typeFactureFHelp">
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($types_factures AS $type_facture){ ?>
                            <option value="<?= $type_facture['code'] ?>"><?= $type_facture['libelle'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div id="typeFactureFHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="num_facture_initiale_f_input" class="form-label">N° Facture initiale</label>
                    <select class="form-select form-select-sm" id="num_facture_initiale_f_input"  aria-label=".form-select-sm" aria-describedby="numFactureInitialeHelp">
                        <option value="">Sélectionnez</option>
                    </select>
                    <div id="numFactureInitialeHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="num_facture_input" class="form-label">N° Facture</label>
                    <input type="text" class="form-control form-control-sm" id="num_facture_input" placeholder="N° Facture" aria-describedby="numFactureHelp" autocomplete="off" maxlength="20" readonly>
                    <div id="numFactureHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="code_assurance_input" class="form-label"><strong class="text-primary">Assurance / Mutuelle</strong></label>
                    <select class="form-select form-select-sm" id="code_assurance_input"  aria-label=".form-select-sm" aria-describedby="codeAssuranceHelp" >
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($assurances AS $assurance){ ?>
                            <option value="<?= $assurance['code'] ?>"><?= $assurance['libelle'] ?></option>
                        <?php } ?>
                    </select>
                    <div id="codeAssuranceHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="num_assurance_input" class="form-label">N° Police</label>
                    <input type="text" class="form-control form-control-sm" id="num_assurance_input" placeholder="N° Assurance" aria-describedby="numAssuranceHelp" autocomplete="off" maxlength="20">
                    <div id="numAssuranceHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="num_bon_input" class="form-label">N° Bon</label>
                    <input type="text" class="form-control form-control-sm" id="num_bon_input" placeholder="N° Bon" aria-describedby="numBonHelp" autocomplete="off" maxlength="20">
                    <div id="numBonHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="taux_assurance_input" class="form-label"><strong class="text-primary">Taux A/M</strong></label>
                    <select class="form-select form-select-sm" id="taux_assurance_input"  aria-label=".form-select-sm" aria-describedby="tauxAssuranceHelp" >
                        <?php
                        for ($taux = 0; $taux <= 100; $taux = $taux + 5){
                            ?>
                            <option value="<?= $taux;?>"><?= $taux.' %';?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div id="tauxAssuranceHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="date_soins_input" class="form-label"><strong class="text-primary">Date des soins</strong></label>
                    <input type="text" class="form-control form-control-sm date" id="date_soins_input" value="<?= date('d/m/Y',time());?>" placeholder="Date des soins" aria-describedby="dateSoinsHelp" autocomplete="off" maxlength="10" readonly>
                    <div id="dateSoinsHelp" class="form-text"></div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="row">
                <div class="col-sm">
                    <label for="libelle_acte_input" class="form-label"><strong class="text-primary">Désignation de l'acte</strong></label>
                    <input type="text" class="form-control form-control-sm" id="libelle_acte_input" placeholder="Désignation de l'acte" aria-describedby="libelleActeHelp" autocomplete="off">
                    <input type="hidden" id="code_ets_acte_input" value="<?= $ets['code'];?>">
                    <div id="libelleActeHelp" class="form-text"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="code_acte_input" class="form-label"><strong class="text-primary">Code de l'acte</strong></label>
                    <input type="text" class="form-control form-control-sm" id="code_acte_input" placeholder="Code de l'acte" aria-describedby="codeActeHelp" autocomplete="off" maxlength="7">
                    <div id="codeActeHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="prix_unitaire_acte_input" class="form-label">Prix unitaire</label>
                    <input type="text" class="form-control form-control-sm" id="prix_unitaire_acte_input" placeholder="Prix unitaire" aria-describedby="prixUnitaireActeHelp" autocomplete="off" readonly>
                    <div id="prixUnitaireActeHelp" class="form-text"></div>
                </div>
                <div class="col-sm-2">
                    <label for="quantite_acte_input" class="form-label"><strong class="text-primary">Quantité</strong></label>
                    <select class="form-select form-select-sm" id="quantite_acte_input"  aria-label=".form-select-sm" aria-describedby="quantiteActeHelp" >
                        <?php
                        for ($quantite = 1; $quantite <= 100; $quantite++) {
                            echo '<option value="'.$quantite.'">'.$quantite.'</option>';
                        }
                        ?>
                    </select>
                    <div id="quantiteActeHelp" class="form-text"></div>
                </div>
                <div class="col-sm">
                    <label for="montant_depense_acte_input" class="form-label">Montant de la dépense</label>
                    <input type="text" class="form-control form-control-sm" id="montant_depense_acte_input" placeholder="Montant de la dépense" aria-describedby="montantDepenseActeHelp" autocomplete="off" readonly>
                    <div id="montantDepenseActeHelp" class="form-text"></div>
                </div>
                <div class="col-sm-1">
                    <div class="row">
                        <div class="col-sm d-grid">
                            <label for="" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm" id="button_ajouter_acte"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div><hr />
            <div id="div_facture_actes">
                <p id="p_erreur_actes"></p>
                <table class="table table-sm table-hover stable-stripped" id="table_facture_actes">
                    <thead class="bg-secondary">
                    <tr>
                        <th style="width: 5px">#</th>
                        <th style="width: 40px">CODE</th>
                        <th>DESIGNATION</th>
                        <th style="width: 70px">PRIX U.</th>
                        <th style="width: 5px">QTE</th>
                        <th style="width: 80px">MONTANT T.</th>
                        <th style="width: 5px"></th>
                    </tr>
                    </thead>
                    <tbody id="tbody_actes"></tbody>
                    <tfoot>
                    <tr>
                        <th colspan="5">TOTAL</th>
                        <th id="th_montant_patient" class="align_right">0</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <a href="<?= URL . 'etablissement/patients/?nip='.$patient['num_population']; ?>" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</a>
                </div>
            </div>
        </div>

    </div>
</form>