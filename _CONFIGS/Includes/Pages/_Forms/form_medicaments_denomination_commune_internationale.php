<p id="p_dci_resultats"></p>
<form id="form_dci">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="20" placeholder="Code" aria-describedby="codeHelp" autocomplete="off">
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="forme_input" class="form-label">Forme medicament</label>
            <select class="form-select form-select-sm" id="forme_input" aria-label=".form-select-sm" aria-describedby="formeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($formes as $forme) {
                    echo '<option value="'.$forme['code'].'">'.$forme['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="formeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col-sm-3">
            <label for="dosage_input" class="form-label">Dosage</label>
            <input type="text" class="form-control form-control-sm" id="dosage_input" maxlength="5" placeholder="Dosage" aria-describedby="dosageHelp" autocomplete="off">
            <div id="dosageHelp" class="form-text"></div>
        </div>
        <div  class="col-sm-3">
            <label for="unite_input" class="form-label">Unité</label>
            <select class="form-select form-select-sm" id="unite_input" aria-label=".form-select-sm" aria-describedby="uniteHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($unites as $unite) {
                    echo '<option value="'.$unite['code'].'">'.$unite['code'].'</option>';
                }
                ?>
            </select>
            <div id="uniteHelp" class="form-text"></div>
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