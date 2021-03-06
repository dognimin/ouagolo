<p id="p_etablissement_coordonnee_resultats"></p>
<form id="form_etablissement_coordonnee">
    <div class="row">
        <div class="col-sm-5">
            <label for="code_type_coordonnee_input" class="form-label">Type coordonnée</label>
            <select class="form-select form-select-sm" id="code_type_coordonnee_input"  aria-label=".form-select-sm" aria-describedby="profilsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types_coordonnees AS $type_coordonnee){ ?>
                    <option value="<?= $type_coordonnee['code'] ?>"><?= $type_coordonnee['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="typeCoordHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="valeur_ets_coordonnee_input" class="form-label">Valeur</label>
            <input type="text" class="form-control form-control-sm" id="valeur_ets_coordonnee_input"  maxlength="100" placeholder="Valeur" aria-describedby="valeurHelp" autocomplete="off">
            <div id="valeurCoordonneeHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">

            <button type="submit" id="button_ets_coordonnees_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" id="button_ets_coordonnees_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>