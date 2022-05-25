<p id="p_constantes_resultats"></p>
<form id="form_constantes">
    <div class="row">
        <div class="col-sm">
            <label for="patient_poids_input" class="form-label">Poids</label>
            <input type="text" class="form-control form-control-sm" id="patient_poids_input" value="<?= $constantes['poids'];?>" placeholder="Kg" aria-describedby="patientPoidsHelp" autocomplete="off" maxlength="6">
            <div id="patientPoidsHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="patient_temperature_input" class="form-label">Température</label>
            <input type="text" class="form-control form-control-sm" id="patient_temperature_input" value="<?= $constantes['temperature'];?>" placeholder="°C" aria-describedby="patientTemperatureHelp" autocomplete="off" maxlength="4">
            <div id="patientTemperatureHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="patient_pouls_input" class="form-label">Pouls</label>
            <input type="text" class="form-control form-control-sm" id="patient_pouls_input" value="<?= $constantes['pouls'];?>" placeholder="Bpm" aria-describedby="patientPoulsHelp" autocomplete="off" maxlength="3">
            <div id="patientPoulsHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6 d-grid">
            <button type="submit" id="button_constantes_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-6 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>