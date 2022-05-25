<p id="p_etablissement_factures_bordereau_resultats"></p>
<form id="form_etablissement_factures_bordereau">
    <div class="row">
        <div class="col-sm-3">
            <label for="date_debut_input" class="form-label">Date début</label>
            <input type="text" class="form-control form-control-sm date" id="date_debut_input" placeholder="Date début" value="<?= date('d/m/Y', strtotime('-1 MONTH', time()));?>" aria-describedby="dateDebutHelp" autocomplete="off" maxlength="10" readonly>
            <div id="<dateDebutHelp>" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="date_fin_input" class="form-label">Date fin</label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_input" placeholder="Date fin" value="<?= date('d/m/Y', time());?>" aria-describedby="dateFinHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateFinHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_organisme_input" class="form-label">Organisme</label>
            <select class="form-select form-select-sm" id="code_organisme_input"  aria-label=".form-select-sm" aria-describedby="codeOrganismeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($organismes as $organisme) {
                    if($organisme['code'] !== 'ORG00001') {
                        echo '<option value="'.$organisme['code'].'">'.$organisme['libelle'].'</option>';
                    }
                }
                ?>
            </select>
            <div id="codeOrganismeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_type_facture_input" class="form-label">Type facture</label>
            <select class="form-select form-select-sm" id="code_type_facture_input" aria-label=".form-select-sm" aria-describedby="typeFactureHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types_factures as $type_facture) {
                    echo '<option value="'.$type_facture['code'].'">'.$type_facture['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="typeFactureHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="multiselect" class="form-label">Factures recherchées</label>
            <select class="form-select form-select-sm" id="multiselect" style="height: 200px" multiple aria-label="numFacturesRechercheesHelp"></select>
            <div id="numFacturesRechercheesHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="" class="form-label">&nbsp;</label>
            <div class="row">
                <div class="col">
                    <div class="d-grid gap-2">
                        <button type="button" id="multiselect_rightAll" class="btn btn-sm btn-light"><i class="bi bi-chevron-double-right"></i></button>
                    </div>
                </div>
                <div class="col">
                    <div class="d-grid gap-2">
                        <button type="button" id="multiselect_rightSelected" class="btn btn-sm btn-light"><i class="bi bi-chevron-compact-right"></i></button>
                    </div>
                </div>
            </div><br />
            <div class="row">
                <div class="col">
                    <div class="d-grid gap-2">
                        <button type="button" id="multiselect_leftSelected" class="btn btn-sm btn-light"><i class="bi bi-chevron-compact-left"></i></button>
                    </div>
                </div>
                <div class="col">
                    <div class="d-grid gap-2">
                        <button type="button" id="multiselect_leftAll" class="btn btn-sm btn-light"><i class="bi bi-chevron-double-left"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <label for="multiselect_to" class="form-label">Factures trouvées</label>
            <select class="form-select form-select-sm" id="multiselect_to" style="height: 200px" multiple aria-label="numFacturesTrouveesHelp"></select>
            <div id="numFacturesTrouveesHelp" class="form-text"></div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-sm-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-sm-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
