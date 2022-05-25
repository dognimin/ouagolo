<form id="form_search_organisme_factures">
    <div class="row">
        <div class="col-sm-2">
            <label for="num_facture_input" class="form-label">N° Facture / N° Bon</label>
            <input type="text" class="form-control form-control-sm" id="num_facture_input" maxlength="20" placeholder="N° Facture / N° Bon" aria-describedby="numFactureHelp" autocomplete="off">
            <div id="numFactureHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="num_secu_input" class="form-label">N° sécu / N° IP</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" maxlength="16" placeholder="N° sécu / N° IP" aria-describedby="numSecuHelp" autocomplete="off">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_prenoms_input" class="form-label">Nom & Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="nom_prenoms_input" maxlength="80" placeholder="Nom & Prénom(s)" aria-describedby="nomPrenomsHelp" autocomplete="off">
            <div id="nomPrenomsHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="raison_sociale_input" class="form-label">Etablissement</label>
            <input type="hidden" value="<?= $_POST['rubrique'] ?? null;?>" id="rubrique_input">
            <input type="hidden" id="code_etablissement_input">
            <input type="text" class="form-control form-control-sm" id="raison_sociale_input" placeholder="Etablissement" aria-describedby="raisonSocialeHelp" autocomplete="off">
            <div id="raisonSocialeHelp" class="form-text"></div>
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