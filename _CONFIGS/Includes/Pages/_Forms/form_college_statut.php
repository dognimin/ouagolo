<p id="p_college_statut_resultats"></p>
<form id="form_college_statut">
    <div class="row">
        <div class="col-sm">
            <label for="code_college_statut_input" class="form-label"><strong class="text-primary">Statut</strong></label>
            <select class="form-select form-select-sm" id="code_college_statut_input" aria-label=".form-select-sm" aria-describedby="codeCollegeStatutHelp">
                <option value="">Sélectionnez</option>
                <option value="ACT">ACTIVE</option>
                <option value="SUS">SUSPENDU</option>
                <option value="RES">RESILIE</option>
            </select>
            <div id="codeCollegeStatutHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row" id="div_college_motif">
        <div class="col-sm">
            <label for="college_motif_input" class="form-label">Motif</label>
            <textarea class="form-control form-control-sm" id="college_motif_input" maxlength="100" placeholder="Motif" aria-describedby="collegeMotifHelp" autocomplete="off"></textarea>
            <div id="collegeMotifHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_statut_enregistrer" class="btn btn-primary btn-sm"><i
                            class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
