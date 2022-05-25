<p id="p_rendez_vous_resultats"></p>
<form id="form_rendez_vous">
    <div class="row">
        <div class="col-sm-2">
            <label for="date_input" class="form-label"><strong class="text-primary">Date</strong></label>
            <input type="text" class="form-control form-control-sm date" id="date_input" value="<?= date('d/m/Y', strtotime($parametres['date']));?>" maxlength="10" placeholder="Date" aria-describedby="dateHelp" autocomplete="off" readonly>
            <div id="dateHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="heure_debut_input" class="form-label"><strong class="text-primary">Heure début</strong></label>
            <input type="text" class="form-control form-control-sm heure" id="heure_debut_input" value="<?= date('H:i', time());?>" maxlength="5" placeholder="--:--" aria-describedby="heureDebutHelp" autocomplete="off" readonly>
            <div id="heureDebutHelp" class="form-text"></div>
        </div>
        <div class="col-sm-2">
            <label for="heure_fin_input" class="form-label"><strong class="text-primary">Heure fin</strong></label>
            <input type="text" class="form-control form-control-sm heure" id="heure_fin_input" value="<?= date('H:i', strtotime('+1 HOUR', time()));?>" maxlength="5" placeholder="--:--" aria-describedby="heureFinHelp" autocomplete="off" readonly>
            <div id="heureFinHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label for="num_patient_input" class="form-label"><strong class="text-primary">N.I.P</strong></label>
            <input type="text" class="form-control form-control-sm" id="num_patient_input" maxlength="16" placeholder="N° I.P" aria-describedby="numPatientHelp" autocomplete="off">
            <div id="numPatientHelp" class="form-text"></div>
        </div>
        <div class="col-sm-3">
            <label for="num_secu_input" class="form-label">N° sécu</label>
            <input type="text" class="form-control form-control-sm" id="num_secu_input" maxlength="13" placeholder="N° sécu" aria-describedby="numSecuHelp" autocomplete="off">
            <div id="numSecuHelp" class="form-text"></div>
        </div>
        <div class="col-sm">
            <label for="nom_prenoms_input" class="form-label"><strong class="text-primary">Nom & Prénom(s)</strong></label>
            <input type="text" class="form-control form-control-sm" id="nom_prenoms_input" maxlength="80" placeholder="Nom & Prénom(s)" aria-describedby="nomPrenomsHelp" autocomplete="off">
            <div id="nomPrenomsHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="code_ps_input" class="form-label"><strong class="text-primary">Professionnel de santé</strong></label>
            <select class="form-select form-select-sm" id="code_ps_input" aria-label=".form-select-sm" aria-describedby="codePsHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($professionnels as $professionnel) {
                    echo '<option value="'.$professionnel['code_professionnel'].'">'.$professionnel['nom'].' '.$professionnel['prenom'].' ('.$professionnel['libelle_specialite_medicale'].')</option>';
                }
                ?>
            </select>
            <div id="codePsHelp" class="form-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <label for="motif_input" class="form-label"><strong class="text-primary">Motif de la demande</strong></label>
            <textarea class="form-control form-control-sm" id="motif_input" placeholder="Motif de la demande" aria-describedby="motifHelp"></textarea>
            <div id="motifHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">
            <input type="hidden" id="code_rdv_input">
            <button type="submit" id="button_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" id="button_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>