<p id="p_mot_de_passe_resultats"></p>
<form id="form_mot_de_passe">
    <div class="mb-3">
        <label for="actuel_mot_de_passe_input" class="form-label">Mot de passe actuel</label>
        <input type="password" class="form-control form-control-sm" id="actuel_mot_de_passe_input" placeholder="Mot de passe actuel" aria-describedby="passwordHelp" autocomplete="off">
        <div id="passwordHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="nouveau_mot_de_passe_input" class="form-label">Nouveau mot de passe</label>
        <input type="password" class="form-control form-control-sm" id="nouveau_mot_de_passe_input" placeholder="Nouveau mot de passe" aria-describedby="passwordNewHelp" autocomplete="off">
        <div id="passwordNewHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="confirmer_mot_de_passe_input" class="form-label">Confirmer mot de passe</label>
        <input type="password" class="form-control form-control-sm" id="confirmer_mot_de_passe_input" placeholder="Confirmer mot de passe" aria-describedby="passwordNewConfirmHelp" autocomplete="off">
        <div id="passwordNewConfirmHelp" class="form-text"></div>
    </div>
    <div class="d-grid gap-2">
        <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block">Enregistrer</button>
    </div>
</form>