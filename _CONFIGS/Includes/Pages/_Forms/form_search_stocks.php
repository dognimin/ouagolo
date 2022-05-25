<form id="form_search_stocks">
    <div class="row">
        <div class="col-sm-2">
            <label for="date_debut_search_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_search_input" placeholder="Date début" value="<?= date('d/m/Y', strtotime('-1 WEEK', time()));?>" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutSearchHelp>" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_fin_search_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_search_input" placeholder="Date fin" value="<?= date('d/m/Y', time());?>" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_produit_search_input" class="form-label">Produit</label>
            <input type="text" class="form-control form-control-sm" id="code_produit_search_input" placeholder="Code produit" aria-describedby="codeProduitSearchHelp" autocomplete="off" readonly>
            <div id="codeProduitSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_produit_search_input" class="form-label">Produit</label>
            <input type="text" class="form-control form-control-sm" id="libelle_produit_search_input" placeholder="Désignation" aria-describedby="libelleProduitSearchHelp" autocomplete="off">
            <div id="libelleProduitSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-sm d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>