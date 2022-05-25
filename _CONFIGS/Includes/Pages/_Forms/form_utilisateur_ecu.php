<p id="p_utilisateur_ecu_resultats"></p>
<form id="form_utilisateur_ecu">
    <div class="row">
        <div class="col-md-4">
            <label for="nom_ecu_input" class="form-label">Nom</label>
            <input type="text" class="form-control form-control-sm" id="nom_ecu_input"  placeholder="Nom" aria-describedby="nomHelp" autocomplete="off" maxlength="20">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="prenoms_ecu_input" class="form-label">Prénom(s)</label>
            <input type="text" class="form-control form-control-sm" id="prenoms_ecu_input"  placeholder="Prénom(s)" aria-describedby="prenomHelp" autocomplete="off" maxlength="20">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="col-md-4">
            <label for="telephone_input" class="form-label">Téléphone</label>
            <input type="text" class="form-control form-control-sm" id="telephone_input"  placeholder="Téléphone" aria-describedby="telephoneHelp" autocomplete="off" maxlength="30">
            <div id="telephoneHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <label for="type_personne_input" class="form-label">Type personne</label>
            <select class="form-select form-select-sm" id="type_personne_input" aria-label=".form-select-sm" aria-describedby="typePersonneHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($typespersonnes as $typespersonne) {
                    echo '<option value="'.$typespersonne['code'].'">'.$typespersonne['libelle'].'</option>';
                }
                ?>
            </select>
            <div id="typePersonneHelp" class="form-text"></div>
        </div>
        </div>
    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6 d-grid">
                    <input type="hidden" id="id_user_input" value="<?php if (isset($_POST['uid'])){ echo $utilisateur['id_user']; } ?>" aria-label="Identifiant utilisateur">
                    <button type="submit" id="button_utilisateur" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Enregistrer</button>
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