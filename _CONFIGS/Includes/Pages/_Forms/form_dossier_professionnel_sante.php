<p id="p_dossier_professionnel_sante_resultats"></p>
<form id="form_dossier_professionnel_sante">
    <div class="row">
        <div class="col-sm">
            <label for="code_ps_input" class="form-label">Medecin</label>
            <select class="form-select form-select-sm" id="code_ps_input"  aria-label=".form-select-sm" aria-describedby="codePsHelp" >
                <option value="">Sélectionnez</option>
                <?php
                foreach ($professionnels AS $professionnel){
                    ?>
                    <option value="<?= $professionnel['code_professionnel'] ?>"><?= $professionnel['nom'].' '.$professionnel['prenom'];?></option>
                    <?php
                }
                ?>
            </select>
            <div id="codePsHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <button type="submit" id="button_professionnel_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                </div>
            </div>
        </div>

    </div>
</form>