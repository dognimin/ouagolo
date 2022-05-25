<p id="p_responsable_resultats"></p>
<form id="form_responsable">
    <div class="row">
        <div class="col">
            <label for="responsable_input" class="form-label">Utilisateur</label>
            <?php
            if ($responsable){
                ?>
                <input type="hidden" value="<?= $responsable['id_user'] ?>" id="responsable_input">
                <input type="text" class="form-control form-control-sm" id="" maxlength="7" placeholder="Code" value="<?=  $responsable['nom'].''.$responsable['prenoms'] ?>" aria-describedby="codeHelp" autocomplete="off" disabled="true">
                <?php
            }else{
                ?>
                <select class="form-select form-select-sm" id="responsable_input"  aria-label=".form-select-sm" aria-describedby="responsableHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($responsables AS $responsable){ ?>
                    <option value="<?= $responsable['id_user'] ?>"><?= $responsable['nom'].''.$responsable['prenoms'] ?></option>
                <?php
                }
            }
            ?>
            </select>
            <div id="responsableHelp" class="form-text"></div>
        </div>
        </div>
    <br>
    <div class="row">
        <div class="col-md-3 d-grid">
            <input type="hidden" value="<?= $etablissement['code'] ?>" id="etablissement_input">

            <button type="submit" id="button_responsable" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>

    </div>
</form>