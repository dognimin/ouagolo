<p id="p_utilisateur_resultats"></p>
<form id="form_utilisateur">
    <div class="row">
        <div class="col-md-4">
            <label for="num_secu_input" class="form-label">N° sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" placeholder="N° de sécurité sociale" aria-describedby="numSecuHelp" autocomplete="off" maxlength="20">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="num_matricule_input" class="form-label">N° matricule</label>
            <input type="text" class="form-control form-control-sm" id="num_matricule_input" placeholder="N° matricule professionnel" aria-describedby="numMatriculeHelp" autocomplete="off" maxlength="20">
            <div id="numMatriculeHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="nom_utilisateur_input" class="form-label">Nom utilisateur</label>
            <input type="text" class="form-control form-control-sm" id="nom_utilisateur_input" placeholder="Nom d'utilisateur" aria-describedby="nomUtilisateurHelp" autocomplete="off" maxlength="30">
            <div id="nomUtilisateurHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email_input" class="form-label">Email</label>
            <input type="email" class="form-control form-control-sm" id="email_input" placeholder="Adresse email" aria-describedby="emailHelp" autocomplete="off" maxlength="100">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="civilites_input" class="form-label">Civilité</label>
            <select class="form-select form-select-sm" id="civilites_input" aria-label=".form-select-sm" aria-describedby="civilitesHelp" <?php if($nb_civilites == 0) {echo 'disabled';} ?>>
                <option value="">Sélectionnez</option>
            </select>
            <div id="civilitesHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="nom_input" class="form-label">Nom</label>
            <input type="text" class="form-control form-control-sm" id="nom_input" placeholder="Nom de famille" aria-describedby="nomHelp" autocomplete="off" maxlength="30">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col-md-6">
            <label for="nom_patronymique_input" class="form-label">Nom de jeune fille</label>
            <input type="text" class="form-control form-control-sm" id="nom_patronymique_input" placeholder="Nom patronymique" aria-describedby="nomPatronymiqueHelp" autocomplete="off" maxlength="30">
            <div id="nomPatronymiqueHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="prenoms_input" class="form-label">Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="prenoms_input" placeholder="Prénom(s)" aria-describedby="prenomsHelp" autocomplete="off" maxlength="50">
            <div id="prenomsHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="date_naissance_input" class="form-label">Date naissance</label>
            <input type="text" class="form-control form-control-sm" id="date_naissance_input" placeholder="Date de naissance" aria-describedby="dateNaissanceHelp" autocomplete="off" maxlength="10">
            <div id="dateNaissanceHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="sexes_input" class="form-label">Sexe</label>
            <select class="form-select form-select-sm" id="sexes_input" aria-label=".form-select-sm" aria-describedby="sexesHelp" <?php if($nb_sexes == 0) {echo 'disabled';} ?>>
                <option value="">Sélectionnez</option>
            </select>
            <div id="sexesHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-md-4 d-grid">
            <input type="hidden" id="id_user_input" aria-label="Identifiant utilisateur">
            <button type="submit" id="button_utilisateur" class="btn btn-primary btn-sm">Enregistrer</button>
        </div>
    </div>

</form>