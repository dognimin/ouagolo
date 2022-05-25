<p id="p_acte_medical_resultats"></p>
<form id="form_acte_medical">
    <div class="row">
        <div class="col-sm">
            <label for="code_titre_input" class="form-label">Titres</label>
            <select class="form-select form-select-sm" id="code_titre_input" aria-label=".form-select-sm" aria-describedby="code_titre_input">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($titres as $titre) {
                    echo '<option value="'.$titre['code'].'">'.$titre['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="codeTitreHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_chapitres_input" class="form-label">Chapitres</label>
            <select class="form-select form-select-sm" id="code_chapitres_input" aria-label=".form-select-sm" aria-describedby="code_chapitres_input"></select>
            <div id="codeChapitreeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_sections_input" class="form-label">Sections</label>
            <select class="form-select form-select-sm" id="code_sections_input" aria-label=".form-select-sm" aria-describedby="code_sections_input"></select>
            <div id="codeSectionHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="code_article_input" class="form-label">Articles</label>
            <select class="form-select form-select-sm" id="code_article_input" aria-label=".form-select-sm" aria-describedby="code_article_input"></select>
            <div id="codeArticleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="code_input" class="form-label">Code</label>
            <input type="text" class="form-control form-control-sm" id="code_input" maxlength="7" placeholder="Code" aria-describedby="codeHelp" autocomplete="off" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label">Libellé</label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" maxlength="300" placeholder="Libellé" aria-describedby="libelleHelp" autocomplete="off">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row"  id="dynamic_field">
        <div class="col-sm-9" id="div_lettre_cle_1">
            <label for="code_lettre_cle_1_input" class="form-label">Lettre clé</label>
            <select class="form-select form-select-sm code_lettre"  name="names" id="code_lettre_cle_1_input" aria-label=".form-select-sm" aria-describedby="code_lettre_cle_1_input">
                <option value="">Sélectionnez la lettre clé</option>
                <?php
                foreach ($lettres as $lettre) {
                    echo '<option value="'.$lettre['code'].'">'.$lettre['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="CodeLettreHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2" id="div_coefficient_1">
            <label for="coefficient_1_input" class="form-label">Coefficient</label>
            <input type="text" name="name" placeholder="Coefficient" id="coefficient_1_input" class="form-control form-control-sm coefficient_lettre" autocomplete="off" />
        </div>
        <div class="col-sm-1">
            <label for="button" class="form-label">&nbsp;</label>
            <div class="d-grid gap-2">
                <button type="button" name="add" id="plus_champs" class="btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
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