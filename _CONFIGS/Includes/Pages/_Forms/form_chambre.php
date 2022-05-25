<p id="p_chambre_resultats"></p>
<form id="form_chambre">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" value="<?= isset($_POST['code_chambre'])? $chambre['code']: null;?>" id="code_input" maxlength="10" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" value="<?= isset($_POST['code_chambre'])? $chambre['libelle']: null;?>" id="libelle_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <?php
    if (isset($_POST['code_chambre'])) {
        ?>
        <div class="row">
            <div class="col">
                <label for="statut_input" class="form-label"><strong class="text-primary">Statut</strong></label>
                <select class="form-select form-select-sm" id="statut_input"  aria-label=".form-select-sm" aria-describedby="statutHelp">
                    <option value="">Sélectionnez</option>
                    <option value="2" <?= $chambre['date_fin']? 'selected': null;?>>FERME</option>
                    <option value="1" <?= !$chambre['date_fin']? 'selected': null;?>>OUVERT</option>
                </select>
                <div id="statutHelp" class="form-text"></div>
            </div>
        </div>
        <?php
    } else {
        echo '<input id="statut_input" value="0">';
    }
    ?><br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
