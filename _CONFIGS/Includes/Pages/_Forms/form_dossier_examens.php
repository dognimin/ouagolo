<p id="p_dossier_examens_resultats"></p>
<form id="form_dossier_examens">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_examen_acte_input" class="form-label">Code</label>
            <input type="text" placeholder="Code" maxlength="7" id="code_examen_acte_input" class="form-control form-control-sm code_acte" autocomplete="off" />
        </div>
        <div class="col-sm">
            <label for="libelle_examen_acte_input" class="form-label">Libellé</label>
            <input type="text" placeholder="Libellé" id="libelle_examen_acte_input" class="form-control form-control-sm libelle_acte" autocomplete="off" />
        </div>
        <div class="col-sm-1">
            <label for="button" class="form-label">&nbsp;</label>
            <div class="d-grid gap-2">
                <button type="button" name="add" id="button_ajouter_examens_acte" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
            </div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col">
            <p id="p_erreur_examens_actes"></p>
            <table class="table table-bordered table-sm">
                <thead class="bg-indigo text-white">
                <tr>
                    <th style="width: 100px">CODE</th>
                    <th>LIBELLE</th>
                    <th style="width: 5px"></th>
                </tr>
                </thead>
                <tbody id="tbody_examens_actes"></tbody>
            </table>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm">
            <label for="renseignements_input" class="form-label">Renseignements cliniques</label>
            <textarea class="form-control form-control-sm" placeholder="Renseignements cliniques" id="renseignements_input"></textarea>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_examens_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>
    </div>
</form>
