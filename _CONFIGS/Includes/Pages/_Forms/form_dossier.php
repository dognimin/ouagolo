<p id="p_dossier_resultats"></p>
<form id="form_dossier">
    <div class="row">
        <div class="col-sm">
            <label for="nip_dossier_input" class="form-label">NIP</label>
            <input type="text" class="form-control form-control-sm" id="nip_dossier_input" value="<?= $patient['num_population'];?>" placeholder="NIP" aria-describedby="nipDossierHelp" autocomplete="off" maxlength="16" readonly>
            <div id="nipDossierHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="num_dossier_input" class="form-label">N° dossier</label>
            <input type="text" class="form-control form-control-sm" id="num_dossier_input" placeholder="N° dossier" aria-describedby="numDossierHelp" autocomplete="off" maxlength="20" readonly>
            <div id="numDossierHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="date_soins_input" class="form-label"><strong class="text-primary">Date des soins</strong></label>
            <input type="text" class="form-control form-control-sm date" id="date_soins_input" value="<?= date('d/m/Y', time());?>" placeholder="Date des soins" aria-describedby="dateSoinsHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateSoinsHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_assurance_input" class="form-label"><strong class="text-primary">Assurance / Mutuelle</strong></label>
            <select class="form-select form-select-sm" id="code_assurance_input"  aria-label=".form-select-sm" aria-describedby="codeAssuranceHelp" >
                <option value="">Sélectionnez</option>
                <?php
                if($nb_patient_organismes !== 0) {
                    foreach ($patient_organismes as $assurance) {
                        ?>
                        <option value="<?= $assurance['code_organisme'] ?>"><?= $assurance['libelle_organisme'] ?></option>
                        <?php
                    }
                }else {
                    foreach ($assurances as $assurance) {
                        ?>
                        <option value="<?= $assurance['code'] ?>"><?= $assurance['libelle'] ?></option>
                        <?php
                    }
                }
                ?>
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
                for ($taux = 0; $taux <= 100; $taux += 10) {
                    ?>
                    <option value="<?= $taux;?>"><?= $taux.' %';?></option>
                    <?php
                }
                ?>
            </select>
            <div id="tauxAssuranceHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="num_facture_input" class="form-label">N° Facture</label>
            <input type="text" class="form-control form-control-sm" id="num_facture_input" placeholder="N° Facture" aria-describedby="numFactureHelp" autocomplete="off" maxlength="20" readonly>
            <div id="numFactureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="type_facture_input" class="form-label"><strong class="text-primary">Type de facture</strong></label>
            <select class="form-select form-select-sm" id="type_facture_input"  aria-label=".form-select-sm" aria-describedby="typeFactureHelp" >
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types_factures as $type_facture) { ?>
                    <option value="<?= $type_facture['code'] ?>"><?= $type_facture['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="typeFactureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="libelle_acte_input" class="form-label"><strong class="text-primary">Désignation de l'acte</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_acte_input" placeholder="Désignation de l'acte" aria-describedby="libelleActeHelp" autocomplete="off">
            <input type="hidden" id="code_ets_acte_input" value="<?= $ets['code'];?>">
            <input type="hidden" id="code_acte_input" value="">
            <div id="libelleActeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="prix_unitaire_acte_input" class="form-label">Prix unitaire</label>
            <input type="text" class="form-control form-control-sm" id="prix_unitaire_acte_input" placeholder="Prix unitaire" value="0" aria-describedby="prixUnitaireActeHelp" autocomplete="off" readonly>
            <div id="prixUnitaireActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
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
            <input type="text" class="form-control form-control-sm" id="montant_depense_acte_input" value="0" placeholder="Montant de la dépense" aria-describedby="montantDepenseActeHelp" autocomplete="off" readonly>
            <div id="montantDepenseActeHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_dossier_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>
    </div>
</form>
