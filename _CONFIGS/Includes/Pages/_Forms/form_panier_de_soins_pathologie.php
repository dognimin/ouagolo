<p id="p_panier_de_soins_pathologie_resultats"></p>
<form id="form_panier_de_soins_pathologie">
    <div class="row">
        <div class="col-sm">
            <label for="libelle_pathologie_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_pathologie_input" placeholder="Libellé" aria-describedby="libellePathologieHelp" autocomplete="off" maxlength="100">
            <div id="libellePathologieHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label for="code_pathologie_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_pathologie_input" placeholder="Code" aria-describedby="codePathologieHelp" autocomplete="off" maxlength="3">
            <div id="codePathologieHelp" class="form-text"></div>
        </div>
        <div class="col-sm-4">
            <label for="date_debut_pathologie_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm" id="date_debut_pathologie_input" placeholder="Date début" aria-describedby="dateDebutPathologieHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateDebutPathologieHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4 d-grid">
            <button type="submit" id="button_enregistrer_pathologie" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm-4 d-grid">
            <button type="button" id="button_retourner_pathologie" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>