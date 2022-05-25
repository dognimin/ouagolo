<p id="p_reseau_medicament_resultat"></p>
<form id="form_reseau_medicament">
    <div class="row">
        <div class="col-sm-2">
            <label for="medicament_code" class="form-label">Code médicament</label>
            <input type="text" class="form-control form-control-sm" id="medicament_code" maxlength="7" placeholder="Code" aria-describedby="codeMedicamentHelp" autocomplete="off">
            <div id="codeMedicamentHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_medicament_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_medicament_input" placeholder="Libellé" aria-describedby="libelleMedicamentHelp" autocomplete="off">
            <div id="libelleMedicamentHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <label for="tarif_medicament_input" class="form-label">Tarif</label>
            <input type="text" class="form-control form-control-sm" id="tarif_medicament_input" maxlength="9" placeholder="Tarif" aria-describedby="tarifHelp" autocomplete="off">
            <div id="tarifHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_debut_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm" id="date_debut_input" maxlength="9" placeholder="Date début" aria-describedby="dateDebutHelp" autocomplete="off" readonly>
            <div id="dateDebutHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-2 d-grid">
            <input type="hidden" id="code_reseau_input" value="<?= $reseau['code'];?>" />
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>