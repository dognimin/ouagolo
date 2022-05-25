<p id="p_patient_resultats"></p>
<form id="form_patient">
    <fieldset>
        <legend style="margin-top: -20px; border-top: none">Assurance</legend>
        <div class="row">
            <div class="col-sm">
                <label for="code_organisme_input" class="form-label"><strong class="text-primary">Organisme</strong></label>
                <select class="form-select form-select-sm" id="code_organisme_input" aria-label=".form-select-sm" aria-describedby="codeOrganismeHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($assurances AS $assurance){
                        ?>
                        <option value="<?= $assurance['code'] ?>"><?= $assurance['libelle'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div id="codeOrganismeHelp" class="form-text"></div>
            </div>
            <div class="col-sm-4">
                <label for="num_assure_input" class="form-label">N° assuré</label>
                <input type="text" class="form-control form-control-sm" id="num_assure_input" placeholder="N° assuré" aria-describedby="numAssureHelp" autocomplete="off" maxlength="16">
                <div id="numAssureHelp" class="form-text"></div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Identification</legend>
        <div class="row">
            <div class="col-md-4">
                <label for="nip_input" class="form-label">NIP</label>
                <input type="text" class="form-control form-control-sm" id="nip_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['num_population']; } ?>" placeholder="NIP" aria-describedby="nipHelp" autocomplete="off" maxlength="16" readonly>
                <div id="nipHelp" class="form-text"></div>
            </div>
            <div class="col-md-4">
                <label for="num_secu_input" class="form-label">N° sécu</label>
                <input type="text" class="form-control form-control-sm" id="num_secu_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['num_rgb']; } ?>" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="13">
                <div id="numSecuHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="code_civilite_input" class="form-label"><strong class="text-primary">Civilité</strong></label>
                <select class="form-select form-select-sm" id="code_civilite_input"  aria-label=".form-select-sm" aria-describedby="codeCiviliteHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($civilites AS $civilite){ ?>
                        <option value="<?= $civilite['code'] ?>" <?php if (isset($_POST['num_patient']) && $patient['code_civilite'] == $civilite['code']){ echo 'selected'; } ?>><?= $civilite['libelle'] ?></option>
                    <?php } ?>
                </select>
                <div id="codeCiviliteHelp" class="form-text"></div>
            </div>
            <div class="col-md">
                <label for="nom_input" class="form-label"><strong class="text-primary">Nom</strong></label>
                <input type="text" class="form-control form-control-sm" id="nom_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['nom']; } ?>" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
                <div id="nomHelp" class="form-text"></div>
            </div>
            <div class="col-md">
                <label for="nom_patronymique_input" class="form-label">Nom de jeune fille</label>
                <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['nom_patronymique']; } ?>" placeholder="Nom de jeune fille" aria-describedby="nomPatronymiqueHelp" autocomplete="off" maxlength="30">
                <div id="nomPatronymiqueHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="prenom_input" class="form-label"><strong class="text-primary">Prénom(s)</strong></label>
                <input type="text" class="form-control form-control-sm" id="prenom_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['prenom']; } ?>" placeholder="Prénom(s)" aria-describedby="prenomHelp" autocomplete="off" maxlength="50">
                <div id="prenomHelp" class="form-text"></div>
            </div>
            <div class="col-sm-4">
                <label for="date_naissance_input" class="form-label"><strong class="text-primary">Date naissance</strong></label>
                <input type="text" class="form-control form-control-sm date" id="date_naissance_input" value="<?php if (isset($_POST['num_patient'])){ echo date('d/m/Y',strtotime($patient['date_naissance'])); } ?>" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10" readonly>
                <div id="dateNaissanceHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="code_sexe_input" class="form-label"><strong class="text-primary">Sexe</strong></label>
                <select class="form-select form-select-sm" id="code_sexe_input"  aria-label=".form-select-sm" aria-describedby="codeSexeHelp" >
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($sexes AS $sexe){ ?>
                        <option value="<?= $sexe['code'] ?>" <?php if (isset($_POST['num_patient']) && $patient['code_sexe'] == $sexe['code']){ echo 'selected'; } ?>><?= $sexe['libelle'] ?></option>
                    <?php } ?>
                </select>
                <div id="codeSexeHelp" class="form-text"></div>
            </div>
            <div class="col-sm-4">
                <label for="code_situation_matrimoniale_input" class="form-label"><strong class="text-primary">Situation matrimoniale</strong></label>
                <select class="form-select form-select-sm" id="code_situation_matrimoniale_input"  aria-label=".form-select-sm" aria-describedby="codeSituationMatrimonialeHelp" >
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($situations_familiales AS $situation_familiale){ ?>
                        <option value="<?= $situation_familiale['code'] ?>" <?php if (isset($_POST['num_patient']) && $patient['code_situation_familiale'] == $situation_familiale['code']){ echo 'selected'; } ?>><?= $situation_familiale['libelle'] ?></option>
                    <?php } ?>
                </select>
                <div id="codeSituationMatrimonialeHelp" class="form-text"></div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Résidence</legend>
        <div class="row">
            <div class="col-sm-6">
                <label for="code_pays_residence_input" class="form-label"><strong class="text-primary">Pays</strong></label>
                <select class="form-select form-select-sm" id="code_pays_residence_input" aria-label=".form-select-sm" aria-describedby="codePaysResidenceHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($Pays AS $pays){
                        ?>
                        <option value="<?= $pays['code'] ?>" <?php if (isset($_POST['num_patient']) && $patient['code_pays_residence'] == $pays['code']){ echo 'selected'; } ?>><?= $pays['nom'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div id="codePaysResidenceHelp" class="form-text"></div>
            </div>
            <div class="col-sm-6">
                <label for="code_region_residence_input" class="form-label"><strong class="text-primary">Region</strong></label>
                <select class="form-select form-select-sm" id="code_region_residence_input" aria-label=".form-select-sm" aria-describedby="codeRegionResidenceHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    if(isset($_POST['num_patient'])) {
                        foreach ($regions as $region) {
                            ?>
                            <option value="<?= $region['code'] ?>" <?php if($patient['code_region_residence'] == $region['code']){ echo 'selected'; } ?>><?= $region['nom'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div id="codeRegionResidenceHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="code_departement_residence_input" class="form-label"><strong class="text-primary">Département</strong></label>
                <select class="form-select form-select-sm" id="code_departement_residence_input" aria-label=".form-select-sm" aria-describedby="codeDepartementResidenceHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    if(isset($_POST['num_patient'])) {
                        foreach ($departements as $departement) {
                            ?>
                            <option value="<?= $departement['code'] ?>" <?php if($patient['code_departement_residence'] == $departement['code']){ echo 'selected'; } ?>><?= $departement['nom'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div id="codeDepartementResidenceHelp" class="form-text"></div>
            </div>
            <div class="col-sm">
                <label for="code_commune_residence_input" class="form-label"><strong class="text-primary">Commune</strong></label>
                <select class="form-select form-select-sm" id="code_commune_residence_input" aria-label=".form-select-sm" aria-describedby="codeCommuneResidenceHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    if(isset($_POST['num_patient'])) {
                        foreach ($communes as $commune) {
                            ?>
                            <option value="<?= $commune['code'] ?>" <?php if($patient['code_commune_residence'] == $commune['code']){ echo 'selected'; } ?>><?= $commune['nom'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div id="codeCommuneResidenceHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="adresse_postale_input" class="form-label">Adresse postale</label>
                <input type="text" class="form-control form-control-sm" id="adresse_postale_input" value="<?php if (isset($_POST['num_patient'])){ echo $patient['adresse_postale']; } ?>" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
                <div id="adressePostaleHelp" class="form-text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <label for="adresse_georaphique_input" class="form-label">Adresse géographique</label>
                <textarea class="form-control form-control-sm" id="adresse_georaphique_input" placeholder="Adresse géographique" aria-describedby="adresseGeoHelp"><?php if (isset($_POST['num_patient'])){ echo $patient['adresse_geographique']; } ?></textarea>
                <div id="adresseGeoHelp" class="form-text"></div>
            </div>
        </div>
    </fieldset>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="code_patient_input" value="<?php if (isset($_POST['code'])){ echo $patient['code_patient']; } ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if(isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-md-6 d-grid">
                        <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>