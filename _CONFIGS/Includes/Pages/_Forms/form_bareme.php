<p id="p_bareme_resultats"></p>
<form id="form_bareme">
    <div class="row">
        <div class="col-sm-6">
            <label for="code_input" class="form-label">Code </label>
            <input type="text" class="form-control form-control-sm" id="code_input" value="<?= isset($bareme)? $bareme['code']: null;?>" placeholder="Code du gabarit" aria-describedby="codeHelp" autocomplete="off" maxlength="10" readonly>
            <div id="codeHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="libelle_input" class="form-label"><strong class="text-primary">Libellé</strong></label>
            <input type="text" class="form-control form-control-sm" id="libelle_input" value="<?= isset($bareme)? $bareme['libelle']: null;?>" placeholder="Libellé du gabarit" aria-describedby="libelleHelp" autocomplete="off" maxlength="100">
            <div id="libelleHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="description_input" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" id="description_input" maxlength="100" placeholder="Description" aria-describedby="descriptionHelp" autocomplete="off"><?= isset($bareme)? $bareme['description']: null;?></textarea>
            <div id="descriptionHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i
                            class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>