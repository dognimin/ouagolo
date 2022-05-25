<p id="p_dossier_plaintes_resultats"></p>
<form id="form_dossier_plaintes">
    <div class="row">
        <div class="col-sm">
            <label for="dossier_plaintes_input" class="form-label"></label>
            <textarea class="form-control form-control-sm editor" name="editor_plaintes" id="dossier_plaintes_input" placeholder="Plaintes <?= $patient['prenom'];?>" aria-describedby="patientPlaintesHelp"><?= $dossier['plainte'];?></textarea>
            <div id="patientPlaintesHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_plaintes_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>

    </div>
</form>