<form id="form_tables_de_valeurs">
    <div class="mb-3">
        <label for="table_de_valeur_input" class="form-label">Referentiels</label>
        <select class="form-select form-select-sm" id="table_de_valeur_input" aria-label=".form-select-sm" aria-describedby="tablesDeValeursHelp">
            <option value="">Sélectionnez</option>
            <?php
            foreach ($tables as $table) {
                echo '<option value="'.$table['code'].'">'.$table['libelle'].'</option>';
            }
            ?>
        </select>
        <div id="tablesDeValeursHelp" class="form-text"></div>
    </div>
</form>