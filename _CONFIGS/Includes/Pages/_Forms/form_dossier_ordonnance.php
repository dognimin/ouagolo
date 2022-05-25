<p id="p_dossier_ordonnance_resultats"></p>
<form id="form_dossier_ordonnance">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_ordonnance_medicament_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_ordonnance_medicament_input" placeholder="Code" aria-describedby="codeOrdonnanceMedicamentHelp" autocomplete="off" maxlength="20">
            <div id="codeOrdonnanceMedicamentHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_ordonnance_medicament_input" class="form-label">Libellé médicament</label>
            <input type="text" class="form-control form-control-sm" id="libelle_ordonnance_medicament_input" placeholder="Libellé médicament" aria-describedby="libelleOrdonnanceMedicamentHelp" autocomplete="off" maxlength="200">
            <div id="libelleOrdonnanceMedicamentHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="posologie_ordonnance_medicament_input" class="form-label">Posologie</label>
            <input type="text" class="form-control form-control-sm" id="posologie_ordonnance_medicament_input" placeholder="Posologie" aria-describedby="posologieOrdonnanceMedicamentHelp" autocomplete="off" maxlength="200">
            <div id="posologieOrdonnanceMedicamentHelp" class="form-text"></div>
        </div>
        <div class="col-sm-4">
            <label for="duree_ordonnance_medicament_input" class="form-label">Durée</label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control form-control-sm" id="duree_ordonnance_medicament_input" aria-label=".form-control-sm" placeholder="Durée" aria-describedby="dossierMedicamentDureeHelp" autocomplete="off" maxlength="200">
                <select class="form-select form-select-sm" id="unite_duree_ordonnance_medicament_input" aria-label=".form-select-sm">
                    <option value="J">Jours</option>
                    <option value="S">Semaines</option>
                    <option value="M">Mois</option>
                    <option value="A">Années</option>
                </select>
            </div>
            <div id="dossierMedicamentDureeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="button" class="form-label">&nbsp;</label>
            <div class="d-grid gap-2">
                <button type="button" name="add" id="button_ajouter_ordonnance_medicament" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
            </div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-sm">
                <thead class="bg-indigo text-white">
                <tr>
                    <th style="width: 100px">CODE</th>
                    <th>LIBELLE</th>
                    <th style="width: 200px">POSOLOGIE</th>
                    <th style="width: 100px">DUREE</th>
                    <th style="width: 5px"></th>
                </tr>
                </thead>
                <tbody id="tbody_ordonnance_medicaments"></tbody>
            </table>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_ordonnance_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>

    </div>
</form>
