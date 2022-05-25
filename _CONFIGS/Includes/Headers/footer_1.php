<script src="<?= $Links['NODE_MODULES'].'jquery/dist/jquery.min.js';?>"></script>
<script src="<?= $Links['NODE_MODULES'].'jquery-ui-dist/jquery-ui.js';?>"></script>

<!-- Bootstrap -->
<script src="<?= $Links['NODE_MODULES'].'bootstrap/dist/js/bootstrap.min.js';?>"></script>

<script src="<?= $Links['NODE_MODULES'].'jquery-datetimepicker/build/jquery.datetimepicker.full.min.js';?>"></script>

<!-- DataTables -->
<script src="<?= $Links['NODE_MODULES'].'datatables.net/js/jquery.dataTables.js';?>"></script>
<script src="<?= $Links['NODE_MODULES'].'datatables.net-dt/js/dataTables.dataTables.min.js';?>"></script>


<!-- Ouagolo JS -->
<script src="<?= $Links['JS'] . 'index.js'; ?>"></script>
<?php
if ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissements/') {
    echo '<script>display_etablissements_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissements/?code=' . $_GET['code']) {
    echo "<script>display_etablissements_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/') {
    echo '<script>display_organisme_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organismes/') {
    echo '<script>display_organismes_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organismes/?code='.$_GET['code']) {
    echo "<script>display_organismes_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organismes/baremes') {
    echo '<script>display_organismes_baremes_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organismes/baremes?code='.$_GET['code']) {
    echo "<script>display_organismes_baremes_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif (isset($_GET['code-organisme']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organismes/utilisateurs?code-organisme='.$_GET['code-organisme']) {
    echo "<script>display_organismes_utilisateurs_page('".$Links['ACTIVE_URL']."',getUrlVars()['code-organisme'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'factures/') {
    echo '<script>display_factures_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'comptabilite/') {
    echo '<script>display_comptabilite_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/') {
    echo '<script>display_etablissement_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/fournisseurs') {
    echo '<script>display_etablissement_fournisseurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/fournisseurs?code='.$_GET['code']) {
    echo '<script>display_etablissement_fournisseurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'support/') {
    echo '<script>display_support_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'dashboard/') {
    echo '<script>display_dashboard_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/') {
    echo '<script>display_parametres_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/tables-de-valeurs') {
    echo '<script>display_parametres_tables_de_valeurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
else {
    echo '<script>window.location.href="' . $Links['URL'] . 'page-introuvable"</script>';
}
?>
</body>
<footer><?= date('Y',time()) == '2021'? date('Y',time()): '2021 - '.date('Y',time());?>: &copy; Ouagolo. Tous droits réservés.</footer>
</html>