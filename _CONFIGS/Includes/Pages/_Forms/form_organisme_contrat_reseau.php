<p id="p_organisme_contrat_reseau_resultats"></p>
<form id="form_organisme_contrat_reseau">
    <div class="row">
        <div class="col-sm">
            <label for="code_reseau_input" class="form-label"><strong class="text-primary">Réseau</strong></label>
            <select class="form-select form-select-sm" id="code_reseau_input" aria-label=".form-select-sm" aria-describedby="paysHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($reseaux AS $reseau){ ?>
                    <option value="<?= $reseau['code'] ?>" <?php if($contrat_reseau && $reseau['code'] == $contrat_reseau['code']){echo 'selected';}?>><?= $reseau['libelle'] ?></option>
                <?php } ?>
            </select>
            <div id="paysHelp" class="form-text"></div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_enregistrer_reseau" class="btn btn-primary btn-sm"><i
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