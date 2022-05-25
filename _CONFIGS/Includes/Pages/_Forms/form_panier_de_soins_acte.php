<p id="p_panier_de_soins_acte_resultats"></p>
<form id="form_panier_de_soins_acte">
    <div class="row">
        <div class="col-sm">
            <label for="libelle_acte_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_acte_input" placeholder="Libellé" aria-describedby="libelleActeHelp" autocomplete="off" maxlength="100">
            <div id="libelleActeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_acte_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_acte_input" placeholder="Code" aria-describedby="codeActeHelp" autocomplete="off" maxlength="7">
            <div id="codeActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="tarif_acte_input" class="form-label">Tarif</label>
            <input type="text" class="form-control form-control-sm" id="tarif_acte_input" placeholder="Tarif" aria-describedby="tarifActeHelp" autocomplete="off" maxlength="11">
            <div id="tarifActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="tarif_plafond_acte_input" class="form-label">Tarif plafond</label>
            <input type="text" class="form-control form-control-sm" id="tarif_plafond_acte_input" placeholder="Tarif plafond" aria-describedby="tarifPlafondActeHelp" autocomplete="off" maxlength="11">
            <div id="tarifPlafondActeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="statut_entente_prealable_input" class="form-label">Entente préalable</label>
            <select class="form-select form-select-sm" id="statut_entente_prealable_input" aria-label=".form-select-sm" aria-describedby="statutEntentePrealableHelp">
                <option value="0">Non</option>
                <option value="1">Oui</option>
            </select>
            <div id="statutEntentePrealableHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="date_debut_acte_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm datepicker" id="date_debut_acte_input" placeholder="Date début" aria-describedby="dateDebutActeHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateDebutActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm"></div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4 d-grid">
            <button type="submit" id="button_enregistrer_acte" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm-4 d-grid">
            <button type="button" id="button_retourner_acte" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>