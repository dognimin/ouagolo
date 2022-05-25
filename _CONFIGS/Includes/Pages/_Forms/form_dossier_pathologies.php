<p id="p_dossier_pathologies_resultats"></p>
<form id="form_dossier_pathologies">
    <div class="row"  id="dynamic_field">
        <div class="col-sm-2">
            <label for="code_pathologie_input" class="form-label">code</label>
            <input type="text" name="code_pathologie_input" maxlength="3" placeholder="Code" id="code_pathologie_input" class="form-control form-control-sm" autocomplete="off" />
        </div>
        <div class="col-sm">
            <label for="libelle_pathologie_input" class="form-label">Libellé</label>
            <input type="text" name="libelle_pathologie_input" placeholder="Libellé" id="libelle_pathologie_input" class="form-control form-control-sm" autocomplete="off" />
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_pathologie_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>

    </div>
</form>