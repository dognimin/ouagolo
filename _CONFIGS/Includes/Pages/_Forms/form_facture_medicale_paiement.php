<p id="p_facture_medicale_paiement_resultats"></p>
<form id="form_facture_medicale_paiement">
    <div class="row">
        <div class="col-sm">
            <input type="text" style="text-align: center;" class="form-control-plaintext form-control-sm text-white" id="num_facture_input" aria-label="num_facture_input" value="<?= $facture? $facture['num_facture']: '';?>" placeholder="N° Facture" aria-describedby="numFactureHelp" autocomplete="off" maxlength="20" readonly>
            <div id="numFactureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="montant_brut_input" class="form-label">Montant brut</label>
            <input type="text" class="form-control form-control-sm" id="montant_brut_input" value="<?= $montant_patient? $montant_patient: 0;?>" placeholder="Montant brut" aria-describedby="montantBrutHelp" autocomplete="off" maxlength="9" readonly>
            <div id="montantBrutHelp" class="form-text"></div>
        </div>
        <div class="col-sm-5">
            <label for="remise_input" class="form-label">Remise %</label>
            <select class="form-select form-select-sm" id="remise_input"  aria-label=".form-select-sm" aria-describedby="remiseHelp">
                <?php
                for ($remise = 0; $remise <= 100; $remise += 5) {
                    echo '<option value="'.$remise.'">'.$remise.'</option>';
                }
                ?>
            </select>
            <div id="remiseHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="montant_net_input" class="form-label">Montant net</label>
            <input type="text" class="form-control form-control-lg" id="montant_net_input" value="<?= $montant_patient? number_format($montant_patient,'0','',' '): 0;?>" placeholder="Montant net" aria-describedby="montantNetHelp" autocomplete="off" readonly>
            <div id="montantNetHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm">
            <label for="mode_paiement_input" class="form-label">Mode paiement</label>
            <select class="form-select form-select-sm" id="mode_paiement_input"  aria-label=".form-select-sm" aria-describedby="modePaiementHelp">
                <option value="">Sélectionner</option>
                <?php
                foreach ($types_reglements as $type_reglement) {
                    echo '<option value="'.$type_reglement['code'].'">'.$type_reglement['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="modePaiementHelp" class="form-text"></div>
        </div>
    </div>
    <div id="div_paiement_especes">
        <div class="row">
            <div class="col-sm">
                <label for="montant_recu_input" class="form-label">Montant reçu</label>
                <input type="text" class="form-control form-control-sm" id="montant_recu_input" placeholder="Montant reçu" aria-describedby="montantRecuHelp" autocomplete="off" maxlength="9">
                <div id="montantRecuHelp" class="form-text"></div>
            </div>
            <div class="col-sm">
                <label for="monnaie_rendue_input" class="form-label">Monnaie</label>
                <input type="text" class="form-control form-control-sm" id="monnaie_rendue_input" placeholder="Monnaie" aria-describedby="monnaieRendueHelp" autocomplete="off" maxlength="9" readonly>
                <div id="monnaieRendueHelp" class="form-text"></div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm d-grid">
            <button type="button"  class="btn btn-danger btn-sm btn-block"><i class="bi bi-trash-fill"></i> Supprimer</button>
        </div>
    </div>
</form>
