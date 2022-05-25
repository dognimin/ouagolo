<p id="p_panier_de_soins_medicament_resultats"></p>
<form id="form_panier_de_soins_medicament">
    <div class="row">
        <div class="col-sm">
            <label for="libelle_medicament_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_medicament_input" placeholder="Libellé" aria-describedby="libelleMedicamentHelp" autocomplete="off" maxlength="100">
            <div id="libelleMedicamentHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_medicament_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_medicament_input" placeholder="Code" aria-describedby="codeMedicamentHelp" autocomplete="off" maxlength="20">
            <div id="codeMedicamentHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="tarif_medicament_input" class="form-label">Tarif</label>
            <input type="text" class="form-control form-control-sm" id="tarif_medicament_input" placeholder="Tarif" aria-describedby="tarifMedicamentHelp" autocomplete="off" maxlength="11">
            <div id="tarifMedicamentHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="date_debut_medicament_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm" id="date_debut_medicament_input" placeholder="Date début" aria-describedby="dateDebutMedicamentHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateDebutMedicamentHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4 d-grid">
            <button type="submit" id="button_enregistrer_medicament" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm-4 d-grid">
            <button type="button" id="button_retourner_medicament" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>