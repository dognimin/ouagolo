<p id="p_type_etablissement_resultats"></p>
<form id="form_type_etablissement">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="10" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="45" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="code_niveau_input" class="form-label">Niveau</label>
            <select class="form-select form-select-sm" id="code_niveau_input" aria-label=".form-select-sm" aria-describedby="codeNiveauHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($niveaux as $niveau) {
                    echo '<option value="'.$niveau['code'].'">'.$niveau['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeNiveauHelp" class="form-text"></div>
        </div>
    </div><br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>