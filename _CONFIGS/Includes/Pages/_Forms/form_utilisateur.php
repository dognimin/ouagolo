<p id="p_utilisateur_resultats"></p>
<form id="form_utilisateur">
    <div class="row">
        <div class="col-md-4">
            <label for="num_secu_input" class="form-label">N° sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['num_secu']; } ?>" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="20">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="num_matricule_input" class="form-label">N° matricule</label>
            <input type="text" class="form-control form-control-sm" id="num_matricule_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['num_matricule']; } ?>" placeholder="N° matricule professionnel" aria-describedby="numMatriculeHelp" autocomplete="off" maxlength="20">
            <div id="numMatriculeHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="nom_utilisateur_input" class="form-label">Nom utilisateur</label>
            <input type="text" class="form-control form-control-sm" id="nom_utilisateur_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['pseudo']; } ?>" placeholder="Nom d'utilisateur" aria-describedby="nomUtilisateurHelp" autocomplete="off" maxlength="30">
            <div id="nomUtilisateurHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email_input" class="form-label">Email</label>
            <input type="email" class="form-control form-control-sm" id="email_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['email']; } ?>"  placeholder="Adresse email" aria-describedby="emailHelp" autocomplete="off" maxlength="100">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="civilites_input" class="form-label">Civilité</label>
            <select class="form-select form-select-sm" id="civilites_input"  aria-label=".form-select-sm" aria-describedby="civilitesHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($civilites AS $civilite){ ?>
                    <option value="<?= $civilite['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['code_civilite'] == $civilite['code']){ echo 'selected'; } ?>><?= $civilite['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="civilitesHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="adresse_geo_input" class="form-label">Adresse geographique</label>
            <input type="text" class="form-control form-control-sm" id="adresse_geo_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['adresse_geographique']; } ?>" maxlength="5" placeholder="Adresse geographique" aria-describedby="adresseGeoHelp" autocomplete="off">
            <div id="adresseGeoHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="adresse_postale_input" class="form-label">Adresse postale</label>
            <input type="text" class="form-control form-control-sm" id="adresse_postale_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['adresse_postal']; } ?>" maxlength="100" placeholder="Adresse postale" aria-describedby="adressePostaleHelp" autocomplete="off">
            <div id="adressePostaleHelp" class="form-text"></div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="nom_input" class="form-label">Nom</label>
            <input type="text" class="form-control form-control-sm" id="nom_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['nom']; } ?>" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col-md-6">
            <label for="nom_patronymique_input" class="form-label">Nom de jeune fille</label>
            <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['nom_patronymique']; } ?>" placeholder="Nom patronymique" aria-describedby="nomPatronymiqueHelp" autocomplete="off" maxlength="30">
            <div id="nomPatronymiqueHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="prenoms_input" class="form-label">Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="prenoms_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['prenoms']; } ?>" placeholder="Prénom(s)" aria-describedby="prenomsHelp" autocomplete="off" maxlength="50">
            <div id="prenomsHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="date_naissance_input" class="form-label">Date naissance</label>
            <input type="text" class="form-control form-control-sm" id="date_naissance_input" value="<?php if (isset($_POST['uid'])){ echo date('d/m/Y',strtotime($utilisateur['date_naissance'])); } ?>" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10">
            <div id="dateNaissanceHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <label for="sexes_input" class="form-label">Sexe</label>
            <select class="form-select form-select-sm" id="sexes_input"  aria-label=".form-select-sm" aria-describedby="sexesHelp" >
                <option value="">Sélectionnez</option>
                <?php
                foreach ($sexes AS $sexe){ ?>
                <option value="<?= $sexe['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['code_sexe'] == $sexe['code']){ echo 'selected'; } ?>><?= $sexe['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="sexesHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label for="pays_input" class="form-label">Pays</label>
            <select class="form-select form-select-sm" id="pays_input" aria-label=".form-select-sm" aria-describedby="paysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($Pays AS $pays){ ?>
                    <option value="<?= $pays['code'] ?>" <?php if (isset($_POST['uid']) && $utilisateur['code_pays'] == $pays['code']){ echo 'selected'; } ?>><?= $pays['nom'] ?></option>
                <?php } ?>
            </select>
            <div id="paysHelp" class="form-text"></div>
        </div>
        <div class="col-sm-6">
            <label for="region_input" class="form-label">Region</label>
            <select class="form-select form-select-sm" id="region_input" aria-label=".form-select-sm" aria-describedby="regionHelp">
                <?php
                if (isset($_POST['uid'])){
                    foreach ($regions AS $region){ ?>
                        <option value="<?= $region['code'] ?>" <?php if (isset($_POST['code']) && $utilisateur['code_region'] == $region['code']){ echo 'selected'; } ?>><?= $region['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="regionHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label for="departement_input" class="form-label">Departement</label>
            <select class="form-select form-select-sm" id="departement_input" aria-label=".form-select-sm" aria-describedby="departementHelp">
                <?php
                if (isset($_POST['uid'])){
                    foreach ($departements AS $departement){ ?>
                        <option value="<?= $departement['code'] ?>" <?php if (isset($_POST['code']) && $utilisateur['code_departement'] == $departement['code']){ echo 'selected'; } ?>><?= $departement['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="departementHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="commune_input" class="form-label">Commune</label>
            <select class="form-select form-select-sm" id="commune_input" aria-label=".form-select-sm" aria-describedby="communeHelp">
                <?php
                if (isset($_POST['uid'])){
                    foreach ($communes AS $commune){ ?>
                        <option value="<?= $commune['code'] ?>" <?php if (isset($_POST['code']) && $utilisateur['code_departement'] == $commune['code']){ echo 'selected'; } ?>><?= $commune['nom'] ?></option>
                    <?php } } ?>
            </select>
            <div id="communeHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="id_user_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['id_user']; } ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_utilisateur" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if(isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-md-6 d-grid">
                        <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>