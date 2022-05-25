<p id="p_utilisateur_resultats"></p>
<form id="form_utilisateur">
    <?php
    if(isset($organisme)) {
        ?>
        <div class="row">
            <div class="col-md-4">
                <label for="code_organisme_input" class="form-label">Organisme</label>
                <select class="form-select form-select-sm" id="code_organisme_input" aria-label=".form-select-sm" aria-describedby="codeOrganismeHelp" disabled>
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($organismes as $organism) {
                        ?>
                        <option value="<?= $organism['code'] ?>" <?php if ($organism['code'] == $organisme['code']) {echo 'selected';} ?>><?= $organism['libelle'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div id="codeOrganismeHelp" class="form-text"></div>
            </div>
            <div class="col-md-4">
                <label for="code_profil_input" class="form-label">Profil</label>
                <select class="form-select form-select-sm" id="code_profil_input" aria-label=".form-select-sm" aria-describedby="codeProfilHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($profils as $profil_u) {
                        if($profil_u['code'] == 'ORGANI') {
                            ?>
                            <option value="<?= $profil_u['code'] ?>" <?= $profil_u['code'] == $profil['code_profil']?'selected':null;?>><?= $profil_u['libelle'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div id="codeProfilHelp" class="form-text"></div>
            </div>
        </div>
        <?php
    }
    if(isset($ets)) {
        ?>
        <div class="row">
            <div class="col">
                <label for="code_etablissement_input" class="form-label">Etablissement</label>
                <select class="form-select form-select-sm" id="code_etablissement_input" aria-label=".form-select-sm" aria-describedby="codeEtablissementHelp" disabled>
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($etablissements as $etablissement) {
                        ?>
                        <option value="<?= $etablissement['code'] ?>" <?= $etablissement['code'] == $ets['code']?'selected':null;?>><?= $etablissement['raison_sociale'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div id="codeEtablissementHelp" class="form-text"></div>
            </div>
            <div class="col-md-4">
                <label for="code_profil_input" class="form-label">Profil</label>
                <select class="form-select form-select-sm" id="code_profil_input" aria-label=".form-select-sm" aria-describedby="codeProfilHelp">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($profils as $profil_u) {
                        if(isset($professionnels)) {
                            if($profil_u['code'] == 'PS') {
                                ?>
                                <option value="<?= $profil_u['code'] ?>" <?= $profil_u['code'] == $profil['code_profil']?'selected':null;?>><?= $profil_u['libelle'] ?></option>
                                <?php
                            }
                        }else {
                            if($profil_u['code'] == 'ETABLI') {
                                ?>
                                <option value="<?= $profil_u['code'] ?>" <?= $profil_u['code'] == $profil['code_profil']?'selected':null;?>><?= $profil_u['libelle'] ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
                <div id="codeProfilHelp" class="form-text"></div>
            </div>
        </div>
        <?php
        if(isset($professionnels)) {
            ?>
            <div class="row">
                <div class="col">
                    <label for="code_specialite_input" class="form-label">Spécialité médicale</label>
                    <select class="form-select form-select-sm" id="code_specialite_input" aria-label=".form-select-sm" aria-describedby="codeSpecialiteHelp">
                        <option value="">Sélectionnez</option>
                        <?php
                        foreach ($specialites_medicales as $specialite_medicale) {
                            if(isset($professionnels)) {
                                ?>
                                <option value="<?= $specialite_medicale['code'] ?>"><?= $specialite_medicale['libelle'] ?></option>
                                <?php
                            }else {
                                if($profil_u['code'] == 'ETABLI') {
                                    ?>
                                    <option value="<?= $profil_u['code'] ?>" <?= $profil_u['code'] == $profil['code_profil']?'selected':null;?>><?= $profil_u['libelle'] ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <div id="codeSpecialiteHelp" class="form-text"></div>
                </div>
                <div class="col-md-4">
                    <label for="code_ps_rgb_input" class="form-label">Code PS RGB</label>
                    <input type="text" class="form-control form-control-sm" id="code_ps_rgb_input" value="" placeholder="Code PS RGB" aria-describedby="codePSRGBHelp" autocomplete="off" maxlength="9">
                    <div id="codePSRGBHelp" class="form-text"></div>
                </div>
            </div>
            <?php
        }
    }
    ?>
    <div class="row">
        <div class="col-md-4">
            <label for="num_secu_input" class="form-label">N° sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['num_secu'];}?>" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="20">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="civilites_input" class="form-label">Civilité</label>
            <select class="form-select form-select-sm" id="civilites_input" aria-label=".form-select-sm"
                    aria-describedby="civilitesHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($civilites as $civilite) {
                    ?>
                    <option value="<?= $civilite['code'] ?>" <?php if ((isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') && $utilisateur['code_civilite'] == $civilite['code']) {echo 'selected';}?>><?= $civilite['libelle'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="civilitesHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="sexes_input" class="form-label">Sexe</label>
            <select class="form-select form-select-sm" id="sexes_input" aria-label=".form-select-sm"
                    aria-describedby="sexesHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($sexes as $sexe) {
                    ?>
                    <option value="<?= $sexe['code'] ?>" <?php if ((isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') && $utilisateur['code_sexe'] == $sexe['code']) {echo 'selected';} ?>><?= $sexe['libelle'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div id="sexesHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <?php
        if(isset($professionnels)) {
            ?>
            <div class="col-md-4">
                <label for="code_ps_input" class="form-label">Code PS</label>
                <input type="text" class="form-control form-control-sm" id="code_ps_input" value="" placeholder="Code PS" aria-describedby="codePSHelp" autocomplete="off" maxlength="9" readonly>
                <div id="codePSHelp" class="form-text"></div>
            </div>
            <?php
        }
        ?>
        <div class="col">
            <label for="email_input" class="form-label">Email</label>
            <input type="email" class="form-control form-control-sm" id="email_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['email'];}?>" placeholder="Adresse email" aria-describedby="emailHelp" autocomplete="off" maxlength="100">
            <div id="emailHelp" class="form-text"></div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="nom_input" class="form-label">Nom</label>
            <input type="text" class="form-control form-control-sm" id="nom_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['nom'];} ?>" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col-md-6">
            <label for="nom_patronymique_input" class="form-label">Nom de jeune fille</label>
            <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['nom_patronymique'];} ?>" placeholder="Nom patronymique" aria-describedby="nomPatronymiqueHelp" autocomplete="off" maxlength="30">
            <div id="nomPatronymiqueHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="prenoms_input" class="form-label">Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="prenoms_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['prenoms'];}?>" placeholder="Prénom(s)" aria-describedby="prenomsHelp" autocomplete="off" maxlength="50">
            <div id="prenomsHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="date_naissance_input" class="form-label">Date naissance</label>
            <input type="text" class="form-control form-control-sm date" id="date_naissance_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo date('d/m/Y', strtotime($utilisateur['date_naissance']));} ?>" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateNaissanceHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="id_user_input" value="<?php if (isset($_POST['uid']) || ACTIVE_URL == URL.'_CONFIGS/Includes/Pages/Profil.php') {echo $utilisateur['id_user'];} ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_utilisateur" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if (isset($_SESSION['nouvelle_session'])) {
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