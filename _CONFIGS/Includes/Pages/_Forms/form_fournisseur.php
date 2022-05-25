<p id="p_fournisseur_resultats"></p>
<form id="form_fournisseur">
    <div class="row">
        <div class="col-sm-6">
            <label for="code_input" class="form-label">Code du fournisseur</label>
            <input type="text" class="form-control form-control-sm" id="code_input" placeholder="Code du fournisseur" aria-describedby="codeHelp" autocomplete="off" maxlength="8" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Raison sociale</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" placeholder="Raison sociale du fournisseur" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm">
            <label for="pays_input" class="form-label"><strong class="text-primary">Pays</strong></label>
            <select class="form-select form-select-sm" id="pays_input" aria-label=".form-select-sm" aria-describedby="paysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($payss as $pays) {
                    ?>
                    <option value="<?= $pays['code'] ?>"><?= $pays['nom'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="paysHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="region_input" class="form-label"><strong class="text-primary">Région</strong></label>
            <select class="form-select form-select-sm" id="region_input" aria-label=".form-select-sm" aria-describedby="regionHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code'])) {
                    foreach ($regions as $region) {
                        ?>
                        <option value="<?= $region['code'] ?>"><?= $region['nom'] ?></option>
                        <?php
                    }
                }
                ?>
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
                if (isset($_POST['code'])) {
                    foreach ($departements as $departement) {
                        ?>
                        <option value="<?= $departement['code'] ?>"><?= $departement['nom'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div id="departementHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="commune_input" class="form-label"><strong class="text-primary">Commune</strong></label>
            <select class="form-select form-select-sm" id="commune_input" aria-label=".form-select-sm" aria-describedby="communeHelp">
                <option value="">Sélectionnez</option>
                <?php
                if (isset($_POST['code'])) {
                    foreach ($communes as $commune) {
                        ?>
                        <option value="<?= $commune['code'] ?>"><?= $commune['nom'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div id="communeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_postale_input" class="form-label">Adresse postale</label>
            <input type="text" class="form-control form-control-sm" id="adresse_postale_input" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
            <div id="adressePostaleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="adresse_geo_input" class="form-label">Adresse geographique</label>
            <textarea class="form-control form-control-sm" id="adresse_geo_input" maxlength="100" placeholder="Adresse geographique" aria-describedby="adresseGeoHelp" autocomplete="off"></textarea>
            <div id="adresseGeoHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="email_input" class="form-label"><strong class="text-primary">Adresse Email</strong></label>
            <input type="text" class="form-control form-control-sm" id="email_input" maxlength="100" placeholder="Adresse Email" aria-describedby="emailHelp" autocomplete="off">
            <div id="emailHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="num_telephone_1_input" class="form-label"><strong class="text-primary">N° Téléphone 1</strong></label>
            <input type="text" class="form-control form-control-sm" id="num_telephone_1_input" maxlength="10" placeholder="N° Téléphone 1" aria-describedby="numtelephone1Help" autocomplete="off">
            <div id="numtelephone1Help" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="num_telephone_2_input" class="form-label">N° Téléphone 2</label>
            <input type="text" class="form-control form-control-sm" id="num_telephone_2_input" maxlength="10" placeholder="N° téléphone 2" aria-describedby="numtelephone2Help" autocomplete="off">
            <div id="numtelephone2Help" class="form-text"></div>
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
