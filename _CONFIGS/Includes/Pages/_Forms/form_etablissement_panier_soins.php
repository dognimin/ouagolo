<p id="p_etablissement_panier_soins_resultats"></p>
<form id="form_etablissement_panier_soins">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_acte_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_acte_input" maxlength="7" placeholder="Code" aria-describedby="codeActeHelp" autocomplete="off" readonly>
            <div id="codeActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_acte_input" class="form-label">Libellé</label>
            <textarea class="form-control form-control-sm" id="libelle_acte_input" placeholder="Raison sociale" aria-describedby="libelleActeHelp" autocomplete="off" readonly></textarea>
            <div id="libelleActeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="type_facture_input" class="form-label">Type facture</label>
            <select class="form-select form-select-sm" id="type_facture_input"  aria-label=".form-select-sm" aria-describedby="typeFactureHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types as $type) { ?>

                    <option value="<?= $type['code'] ?>"><?= $type['libelle'] ?></option>
                <?php }
                ?>
            </select>
            <div id="typeFactureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="tarif_acte_input" class="form-label"><strong class="text-primary">Tarif</strong></label>
            <input type="text" class="form-control form-control-sm" id="tarif_acte_input" maxlength="11" placeholder="Tarif" aria-describedby="tarifHelp" autocomplete="off">
            <div id="tarifHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="date_debut_acte_input" class="form-label"><strong class="text-primary">Date début</strong></label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_acte_input" maxlength="10" placeholder="Date début" aria-describedby="dateDebutHelp" autocomplete="off" readonly>
            <div id="dateDebutHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>