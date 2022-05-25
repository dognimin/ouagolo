<p id="p_etablissement_logo_resultats"></p>
<form id="form_etablissement_logo">
    <div class="input-group">
        <input type="file" class="form-control" id="logo_input" name="logo_input" aria-describedby="Logo <?= $ets['logo'];?>" aria-label="Upload">
        <input type="hidden" class="form-control" id="logo_code_ets_input" name="logo_code_ets_input" value="<?= $ets['code'];?>">
        <button class="btn btn-primary" type="submit" id="button_enregistrer_logo"><i class="bi bi-save"></i></button>
        <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i></button>
    </div>
</form>