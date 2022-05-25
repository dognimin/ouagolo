<p id="p_dci_resultats"></p>
<form id="form_medicaments_dci">
    <div class="row">
        <div  class="col">
            <label for="code_groupe_input" class="form-label"><strong class="text-primary">Groupe</strong></label>
            <select class="form-select form-select-sm" id="code_groupe_input" aria-label=".form-select-sm" aria-describedby="codeGroupeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($groupes as $groupe) {
                    echo '<option value="'.$groupe['code'].'">'.$groupe['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeGroupeHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="code_sous_groupe_input" class="form-label"><strong class="text-primary">Sous-groupe</strong></label>
            <select class="form-select form-select-sm" id="code_sous_groupe_input" aria-label=".form-select-sm" aria-describedby="codeSousGroupeHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeSousGroupeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="code_classe_input" class="form-label"><strong class="text-primary">Classe thérapeutique</strong></label>
            <select class="form-select form-select-sm" id="code_classe_input" aria-label=".form-select-sm" aria-describedby="codeClasseHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($classes as $classe) {
                    echo '<option value="'.$classe['code'].'">'.$classe['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeClasseHelp" class="form-text"></div>
        </div>
        <div  class="col">
            <label for="code_sous_classe_input" class="form-label"><strong class="text-primary">Sous-classe thérapeutique</strong></label>
            <select class="form-select form-select-sm" id="code_sous_classe_input" aria-label=".form-select-sm" aria-describedby="codeSousClasseHelp">
                <option value="">Sélectionnez</option>
            </select>
            <div id="codeSousClasseHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div  class="col">
            <label for="code_forme_input" class="form-label"><strong class="text-primary">Forme</strong></label>
            <select class="form-select form-select-sm" id="code_forme_input" aria-label=".form-select-sm" aria-describedby="codeFormeHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($formes as $forme) {
                    echo '<option value="'.$forme['code'].'">'.$forme['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeFormeHelp" class="form-text"></div>
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
    <div id="div_dosages">
        <div class="row">
            <div  class="col-sm-3">
                <label for="dosage_0_input" class="form-label"><strong class="text-primary">Dosage</strong></label>
                <input type="text" class="form-control form-control-sm dosage_input" id="dosage_0_input" maxlength="5" placeholder="Dosage" aria-describedby="dosage0Help" autocomplete="off">
                <div id="dosage0Help" class="form-text"></div>
            </div>
            <div  class="col-sm-2">
                <label for="code_unite_0_input" class="form-label"><strong class="text-primary">Unité</strong></label>
                <select class="form-select form-select-sm unite_input" id="code_unite_0_input" aria-label=".form-select-sm" aria-describedby="codeUnite0Help">
                    <option value="">Sélectionnez</option>
                    <?php
                    foreach ($unites as $unite) {
                        echo '<option value="'.$unite['code'].'">'.$unite['code'].'</option>';
                    }
                    ?>
                </select>
                <div id="codeUnite0Help" class="form-text"></div>
            </div>
            <div class="col-sm-1">
                <label for="button" class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="button" name="add" id="btn_ajouter_dosage" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                </div>
            </div>
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