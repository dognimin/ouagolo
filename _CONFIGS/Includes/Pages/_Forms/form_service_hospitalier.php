<p id="p_service_hospitalier_resultats"></p>
<form id="form_service_hospitalier">
    <div class="row">
        <div class="col-sm">
            <label for="code_service_input" class="form-label">Service</label>
            <select class="form-select form-select-sm" id="code_service_input"  aria-label=".form-select-sm" aria-describedby="codeServiceHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($services AS $service){
                    $trouver_service = $ETABLISSEMENTS->trouver_service($ets['code'], $service['code']);
                    if(isset($ets) && ($service['code'] != $trouver_service['code'])) {
                        ?>
                        <option value="<?= $service['code'] ?>"><?= $service['libelle'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div id="codeServiceHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">

            <button type="submit" id="button_service_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" id="button_ets_service_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>