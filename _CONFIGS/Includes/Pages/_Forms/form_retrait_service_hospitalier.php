<p id="p_retrait_service_hospitalier_resultats"></p>
<form id="form_retrait_service_hospitalier">
    <div class="row">
        <div class="col-sm">
            <label for="code_service_retrait_input" class="form-label">Service</label>
            <select class="form-select form-select-sm" id="code_service_retrait_input"  aria-label=".form-select-sm" aria-describedby="codeServiceRetraitHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($services AS $service){
                    ?>
                    <option value="<?= $service['code'] ?>"><?= $service['libelle'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codeServiceRetraitHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">

            <button type="submit" id="button_service_retrait_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
