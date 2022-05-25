<p id="p_section_resultats"></p>
<form id="form_section">
    <div class="row">
        <div class="col">
            <label for="code_titre_input" class="form-label">Titre</label>
            <select class="form-select form-select-sm" id="code_titre_input" aria-label=".form-select-sm" aria-describedby="code_titre_input">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($titres as $titre) {
                    echo '<option value="'.$titre['code'].'">'.$titre['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeTitreHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="code_chapitres_input" class="form-label">Chapitre</label>
            <select class="form-select form-select-sm" id="code_chapitres_input" aria-label=".form-select-sm" aria-describedby="code_chapitres_input"></select>
            <div id="codeChapitreHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="7" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
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