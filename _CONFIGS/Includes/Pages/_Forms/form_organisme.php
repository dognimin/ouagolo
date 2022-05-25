<p id="p_organisme_resultats"></p>
<form id="form_organisme">
    <div class="row">
        <div class="col-sm">
            <label for="code_input" class="form-label">Code de l'organisme</label>
            <input type="text" class="form-control form-control-sm" id="code_input" value="<?php if (isset($_POST['code'])) {echo $organisme['code'];} ?>" placeholder="Code de l'organisme" aria-describedby="codeHelp" autocomplete="off" maxlength="8" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_rgb_input" class="form-label">Code du régime Général de Base (RGB)</label>
            <input type="text" class="form-control form-control-sm" id="code_rgb_input" value="<?php if (isset($_POST['code'])) {echo $organisme['code_rgb'];} ?>" placeholder="Code RGB" aria-describedby="codeRGBHelp" autocomplete="off" maxlength="8">
            <div id="codeRGBHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input"
                   value="<?php if (isset($_POST['code'])) {echo $organisme['libelle'];} ?>" placeholder="Nom de l'organisme" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm">
            <label for="pays_input" class="form-label"><strong class="text-primary">Pays</strong></label>
            <select class="form-select form-select-sm" id="pays_input" aria-label=".form-select-sm" aria-describedby="paysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($payss AS $pays){ ?>
                    <option value="<?= $pays['code'] ?>" <?php if (isset($_POST['code']) && $organisme['code_pays'] == $pays['code']){ echo 'selected'; } ?>><?= $pays['nom'] ?></option>
                <?php } ?>
            </select>
            <div id="paysHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="region_input" class="form-label"><strong class="text-primary">Région</strong></label>
            <select class="form-select form-select-sm" id="region_input" aria-label=".form-select-sm" aria-describedby="regionHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code'])){
                    foreach ($regions AS $region){ ?>
                        <option value="<?= $region['code'] ?>" <?php if (isset($_POST['code']) && $organisme['code_region'] == $region['code']){ echo 'selected'; } ?>><?= $region['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="regionHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="departement_input" class="form-label"><strong class="text-primary">Departement</strong></label>
            <select class="form-select form-select-sm" id="departement_input" aria-label=".form-select-sm" aria-describedby="departementHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code'])){
                    foreach ($departements AS $departement){ ?>
                        <option value="<?= $departement['code'] ?>" <?php if (isset($_POST['code']) && $organisme['code_departement'] == $departement['code']){ echo 'selected'; } ?>><?= $departement['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="departementHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="commune_input" class="form-label"><strong class="text-primary">Commune</strong></label>
            <select class="form-select form-select-sm" id="commune_input" aria-label=".form-select-sm" aria-describedby="communeHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code'])){
                    foreach ($communes AS $commune){ ?>
                        <option value="<?= $commune['code'] ?>" <?php if (isset($_POST['code']) && $organisme['code_commune'] == $commune['code']){ echo 'selected'; } ?>><?= $commune['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="communeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_postale_input" class="form-label">Adresse postale</label>
            <input type="text" class="form-control form-control-sm" id="adresse_postale_input" value="<?php if (isset($_POST['code'])){ echo $organisme['adresse_postale']; } ?>" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
            <div id="adressePostaleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_geo_input" class="form-label">Adresse geographique</label>
            <textarea class="form-control form-control-sm" id="adresse_geo_input" maxlength="100" placeholder="Adresse geographique" aria-describedby="adresseGeoHelp" autocomplete="off"><?php if (isset($_POST['code'])){ echo $organisme['adresse_geographique']; } ?></textarea>
            <div id="adresseGeoHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="latitude_input" class="form-label">Latitude</label>
            <input type="text" class="form-control form-control-sm" id="latitude_input" value="<?php if (isset($_POST['code'])){ echo $organisme['latitude']; } ?>" maxlength="15" placeholder="Latitude" aria-describedby="latitudeHelp" autocomplete="off">
            <div id="latitudeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="longitude_input" class="form-label">longitude</label>
            <input type="text" class="form-control form-control-sm" id="longitude_input" value="<?php if (isset($_POST['code'])){ echo $organisme['longitude']; } ?>" maxlength="15" placeholder="Longitude" aria-describedby="longitudeHelp" autocomplete="off">
            <div id="longitudeHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i
                            class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>