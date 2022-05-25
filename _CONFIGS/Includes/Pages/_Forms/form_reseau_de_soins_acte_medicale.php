<p id="p_reseau_acte_resultats"></p>
<form id="form_reseau_acte">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code reseau</label>
            <input type="text" class="form-control form-control-sm" value="<?= $_POST['code'] ?>" id="code_input" maxlength="7" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" disabled>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="acte_code" class="form-label">code acte médicale</label>
            <select class="form-select form-select-sm" id="acte_code" aria-label=".form-select-sm" aria-describedby="acteHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($actes as $acte) {
                    echo '<option value="'.$acte['code'].'">'.$acte['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="acteHelp" class="form-text"></div>
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