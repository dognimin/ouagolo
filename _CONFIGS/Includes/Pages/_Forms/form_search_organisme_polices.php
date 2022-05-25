<form id="form_search_organisme_polices">
    <div class="row">
        <div class="col-sm-2">
            <label for="date_debut_search_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date_passee" id="date_debut_search_input" value="<?= date('d/m/Y', strtotime('-1 MONTH', time()));?>" placeholder="Date début" aria-describedby="dateDebutSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateDebutSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="date_fin_search_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date_passee" id="date_fin_search_input" value="<?= date('d/m/Y', time());?>" placeholder="Date fin" aria-describedby="dateFinSearchHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinSearchHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="numero_police_input" class="form-label">N° Police</label>
            <input type="text" class="form-control form-control-sm" id="numero_police_input" maxlength="20" placeholder="N° Police" aria-describedby="numeroPoliceHelp" autocomplete="off">
            <div id="numeroPoliceHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_police_input" class="form-label">Nom de la police</label>
            <input type="text" class="form-control form-control-sm" id="nom_police_input" maxlength="100" placeholder="Nom de la police" aria-describedby="nomPoliceHelp" autocomplete="off">
            <div id="nomPoliceHelp" class="form-text"></div>
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