<p id="p_assure_contrat_resultats"></p>
<form id="form_assure_contrat">
    <div class="row">
        <div class="col-sm">
            <fieldset style="margin-top: -53px">
                <legend>Identification</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="code_qualite_civile_input" class="form-label"><strong class="text-primary">Qualité civile</strong></label>
                        <select class="form-select form-select-sm" id="code_qualite_civile_input"  aria-label=".form-select-sm" aria-describedby="codeQualiteCivileHelp">
                            <?php
                            foreach ($qualites_civiles as $qualite_civile) {
                                ?>
                                <option value="<?= $qualite_civile['code'];?>" <?= ($qualite_civile['code'] === 'PAY')? 'selected': null;?>><?= $qualite_civile['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeQualiteCivileHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="num_ip_payeur_input" class="form-label">Assuré Payeur</label>
                        <select class="form-select form-select-sm" id="num_ip_payeur_input"  aria-label=".form-select-sm" aria-describedby="numIpPayeurHelp" disabled>
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($assures_payeurs as $assure_payeur) {
                                ?>
                                <option value="<?= $assure_payeur['num_population'];?>"><?= $assure_payeur['num_population'].' - '.$assure_payeur['nom'].' '.$assure_payeur['prenoms']. ' ('.date('d/m/Y', strtotime($assure_payeur['date_naissance'])).')';?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="numIpPayeurHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label for="nip_input" class="form-label">NIP</label>
                        <input type="text" class="form-control form-control-sm" id="nip_input" placeholder="NIP" aria-describedby="nipHelp" autocomplete="off" maxlength="16" readonly>
                        <div id="nipHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm">
                        <label for="num_rgb_input" class="form-label">N° sécu</label>
                        <input type="text" class="form-control form-control-sm" id="num_rgb_input" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="20">
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
                                <option value="<?= $civilite['code'];?>"><?= $civilite['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeCiviliteHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="prenoms_input" class="form-label"><strong class="text-primary">Prénom(s)</strong></label>
                        <input type="text" class="form-control form-control-sm" id="prenoms_input" placeholder="Prénom(s)" aria-describedby="prenomsHelp" autocomplete="off" maxlength="50">
                        <div id="prenomsHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="nom_input" class="form-label"><strong class="text-primary">Nom de famille</strong></label>
                        <input type="text" class="form-control form-control-sm" id="nom_input" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
                        <div id="nomHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="nom_patronymique_input" class="form-label">Nom patronymique</label>
                        <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" placeholder="Nom patronymique" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
                        <div id="nomHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="date_naissance_input" class="form-label"><strong class="text-primary">Date naissance</strong></label>
                        <input type="text" class="form-control form-control-sm date" id="date_naissance_input" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10" readonly>
                        <div id="dateNaissanceHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_sexe_input" class="form-label"><strong class="text-primary">Sexe</strong></label>
                        <select class="form-select form-select-sm" id="code_sexe_input" aria-label=".form-select-sm" aria-describedby="codeSexeHelp" >
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($sexes as $sexe) {
                                ?>
                                <option value="<?= $sexe['code'];?>"><?= $sexe['libelle'];?></option>
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
                                <option value="<?= $situation_familiale['code'];?>"><?= $situation_familiale['libelle'];?></option>
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
                                <option value="<?= $nationalite['code'];?>"><?= $nationalite['gentile'];?></option>
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
                                <option value="<?= $pays_naissance['code'];?>"><?= $pays_naissance['nom'];?></option>
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
                        </select>
                        <div id="codeRegionNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="code_departement_naissance_input" class="form-label">Département</label>
                        <select class="form-select form-select-sm" id="code_departement_naissance_input" aria-label=".form-select-sm" aria-describedby="codeDepartementNaissanceHelp">
                            <option value="">Sélectionnez</option>
                        </select>
                        <div id="codeDepartementNaissanceHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_commune_naissance_input" class="form-label">Commune</label>
                        <select class="form-select form-select-sm" id="code_commune_naissance_input" aria-label=".form-select-sm" aria-describedby="codeCommuneNaissanceHelp">
                            <option value="">Sélectionnez</option>
                        </select>
                        <div id="codeCommuneNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="lieu_naissance_input" class="form-label">Lieu de naissance</label>
                        <input type="text" class="form-control form-control-sm" id="lieu_naissance_input" placeholder="Lieu de naissance" aria-describedby="lieuNaissanceHelp" autocomplete="off" maxlength="255" >
                        <div id="lieuNaissanceHelp" class="form-text"></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div><br />
    <div class="row">
        <div class="col-sm">
            <fieldset>
                <legend>Professionnel</legend>
                <div class="row">
                    <div class="col">
                        <label for="code_csp_input" class="form-label"><strong class="text-primary">Catégorie Professionnelle</strong></label>
                        <select class="form-select form-select-sm" id="code_csp_input" aria-label=".form-select-sm" aria-describedby="codeCSPHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($categories_socio_professionnelles as $categorie_socio_professionnelle) {
                                ?>
                                <option value="<?= $categorie_socio_professionnelle['code'];?>"><?= $categorie_socio_professionnelle['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeCSPHelp" class="form-text"></div>
                    </div>
                    <div class="col">
                        <label for="code_secteur_activite_input" class="form-label">Secteur d'activité</label>
                        <select class="form-select form-select-sm" id="code_secteur_activite_input" aria-label=".form-select-sm" aria-describedby="codeSecteurActiviteHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($secteurs_activites as $secteur_activite) {
                                ?>
                                <option value="<?= $secteur_activite['code'];?>"><?= $secteur_activite['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeSecteurActiviteHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label for="num_matricule_input" class="form-label">N° Matricule</label>
                        <input type="text" class="form-control form-control-sm" id="num_matricule_input" placeholder="N° Matricule" aria-describedby="numMatriculeHelp" autocomplete="off" maxlength="16">
                        <div id="numMatriculeHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm">
                        <label for="code_profession_input" class="form-label">Profession</label>
                        <select class="form-select form-select-sm" id="code_profession_input" aria-label=".form-select-sm" aria-describedby="codeProfessionHelp">
                            <option value="">Sélectionnez</option>
                            <?php
                            foreach ($professions as $profession) {
                                ?>
                                <option value="<?= $profession['code'];?>"><?= $profession['libelle'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div id="codeProfessionHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="raison_sociale_input" class="form-label">Collectivité / Sociétaire</label>
                        <input type="text" class="form-control form-control-sm" id="raison_sociale_input" placeholder="Collectivité / Sociétaire" aria-describedby="raisonSocialeHelp" value="<?php if(isset($contrat)){echo $contrat['raison_sociale'];}?>" autocomplete="off" maxlength="150" <?php if(isset($contrat)){echo 'readonly';}?>>
                        <div id="raisonSocialeHelp" class="form-text"></div>
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
                            foreach ($Pays as $pays_residence) {
                                ?>
                                <option value="<?= $pays_residence['code'];?>"><?= $pays_residence['nom'];?></option>
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
                        </select>
                        <div id="codeRegionResidenceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="code_departement_residence_input" class="form-label"><strong class="text-primary">Département</strong></label>
                        <select class="form-select form-select-sm" id="code_departement_residence_input" aria-label=".form-select-sm" aria-describedby="codeDepartementResidenceHelp">
                            <option value="">Sélectionnez</option>
                        </select>
                        <div id="codeDepartementResidenceHelp" class="form-text"></div>
                    </div>
                    <div class="col-sm">
                        <label for="code_commune_residence_input" class="form-label"><strong class="text-primary">Commune</strong></label>
                        <select class="form-select form-select-sm" id="code_commune_residence_input" aria-label=".form-select-sm" aria-describedby="codeCommuneResidenceHelp">
                            <option value="">Sélectionnez</option>
                        </select>
                        <div id="codeCommuneResidenceHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="adresse_postale_input" class="form-label">Adresse postale</label>
                        <input type="text" class="form-control form-control-sm" id="adresse_postale_input" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
                        <div id="adressePostaleHelp" class="form-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label for="adresse_geographique_input" class="form-label">Adresse géographique</label>
                        <textarea class="form-control form-control-sm" id="adresse_geographique_input" placeholder="Adresse géographique" aria-describedby="adresseGeoHelp"></textarea>
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