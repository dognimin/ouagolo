<p id="p_mail_resultats"></p>
<form id="form_mail">
    <div class="row">
        <div class="col">
            <label for="profils_input" class="form-label">Choisir</label>
            <select class="form-select form-select-sm" id="autorisation_mail_input"  aria-label=".form-select-sm" aria-describedby="profilsHelp">
                <?php
                if ($securite['securite_compte_autorisation_mail'] == 1) {?>
                    <option value="1">OUI</option>
                    <option value="0">NON</option>
                <?php }elseif($securite['securite_compte_autorisation_mail'] == 0){ ?>
                    <option value="0">NON</option>
                    <option value="1">OUI</option>
                <?php } ?>
            </select>
            <div id="profilsHelp" class="form-text"></div>
        </div>
    </div>
    <hr>
    <div class="row">

        <div class="col-md-6 d-grid">
            <button type="submit" id="button_autorisation_mail" class="btn btn-primary btn-sm"><i
                        class="bi bi-save"></i>
                Enregistrer
            </button>
        </div>
        <div class="col-md-6 d-grid">
            <button type="button" class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i
                        class="bi bi-arrow-left-square"></i> Retourner
            </button>
        </div>
    </div>


</form>