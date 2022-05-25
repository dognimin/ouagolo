<p id="p_etablissement_resultats"></p>
<form id="form_etablissement">
    <div class="row">
        <div class="col-sm-3">
            <label for="type_etablissement_input" class="form-label"><strong class="text-primary">Type d'établissement</strong></label>
            <select class="form-select form-select-sm" id="type_etablissement_input"  aria-label=".form-select-sm" aria-describedby="typeEtablissementHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types as $type) { ?>

                    <option value="<?= $type['code'] ?>" <?php if ((isset($_POST['code']) || isset($ets)) && $ets['type'] == $type['code']){ echo 'selected'; } ?>><?= $type['libelle'] ?></option>
                <?php }
                ?>
            </select>
            <div id="typeEtablissementHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="secteur_input" class="form-label">Secteur d'activité</label>
            <select class="form-select form-select-sm" id="secteur_input" aria-label=".form-select-sm" aria-describedby="secteurHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($secteurs as $secteur) {
                    ?>
                    <option value="<?= $secteur['code'] ?>" <?php if ((isset($_POST['code']) || isset($ets)) && $ets['code_secteur_activite'] == $secteur['code']){ echo 'selected'; } ?>><?= $secteur['libelle'] ?></option>
                <?php  }
                ?>
            </select>
            <div id="secteurHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label"><strong class="text-primary">Code</strong></label>
            <input type="text" class="form-control form-control-sm" id="code_input" value="<?php if (isset($_POST['code']) || isset($ets)){ echo $ets['code']; } ?>" maxlength="9" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_input" class="form-label"><strong class="text-primary">Raison sociale</strong></label>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_input" value="<?php if (isset($_POST['code']) || isset($ets)){ echo $ets['raison_sociale']; } ?>" maxlength="100" placeholder="Raison sociale" aria-describedby="raisonSocialeHelp" autocomplete="off">
            <div id="raisonSocialeHelp" class="form-text"></div>
        </div>
    </div><hr />

    <div class="row">
        <div class="col-sm">
            <label for="pays_input" class="form-label"><strong class="text-primary">Pays</strong></label>
            <select class="form-select form-select-sm" id="pays_input" aria-label=".form-select-sm" aria-describedby="paysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($Pays AS $pays){ ?>
                    <option value="<?= $pays['code'] ?>" <?php if ((isset($_POST['code']) || isset($ets)) && $ets['code_pays'] == $pays['code']){ echo 'selected'; } ?>><?= $pays['nom'] ?></option>
                <?php } ?>
            </select>
            <div id="paysHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="region_input" class="form-label"><strong class="text-primary">Région</strong></label>
            <select class="form-select form-select-sm" id="region_input" aria-label=".form-select-sm" aria-describedby="regionHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code']) || isset($ets)){
                foreach ($regions AS $region){ ?>
                    <option value="<?= $region['code'] ?>" <?php if ($ets['code_region'] == $region['code']){ echo 'selected'; } ?>><?= $region['nom'] ?></option>
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
                if (isset($_POST['code']) || isset($ets)){
                    foreach ($departements AS $departement){ ?>
                        <option value="<?= $departement['code'] ?>" <?php if ($ets['code_departement'] == $departement['code']){ echo 'selected'; } ?>><?= $departement['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="departementHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="commune_input" class="form-label"><strong class="text-primary">Commune</strong></label>
            <select class="form-select form-select-sm" id="commune_input" aria-label=".form-select-sm" aria-describedby="communeHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code']) || isset($ets)){
                    foreach ($communes AS $commune){ ?>
                        <option value="<?= $commune['code'] ?>" <?php if ($ets['code_commune'] == $commune['code']){ echo 'selected'; } ?>><?= $commune['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="communeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_postale_input" class="form-label">Adresse postale</label>
            <input type="text" class="form-control form-control-sm" id="adresse_postale_input" value="<?php if (isset($_POST['code']) || isset($ets)){ echo $ets['adresse_postale']; } ?>" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
            <div id="adressePostaleHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="latitude_input" class="form-label">Latitude</label>
            <input type="text" class="form-control form-control-sm" id="latitude_input" value="<?php if (isset($_POST['code']) || isset($ets)){ echo $ets['latitude']; } ?>" maxlength="5" placeholder="Latitude" aria-describedby="latitudeHelp" autocomplete="off">
            <div id="latitudeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="longitude_input" class="form-label">longitude</label>
            <input type="text" class="form-control form-control-sm" id="longitude_input" value="<?php if (isset($_POST['code']) || isset($ets)){ echo $ets['longitude']; } ?>" maxlength="100" placeholder="Longitude" aria-describedby="longitudeHelp" autocomplete="off">
            <div id="longitudeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_geo_input" class="form-label">Adresse geographique</label>
            <textarea class="form-control form-control-sm" id="adresse_geo_input" maxlength="100" placeholder="Adresse geographique" aria-describedby="adresseGeoHelp" autocomplete="off"><?php if (isset($_POST['code']) || isset($ets)){ echo $ets['adresse_geographique']; } ?></textarea>
            <div id="adresseGeoHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>