<p id="p_reseau_resultats"></p>
<form id="form_reseau_de_soins">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_reseau_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_reseau_input" maxlength="7" placeholder="Code" aria-describedby="codeReseauHelp" autocomplete="off" readonly>
            <div id="codeReseauHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_reseau_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_reseau_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleReseauHelp" autocomplete="off">
            <div id="libelleReseauHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>