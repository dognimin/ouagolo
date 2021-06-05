<p id="p_medicament_resultats"></p>
<form id="form_medicament">
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="7" placeholder="Code" aria-describedby="codeHelp" autocomplete="off">
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="100" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="forme_codet" class="form-label">Formes</label>
            <select class="form-select form-select-sm" id="forme_code" aria-label=".form-select-sm" aria-describedby="formeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($formes as $forme) {
                    echo '<option value="'.$forme['code'].'">'.$forme['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="formeHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="aen13_code" class="form-label">Code EAN13</label>
            <input type="text" class="form-control form-control-sm" id="aen13_code" maxlength="13" placeholder=" Code AEN13" aria-describedby="aen13Help" autocomplete="off">
            <div id="aen13Help" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="dci_input" class="form-label">DCI</label>
            <select class="form-select form-select-sm" id="dci_input" aria-label=".form-select-sm" aria-describedby="dciHelp">

            </select>
            <div id="dciHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="laboratoire_code" class="form-label">Laboratoire Pharmaceutique</label>
            <select class="form-select form-select-sm" id="laboratoire_code" aria-label=".form-select-sm" aria-describedby="laboHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($laboratoires_pharmaceutiques as $laboratoire_pharmaceutique) {
                    echo '<option value="'.$laboratoire_pharmaceutique['code'].'">'.$laboratoire_pharmaceutique['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="laboHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="classe_therapeuthique_code" class="form-label">Classe therapeutique</label>
            <select class="form-select form-select-sm" id="classe_therapeuthique_code" aria-label=".form-select-sm" aria-describedby="classeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($classes_therapeutiques as $classe_therapeutique) {
                    echo '<option value="'.$classe_therapeutique['code'].'">'.$classe_therapeutique['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="classHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="famille_forme_code" class="form-label">Familles formes</label>
            <select class="form-select form-select-sm" id="famille_forme_code" aria-label=".form-select-sm" aria-describedby="familleFormeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($familles_formes as $famille_forme) {
                    echo '<option value="'.$famille_forme['code'].'">'.$famille_forme['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="familleFormeHelp" class="form-text"></div>
        </div>

    </div>
    <div class="row">
        <div  class="col">
            <label for="forme_administration_code" class="form-label">Formes administrations</label>
            <select class="form-select form-select-sm" id="forme_administration_code" aria-label=".form-select-sm" aria-describedby="formeAdministrationHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($formes_administrations as $forme_administration) {
                    echo '<option value="'.$forme_administration['code'].'">'.$forme_administration['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="formeAdministrationHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="type_medicament_code" class="form-label">Types medicaments</label>
            <select class="form-select form-select-sm" id="type_medicament_code" aria-label=".form-select-sm" aria-describedby="typeMedicamentHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($types_medicaments as $type_medicament) {
                    echo '<option value="'.$type_medicament['code'].'">'.$type_medicament['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="formeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="presentations_code" class="form-label">Presentations</label>
            <select class="form-select form-select-sm" id="presentations_code" aria-label=".form-select-sm" aria-describedby="presentationHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($presentations as $presentaion) {
                    echo '<option value="'.$presentaion['code'].'">'.$presentaion['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="presentationHelp" class="form-text"></div>
        </div>

    </div>
    <div class="row">
        <div  class="col">
            <label for="dosage_input" class="form-label">Dosage</label>
            <input type="text" class="form-control form-control-sm" id="dosage_input" maxlength="20" placeholder="Dosage" aria-describedby="dosageHelp" autocomplete="off">
            <div id="dosageHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="unite_dosage_code" class="form-label">Unité de dosage</label>
            <select class="form-select form-select-sm" id="unite_dosage_code" aria-label=".form-select-sm" aria-describedby="uniteDosageHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($dosages as $dosage) {
                    echo '<option value="'.$dosage['code'].'">'.$dosage['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="uniteDosageHelp" class="form-text"></div>
        </div>

    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>