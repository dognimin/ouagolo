<p id="p_college_resultats"></p>
<form id="form_college">
    <div class="row">
        <div class="col-sm">
            <label for="num_police_input" class="form-label"><strong class="text-primary">Libellé de la police</strong></label>
            <select class="form-select form-select-sm" id="num_police_input" name="state" aria-label=".form-select-sm" aria-describedby="numPoliceHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($polices as $police) {
                    echo '<option value="'.$police['id_police'].'">'.$police['nom'].'</option>';
                }
                ?>
            </select>



            <div id="numPoliceHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label for="code_input" class="form-label">Code du college</label>
            <input type="text" class="form-control form-control-sm" id="code_input" value="<?= isset($college)? $college['code']: null;?>" placeholder="Code du college" aria-describedby="codeHelp" autocomplete="off" maxlength="24" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé du college</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" value="<?= isset($college)? $college['libelle']: null;?>" placeholder="Libellé du college" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="description_input" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" id="description_input" placeholder="Description" aria-describedby="descriptionHelp" autocomplete="off"><?= isset($college)? $college['description']: null;?></textarea>
            <div id="descriptionHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>
    </div>
</form>