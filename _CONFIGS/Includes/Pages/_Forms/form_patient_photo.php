<p id="p_patient_photo_resultats"></p>
<form id="form_patient_photo">
    <div class="input-group">
        <input type="file" class="form-control" id="photo_input" name="photo_input" aria-describedby="Photo <?= $patient['prenom'];?>" aria-label="Upload">
        <input type="hidden" class="form-control" id="photo_num_patient_input" name="photo_num_patient_input" value="<?= $patient['num_population'];?>">
        <button class="btn btn-primary" type="submit" id="button_enregistrer_photo"><i class="bi bi-save"></i></button>
        <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i></button>
    </div>
</form>