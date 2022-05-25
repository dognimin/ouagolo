<form id="form_search_ets_ecritures_comptables">
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
            <label for="num_piece_search_input" class="form-label">N° Pièce</label>
            <input type="text" class="form-control form-control-sm" id="num_piece_search_input" maxlength="20" placeholder="Numéro pièce" aria-describedby="numPieceHelp" autocomplete="off">
            <div id="numPieceHelp" class="form-text"></div>
        </div>
        <div class="col-sm-6">
            <label for="libelle_piece_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_piece_input" placeholder="Libellé de la pièce" aria-describedby="libellePieceHelp" autocomplete="off">
            <div id="libellePieceHelp" class="form-text"></div>
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