<p id="p_reseau_etablissement_resultats"></p>
<form id="form_reseau_etablissement">
    <div class="row">
        <div class="col-sm-2">
            <label for="code_input" class="form-label">Code établissement</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="9" placeholder="Code" aria-describedby="codeHelp" autocomplete="off">
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_input" class="form-label">Raison sociale</label>
            <input type="text" class="form-control form-control-sm" id="raison_sociale_input" placeholder="Raison sociale" aria-describedby="raisonSocialeHelp" autocomplete="off">
            <div id="raisonSocialeHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_debut_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm" id="date_debut_input" maxlength="9" placeholder="Date début" aria-describedby="dateDebutHelp" autocomplete="off" readonly>
            <div id="dateDebutHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-2 d-grid">
            <input type="hidden" id="code_reseau_input" value="<?= $reseau['code'];?>" />
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>