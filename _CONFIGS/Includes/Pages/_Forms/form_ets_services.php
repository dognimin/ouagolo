<p id="p_service_hospitalier_resultats"></p>
<form id="form_ets_services">
    <div class="row">
        <div class="col-sm">
            <label for="code_service_input" class="form-label">Service</label>
            <select class="form-select form-select-sm" id="code_service_input"  aria-label=".form-select-sm" aria-describedby="serviceEtablissementHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($services AS $service){ ?>
                    <option value="<?= $service['code'] ?>"><?= $service['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="serviceEtablissementHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <input type="hidden" value="<?= $ets['code'];?>" id="code_ets_input">
            <button type="submit" id="button_service_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" id="button_ets_service_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>