<form id="form_search_commandes">
    <div class="row">
        <div class="col-sm-2">
            <label for="date_debut_search_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_search_input" placeholder="Date début" value="<?= date('d/m/Y',strtotime('-1 WEEK',time()));?>" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutSearchHelp>" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_fin_search_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_search_input" placeholder="Date fin" value="<?= date('d/m/Y',time());?>" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_commande_search_input" class="form-label">Réf.</label>
            <input type="text" class="form-control form-control-sm" id="code_commande_search_input" maxlength="20" placeholder="Code commande" aria-describedby="codeCommandeSearchHelp" autocomplete="off">
            <div id="codeCommandeSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="statut_search_input" class="form-label">Statut</label>
            <select class="form-select form-select-sm" id="statut_search_input"  aria-label=".form-select-sm" aria-describedby="natureHelp">
                <option value="">Sélectionnez</option>
                <option value="C">EN COURS</option>
                <option value="R">RECEPTIONNE</option>
                <option value="A">ANNULE</option>
            </select>
            <div id="statutHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_fournisseur_search_input" class="form-label">Fournisseur</label>
            <select class="form-select form-select-sm" id="code_fournisseur_search_input"  aria-label=".form-select-sm" aria-describedby="natureHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="natureHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>