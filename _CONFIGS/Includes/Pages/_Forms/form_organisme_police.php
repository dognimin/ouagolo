<p id="p_organisme_police_resultats"></p>
<form id="form_organisme_police">
    <div class="row">
        <div class="col-sm">
            <label for="raison_sociale_souscripteur_input" class="form-label"><strong class="text-primary">Raison sociale du souscripteur</strong></label>
            <input id="code_souscripteur_input" aria-label="Code du souscripteur" hidden>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_souscripteur_input" autocapitalize="characters" placeholder="Raison sociale du souscripteur" aria-describedby="raisonSocialeSouscripteurHelp" autocomplete="off" maxlength="150">
            <div id="raisonSocialeSouscripteurHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code de la police</label>
            <input type="text" class="form-control form-control-sm" id="code_input" placeholder="Code de la police" aria-describedby="codeHelp" autocomplete="off" maxlength="20" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" autocapitalize="characters" placeholder="Nom de l'organisme" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="description_input" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" id="description_input" aria-describedby="descriptionHelp" placeholder="Description"></textarea>
            <div id="descriptionHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="date_debut_input" class="form-label"><strong class="text-primary">Date début</strong></label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_input" placeholder="Date début" aria-describedby="dateDebutHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateDebutHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="date_fin_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_input" placeholder="Date fin" aria-describedby="dateFinHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinHelp" class="form-text"></div>
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