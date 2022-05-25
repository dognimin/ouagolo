<p id="p_securite_compte_nombre_essaie_resultats"></p>
<form id="form_securite_compte_nombre_essaie">
    <div class="row">
        <div class="col-md">
            <label for="nombre_essaie_input" class="form-label">Valeur</label>
            <input type="number" class="form-control  form-control-sm" max="10" min="0" id="nombre_essaie_input"  value="<?php if ($securite['securite_compte_nombre_essaie_authentification']){echo $securite['securite_compte_nombre_essaie_authentification'];}else{ echo '';} ?>" placeholder="Valeur" aria-describedby="longueurHelp" autocomplete="off" maxlength="20">
            <div id="longueurHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="id_user_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['id_user']; } ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
                </div>
                <?php
                if(isset($_SESSION['nouvelle_session'])) {
                    ?>
                    <div class="col-md-6 d-grid">
                        <button type="button"  class="btn btn-dark btn-sm btn-block" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-arrow-left-square"></i> Retourner</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</form>