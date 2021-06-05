<p id="p_etablissement_agent_resultats"></p>
<form id="form_etablissement_agent">
    <div class="row">
        <div class="col-sm-">
            <label for="agent_id_input" class="form-label">Agent</label>
            <select class="form-select form-select-sm" id="agent_id_input"  aria-label=".form-select-sm" aria-describedby="agentHelp">
                <option value="">Sélectionnez</option>
                <?php
                foreach ($agents as $agent) {
                    echo '<option value="'.$agent['id_user'].'">'.$agent['nom'].''.$agent['prenoms'].'</option>';
                }
                ?>
            </select>
            <div id="agentHelp" class="form-text"></div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3 d-grid">

            <button type="submit" id="button_agent_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-3 d-grid">
            <button type="button"  class="btn btn-dark btn-sm btn-block" id="button_ets_agents_retourner"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>