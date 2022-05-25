<form id="form_search_colleges">
    <div class="row">
        <div class="col-sm-2">
            <label for="annee_input" class="form-label">Année</label>
            <select class="form-select form-select-sm" id="annee_input" aria-label=".form-select-sm" aria-describedby="codeSecteurCollectiviteHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($annees as $annee) {
                    echo '<option value="'.$annee['annee'].'">'.$annee['annee'].'</option>';
                }
                ?>
            </select>
            <div id="codeSecteurCollectiviteHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_collectivite_recherche_input" class="form-label">Collectivité / Sociétaire</label>
            <input type="hidden" id="code_collectivite_recherche_input" maxlength="100" placeholder="Code">
            <input type="text" class="form-control form-control-sm" id="raison_sociale_collectivite_recherche_input" maxlength="100" placeholder="Raison sociale" aria-describedby="raisonSocialeCollectiviteRechercheHelp" autocomplete="off">
            <div id="raisonSocialeCollectiviteRechercheHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm" title="Recherche"><i class="bi bi-search"></i></button>
                </div>

            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>