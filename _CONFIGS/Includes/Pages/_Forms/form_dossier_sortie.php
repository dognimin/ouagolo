<p id="p_dossier_sortie_resultats"></p>
<form id="form_dossier_sortie">
    <div class="row">
        <div class="col-sm-4">
            <label for="date_fin_soins_input" class="form-label"><strong class="text-primary">Date</strong></label>
            <input type="text" class="form-control form-control-sm date" id="date_fin_soins_input" value="<?= date('d/m/Y', time());?>" placeholder="Date" aria-describedby="dateSortieHelp" autocomplete="off" maxlength="10" readonly>
            <div id="dateSortieHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label class="form-label"><strong class="text-primary">Type</strong></label><br />
            <?php
            foreach ($sorties_medicales as $sortie_medicale) {
                ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sortieOptions" id="<?= $sortie_medicale['code'];?>_radio_input" value="<?= $sortie_medicale['code'];?>" <?= $sortie_medicale['code'] === 'EXE'? 'checked': '';?>>
                    <label class="form-check-label" for="<?= $sortie_medicale['code'];?>_radio_input"><?= $sortie_medicale['libelle'];?></label>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_sortie_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>
    </div>
</form>
