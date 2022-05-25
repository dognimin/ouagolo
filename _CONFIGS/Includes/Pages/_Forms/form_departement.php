<p id="p_departement_resultats"></p>
<form id="form_departement">
    <div class="row">
        <div class="col-sm-6">
            <label for="code_pays_input" class="form-label">Pays</label>
            <select class="form-select form-select-sm" id="code_pays_input" aria-label=".form-select-sm" aria-describedby="codePaysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($pays as $tbpays) {
                    echo '<option value="'.$tbpays['code'].'">'.$tbpays['nom'].'</option>';
                }
                ?>
            </select>
            <div id="codePaysHelp" class="form-text"></div>
        </div>
        <div class="col-sm-6">
            <label for="code_region_input" class="form-label">Region</label>
            <select class="form-select form-select-sm" id="code_region_input" aria-label=".form-select-sm" aria-describedby="codeRegionHelp">
                <option value="">Sélectionnez</option>

            </select>
            <div id="codeRegionHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="5" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-9">
            <label for="nom_input" class="form-label">Nom</label>
            <input type="text" class="form-control form-control-sm" id="nom_input" maxlength="45" placeholder="Nom" aria-describedby="nomHelp" autocomplete="off">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="latitude_input" class="form-label">Latitude</label>
            <input type="text" class="form-control form-control-sm" id="latitude_input" maxlength="15" placeholder="Latitude" aria-describedby="latitudeHelp" autocomplete="off">
            <div id="latitudeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="longitude_input" class="form-label">Longitude</label>
            <input type="text" class="form-control form-control-sm" id="longitude_input" maxlength="15" placeholder="Longitude" aria-describedby="longitudeHelp" autocomplete="off">
            <div id="longitudeHelp" class="form-text"></div>
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