<p id="p_assure_resultats"></p>
<form id="form_assure">
    <div class="row">
        <div class="col-sm">
            <fieldset style="margin-top: -53px">
                <legend>Identification</legend>
                <div class="row">
                    <div class="col-sm">
                        <label for="nip_input" class="form-label">NIP</label>
                        <input type="text" class="form-control form-control-sm" id="nip_input" value="<?= isset($assure)? $assure['num_population']: null;?>" placeholder="NIP" aria-describedby="nipHelp" autocomplete="off" maxlength="16" readonly>
                        <div id="nipHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm">
                        <label for="num_rgb_input" class="form-label">N° sécu</label>
                        <input type="text" class="form-control form-control-sm" id="num_rgb_input" value="<?= isset($assure)? $assure['num_rgb']: null;?>" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="20">
                        <div id="numSecuHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="code_civilite_input" class="form-label"><strong class="text-primary">Civilité</strong></label>
                        <select class="form-select form-select-sm" id="code_civilite_input"  aria-label=".form-select-sm" aria-describedby="codeCiviliteHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($civilites as $civilite) {
                                ?>
                                <option value="<?= $civilite['code'];?>" <?= (isset($assure) && $assure['code_civilite'] === $civilite['code'])? "selected": null;?>><?= $civilite['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeCiviliteHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="prenoms_input" class="form-label"><strong class="text-primary">Prénom(s)</strong></label>
                        <input type="text" class="form-control form-control-sm" id="prenoms_input" value="<?= isset($assure)? $assure['prenom']: null;?>" placeholder="Prénom(s)" aria-describedby="prenomsHelp" autocomplete="off" maxlength="50">
                        <div id="prenomsHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="nom_input" class="form-label"><strong class="text-primary">Nom de famille</strong></label>
                        <input type="text" class="form-control form-control-sm" id="nom_input" value="<?= isset($assure)? $assure['nom']: null;?>" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
                        <div id="nomHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="nom_patronymique_input" class="form-label">Nom patronymique</label>
                        <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" value="<?= isset($assure)? $assure['nom_patronymique']: null;?>" placeholder="Nom patronymique" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
                        <div id="nomHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="date_naissance_input" class="form-label"><strong class="text-primary">Date naissance</strong></label>
                        <input type="text" class="form-control form-control-sm date" id="date_naissance_input" value="<?= isset($assure)? date('d/m/Y', strtotime($assure['date_naissance'])): null;?>" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10" readonly>
                        <div id="dateNaissanceHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_sexe_input" class="form-label"><strong class="text-primary">Sexe</strong></label>
                        <select class="form-select form-select-sm" id="code_sexe_input" aria-label=".form-select-sm" aria-describedby="codeSexeHelp" >
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($sexes as $sexe) {
                                ?>
                                <option value="<?= $sexe['code'];?>" <?= (isset($assure) && $assure['code_sexe'] === $sexe['code'])? "selected": null;?>><?= $sexe['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeSexeHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="situation_matrimoniale_input" class="form-label"><strong class="text-primary">Situation matrimoniale</strong></label>
                        <select class="form-select form-select-sm" id="situation_matrimoniale_input"  aria-label=".form-select-sm" aria-describedby="situationMatrimonialeHelp" >
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($situations_familiales as $situation_familiale) {
                                ?>
                                <option value="<?= $situation_familiale['code'];?>" <?= (isset($assure) && $assure['code_situation_familiale'] === $situation_familiale['code'])? "selected": null;?>><?= $situation_familiale['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="situationMatrimonialeHelp" class="form-text"></div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Naissance</legend>
                <div class="row">
                    <div class="col-md-6">
                        <label for="code_nationnalite_input" class="form-label"><strong class="text-primary">Nationnalité</strong></label>
                        <select class="form-select form-select-sm" id="code_nationnalite_input" aria-label=".form-select-sm" aria-describedby="codeNationnaliteHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($Pays as $nationalite) {
                                ?>
                                <option value="<?= $nationalite['code'];?>" <?= (isset($assure) && $assure['code_nationalite'] === $nationalite['code'])? "selected": null;?>><?= $nationalite['gentile'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeNationnaliteHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="code_pays_naissance_input" class="form-label"><strong class="text-primary">Pays</strong></label>
                        <select class="form-select form-select-sm" id="code_pays_naissance_input" aria-label=".form-select-sm" aria-describedby="codePaysNaissanceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($Pays as $pays_naissance) {
                                ?>
                                <option value="<?= $pays_naissance['code'];?>" <?= (isset($assure) && $assure['code_pays_naissance'] === $pays_naissance['code'])? "selected": null;?>><?= $pays_naissance['nom'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codePaysNaissanceHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_region_naissance_input" class="form-label">Région</label>
                        <select class="form-select form-select-sm" id="code_region_naissance_input" aria-label=".form-select-sm" aria-describedby="codeRegionNaissanceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            if($region_n_p) {
                                foreach ($regions_naissance as $region_naissance) {
                                    ?>
                                    <option value="<?= $region_naissance['code'];?>" <?= ($region_naissance['code'] == $region_n_p['code'])? 'selected':null;?>><?= $region_naissance['nom'];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div id="codeRegionNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="code_departement_naissance_input" class="form-label">Département</label>
                        <select class="form-select form-select-sm" id="code_departement_naissance_input" aria-label=".form-select-sm" aria-describedby="codeDepartementNaissanceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            if($departement_n_p) {
                                foreach ($departements_naissance as $departement_naissance) {
                                    ?>
                                    <option value="<?= $departement_naissance['code'];?>" <?= ($departement_naissance['code'] == $departement_n_p['code'])? 'selected':null;?>><?= $departement_naissance['nom'];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div id="codeDepartementNaissanceHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_commune_naissance_input" class="form-label">Commune</label>
                        <select class="form-select form-select-sm" id="code_commune_naissance_input" aria-label=".form-select-sm" aria-describedby="codeCommuneNaissanceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            if($commune_n_p) {
                                foreach ($communes_naissance as $commune_naissance) {
                                    ?>
                                    <option value="<?= $commune_naissance['code'];?>" <?= ($commune_naissance['code'] == $commune_n_p['code'])? 'selected':null;?>><?= $commune_naissance['nom'];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div id="codeCommuneNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="lieu_naissance_input" class="form-label">Lieu de naissance</label>
                        <input type="text" class="form-control form-control-sm" id="lieu_naissance_input" value="<?= isset($assure)? $assure['lieu_naissance']: null;?>" placeholder="Lieu de naissance" aria-describedby="lieuNaissanceHelp" autocomplete="off" maxlength="255" >
                        <div id="lieuNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div><br />
    <div class="row">
        <div class="col-sm">
            <fieldset>
                <legend>Résidence</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="code_pays_residence_input" class="form-label"><strong class="text-primary">Pays</strong></label>
                        <select class="form-select form-select-sm" id="code_pays_residence_input" aria-label=".form-select-sm" aria-describedby="codePaysResidenceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($Pays as $pays_residence) {
                                ?>
                                <option value="<?= $pays_residence['code'];?>" <?= ($assure['code_pays_residence'] === $pays_residence['code'])? "selected": null;?>><?= $pays_residence['nom'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codePaysResidenceHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm-6">
                        <label for="code_region_residence_input" class="form-label"><strong class="text-primary">Région</strong></label>
                        <select class="form-select form-select-sm" id="code_region_residence_input" aria-label=".form-select-sm" aria-describedby="codeRegionResidenceHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            if($region_r_p) {
                                foreach ($regions_residence as $region_residence) {
                                    ?>
                                    <option value="<?= $region_residence['code'];?>" <?= ($region_residence['code'] == $region_r_p['code'])? 'selected':null;?>><?= $region_residence['nom'];?></option>
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
                            if($departement_r_p) {
                                foreach ($departements_residence as $departement_residence) {
                                    ?>
                                    <option value="<?= $departement_residence['code'];?>" <?= ($departement_residence['code'] == $departement_r_p['code'])? 'selected':null;?>><?= $departement_residence['nom'];?></option>
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
                            if($commune_r_p) {
                                foreach ($communes_residence as $commune_residence) {
                                    ?>
                                    <option value="<?= $commune_residence['code'];?>" <?= ($commune_residence['code'] == $commune_r_p['code'])? 'selected':null;?>><?= $commune_residence['nom'];?></option>
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
                        <input type="text" class="form-control form-control-sm" id="adresse_postale_input" value="<?= isset($assure)? $assure['adresse_postale']: null;?>" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
                        <div id="adressePostaleHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label for="adresse_geographique_input" class="form-label">Adresse géographique</label>
                        <textarea class="form-control form-control-sm" id="adresse_geographique_input" placeholder="Adresse géographique" aria-describedby="adresseGeoHelp"><?= isset($assure)? $assure['adresse_geographique']: null;?></textarea>
                        <div id="adresseGeoHelp" class="form-text"></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-2 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>