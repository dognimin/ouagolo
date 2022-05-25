<p id="p_duree_de_vie_mdp_resultats"></p>
<form id="form_duree_de_vie_mdp">
    <div class="row">
        <div class="col">
            <label for="duree_mdp_input" class="form-label">Valeur</label>
            <input type="number" class="form-control form-control-sm" id="duree_mdp_input" value="<?php if ($securite['securite_compte_duree_de_vie_mot_de_passe']){echo $securite['securite_compte_duree_de_vie_mot_de_passe'];}else{ echo '';} ?>"  placeholder="Durée" aria-describedby="nomHelp" autocomplete="off" maxlength="20">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col">
            <label for="profils_input" class="form-label">Choisir</label>
            <select class="form-select form-select-sm" id="profils_input"  aria-label=".form-select-sm" aria-describedby="profilsHelp">
                <option value="">Sélectionnez</option>
                <option value="">Jour</option>
                <option value="">Semaine</option>
                <option value="">Mois</option>
                <option value="">Année</option>
            </select>
            <div id="profilsHelp" class="form-text"></div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="id_user_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['id_user']; } ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_duree_de_vie_mdp" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
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