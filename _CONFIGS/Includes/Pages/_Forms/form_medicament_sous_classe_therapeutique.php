<p id="p_classe_resultats"></p>
<form id="form_sous_classe_therapeutique">
    <div  class="col">
        <label for="code_classe_input" class="form-label">Classe thérapeutique</label>
        <select class="form-select form-select-sm" id="code_classe_input" aria-label=".form-select-sm" aria-describedby="codeClasseHelp">
            <option value="">Sélectionnez</option>
            <?php
            foreach ($classes_therapeuthiques as $classe_therapeuthique) {
                echo '<option value="'.$classe_therapeuthique['code'].'">'.$classe_therapeuthique['libelle'].'</option>';
            }
            ?>
        </select>
        <div id="codeClasseHelp" class="form-text"></div>
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