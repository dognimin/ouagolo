<script src="<?= NODE_MODULES.'jquery/dist/jquery.min.js';?>"></script>
<script src="<?= NODE_MODULES.'jqueryui/jquery-ui.js';?>"></script>

<!-- Bootstrap -->
<script src="<?= NODE_MODULES.'bootstrap/dist/js/bootstrap.min.js';?>"></script>

<!-- DataTables -->
<script src="<?= NODE_MODULES.'datatables.net/js/jquery.dataTables.js';?>"></script>
<script src="<?= NODE_MODULES.'datatables.net-dt/js/dataTables.dataTables.min.js';?>"></script>

<!-- Ouagolo JS -->
<script src="<?= JS.'index.js';?>"></script>
<script src="<?= JS.'deconnexion_1.js';?>"></script>
<?php
if(ACTIVE_URL == URL) {
    echo '<script>display_index_page()</script>';
}elseif(ACTIVE_URL == URL.'connexion') {
    echo '<script>display_connexion_page()</script>';
}elseif(ACTIVE_URL == URL.'mot-de-passe') {
    echo '<script>display_mot_de_passe_page()</script>';
}elseif(ACTIVE_URL == URL.'parametres/') {
    echo '<script>display_parametres_index_page()</script>';
}elseif(ACTIVE_URL == URL.'parametres/tables-de-valeurs') {
    echo '<script>display_parametres_tables_de_valeurs_page()</script>';
}
?>
</body>
</html>