<form id="form_search_ets_factures">
    <div class="row">
        <div class="col-sm">
            <label for="date_debut_search_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_search_input" placeholder="Date début" value="<?= date('d/m/Y',strtotime('-1 WEEK',time()));?>" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutSearchHelp>" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="date_fin_search_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_search_input" placeholder="Date fin" value="<?= date('d/m/Y',time());?>" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="num_facture_search_input" class="form-label">N° Facture</label>
            <input type="text" class="form-control form-control-sm" id="num_facture_search_input" maxlength="20" placeholder="Numéro facture" aria-describedby="numFactureHelp" autocomplete="off">
            <div id="numFactureHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="num_secu_search_input" class="form-label">N° Sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_search_input" maxlength="20" placeholder="Numéro Sécu" aria-describedby="numSecuHelp" autocomplete="off">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nip_search_input" class="form-label">NIP</label>
            <input type="text" class="form-control form-control-sm" id="nip_search_input" maxlength="100" placeholder="Numéro d'identification..." aria-describedby="nipSearchHelp" autocomplete="off">
            <div id="nipSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="nom_prenoms_input" class="form-label">Nom & prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="nom_prenoms_input" placeholder="Nom & prénom(s)" aria-describedby="nomPrenomsHelp" autocomplete="off">
            <div id="nomPrenomsHelp" class="form-text"></div>
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