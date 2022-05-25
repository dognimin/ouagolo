<p id="p_medicament_resultats"></p>
<form id="form_medicament">
    <div class="row">
        <div  class="col-sm-6">
            <label for="code_dci_input" class="form-label"><strong class="text-primary">DCI</strong></label>
            <select class="form-select form-select-sm" id="code_dci_input" aria-label=".form-select-sm" aria-describedby="codeDciHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($dcis as $dci) {
                    echo '<option value="'.$dci['code'].'">'.$dci['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeDciHelp" class="form-text"></div>
        </div>
        <div  class="col-sm-6" id="div_medicament_forme"></div>
    </div>
    <div id="div_medicament_groupe_classe"></div>
    <div class="row" id="div_medicament_dosage"></div>
    <div class="row">
        <div class="col-sm-6">
            <label for="code_type_input" class="form-label"><strong class="text-primary">Type</strong></label>
            <select class="form-select form-select-sm" id="code_type_input" aria-label=".form-select-sm" aria-describedby="codeTypeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types as $type) {
                    echo '<option value="'.$type['code'].'">'.$type['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeTypeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="20" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col-sm-3">
            <label for="code_ean13_input" class="form-label">Code EAN13</label>
            <input type="text" class="form-control form-control-sm" id="code_ean13_input" maxlength="15" placeholder=" Code AEN13" aria-describedby="aen13Help" autocomplete="off">
            <div id="codeEan13Help" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="code_laboratoire_input" class="form-label"><strong class="text-primary">Laboratoire Pharmaceutique</strong></label>
            <select class="form-select form-select-sm" id="code_laboratoire_input" aria-label=".form-select-sm" aria-describedby="codeLaboratoireHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($laboratoires as $laboratoire) {
                    echo '<option value="'.$laboratoire['code'].'">'.$laboratoire['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeLaboratoireHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">

    </div>

    <div class="row">
        <div  class="col">
            <label for="code_conditionnement_primaire_input" class="form-label"><strong class="text-primary">Conditionnement primaire</strong></label>
            <select class="form-select form-select-sm" id="code_conditionnement_primaire_input" aria-label=".form-select-sm" aria-describedby="codeConditionnementPrimaireHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($presentations as $primaire) {
                    echo '<option value="'.$primaire['code'].'">'.$primaire['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeConditionnementPrimaireHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="code_conditionnement_secondaire_input" class="form-label">Conditionnement secondaire</label>
            <select class="form-select form-select-sm" id="code_conditionnement_secondaire_input" aria-label=".form-select-sm" aria-describedby="codeConditionnementSecondaireHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($presentations as $secondaire) {
                    echo '<option value="'.$secondaire['code'].'">'.$secondaire['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeConditionnementSecondaireHelp" class="form-text"></div>
        </div>

    </div>
    <hr />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>