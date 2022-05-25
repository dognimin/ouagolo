<form id="form_search_ticket">
    <div class="row">
        <div class="col-sm-2">
            <label for="num_ticket_input" class="form-label">N° Ticket</label>
            <input type="text" class="form-control form-control-sm" id="num_ticket_input" placeholder="N° Ticket" aria-describedby="numTicketHelp" autocomplete="off">
            <div id="numTicketHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="code_type_input" class="form-label">Type</label>
            <select class="form-select form-select-sm" id="code_type_input"  aria-label=".form-select-sm" aria-describedby="codeTypeHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeTypeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_categorie_input" class="form-label">Catégorie</label>
            <select class="form-select form-select-sm" id="code_categorie_input"  aria-label=".form-select-sm" aria-describedby="codeCategorieHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeCategorieHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="code_statut_input" class="form-label">Statut</label>
            <select class="form-select form-select-sm" id="code_statut_input"  aria-label=".form-select-sm" aria-describedby="codeStatutHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeStatutHelp" class="form-text"></div>
        </div>
        <div class="col-sm-1">
            <label for="libelle_input" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" name="search" id="btn_search" class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button>
                </div>

            </div>
        </div>
    </div>
</form>
<div id="div_resultats"></div>