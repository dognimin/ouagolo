<p id="p_reseau_acte_medical_resultats"></p>
<form id="form_reseau_acte_medical">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_acte_input" class="form-label">Code acte</label>
            <input type="text" class="form-control form-control-sm" id="code_acte_input" maxlength="7" placeholder="Code" aria-describedby="codeActeHelp" autocomplete="off">
            <div id="codeActeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <label for="tarif_input" class="form-label">Tarif</label>
            <input type="text" class="form-control form-control-sm" id="tarif_input" maxlength="9" placeholder="Tarif" aria-describedby="tarifHelp" autocomplete="off">
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