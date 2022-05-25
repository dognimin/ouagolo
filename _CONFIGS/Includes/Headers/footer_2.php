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
if ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/patients/') {
    echo '<script>display_etablissement_patients_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['nip'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/patients/?nip=' . $_GET['nip']) {
    echo "<script>display_etablissement_patients_index_page('".$Links['ACTIVE_URL'] ."',getUrlVars()['nip'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/dossiers/') {
    echo '<script>display_etablissement_dossiers_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['num'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/dossiers/?num=' . $_GET['num']) {
    echo "<script>display_etablissement_dossiers_index_page('".$Links['ACTIVE_URL'] ."',getUrlVars()['num'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/') {
    echo '<script>display_etablissement_pharmacie_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/ventes') {
    echo '<script>display_etablissement_pharmacie_ventes_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/stock') {
    echo '<script>display_etablissement_pharmacie_stock_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/produits') {
    echo '<script>display_etablissement_pharmacie_produits_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/produits?code='.$_GET['code']) {
    echo "<script>display_etablissement_pharmacie_produits_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/commandes') {
    echo '<script>display_etablissement_pharmacie_commandes_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['num']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/pharmacie/commandes?num='.$_GET['num']) {
    echo "<script>display_etablissement_pharmacie_commandes_page('".$Links['ACTIVE_URL']."',getUrlVars()['num'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/') {
    echo '<script>display_etablissement_factures_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/bordereaux') {
    echo '<script>display_etablissement_factures_bordereaux_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['num'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/bordereaux?num='.$_GET['num']) {
    echo "<script>display_etablissement_factures_bordereaux_page('".$Links['ACTIVE_URL']."',getUrlVars()['num'])</script>";
}
elseif ((isset($_GET['nip'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/edition?nip='.$_GET['nip']) {
    echo "<script>display_etablissement_factures_edition_page('".$Links['ACTIVE_URL']."',getUrlVars()['nip'])</script>";
}
elseif ((isset($_GET['nip']) && isset($_GET['num'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/edition?nip='.$_GET['nip'].'&num='.$_GET['num']) {
    echo "<script>display_etablissement_factures_edition_page('".$Links['ACTIVE_URL']."',getUrlVars()['nip'],getUrlVars()['num'])</script>";
}
elseif ((isset($_GET['num'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/factures/?num=' . $_GET['num']) {
    echo "<script>display_etablissement_factures_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['num'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/comptabilite/') {
    echo '<script>display_etablissement_comptabilite_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/services/') {
    echo '<script>display_etablissement_services_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/professionnels-de-sante/') {
    echo '<script>display_etablissement_professionnels_de_sante_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/professionnels-de-sante/?code='.$_GET['code']) {
    echo "<script>display_etablissement_professionnels_de_sante_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/dashboard/') {
    echo '<script src="'.$Links['NODE_MODULES'].'chart.js/dist/chart.js"></script>';
    echo '<script src="'.$Links['JS'].'index_dashboard.js"></script>';
    echo '<script>display_etablissement_dashboard_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/support/') {
    echo '<script>display_etablissement_support_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/rendez-vous/') {
    echo '<script>display_etablissement_rdv_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/laboratoire/') {
    echo '<script>display_etablissement_laboratoire_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['a']) && isset($_GET['m']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/rendez-vous/?a='.$_GET['a'].'&m='.$_GET['m']) {
    echo "<script>display_etablissement_rdv_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['a'],getUrlVars()['m'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/a-propos/') {
    echo '<script>display_etablissement_apropos_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/') {
    echo '<script>display_etablissement_parametres_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/panier-de-soins') {
    echo '<script>display_etablissement_parametres_panier_soins_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/profils-utilisateurs') {
    echo '<script>display_etablissement_parametres_profils_utilisateurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['pid']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/profils-utilisateurs?pid='.$_GET['pid']) {
    echo "<script>display_etablissement_parametres_profils_utilisateurs_page('".$Links['ACTIVE_URL']."',getUrlVars()['pid'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/utilisateurs') {
    echo '<script>display_etablissement_parametres_utilisateurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['uid']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/utilisateurs?uid='.$_GET['uid']) {
    echo "<script>display_etablissement_parametres_utilisateurs_page('".$Links['ACTIVE_URL']."',getUrlVars()['uid'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/chambres') {
    echo '<script>display_etablissement_parametres_chambres_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'etablissement/parametres/chambres?code='.$_GET['code']) {
    echo "<script>display_etablissement_parametres_chambres_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/polices/') {
    echo '<script>display_organisme_polices_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['id']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/polices/?id='.$_GET['id']) {
    echo "<script>display_organisme_polices_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['id'])</script>";
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/colleges/') {
    echo '<script>display_organisme_colleges_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['id-police']) && isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/colleges/?id-police='.$_GET['id-police'].'&code='.$_GET['code']) {
    echo "<script>display_organisme_colleges_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['id-police'],getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/assures/') {
    echo '<script>display_organisme_assures_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['num']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/assures/?num='.$_GET['num']) {
    echo "<script>display_organisme_assures_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['num'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/prestations/') {
    echo '<script>display_organisme_prestations_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/prestations/factures') {
    echo '<script>display_organisme_prestations_factures_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['r']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/prestations/factures?r='.$_GET['r']) {
    echo "<script>display_organisme_prestations_factures_page('".$Links['ACTIVE_URL']."',getUrlVars()['r'])</script>";
}
elseif (isset($_GET['r']) && isset($_GET['num']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/prestations/factures?r='.$_GET['r'].'&num='.$_GET['num']) {
    echo "<script>display_organisme_prestations_factures_page('".$Links['ACTIVE_URL']."',getUrlVars()['r'],getUrlVars()['num'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/prestations/demandes') {
    echo '<script>display_organisme_prestations_demandes_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/produits') {
    echo '<script>display_organisme_parametres_produits_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/produits?code='.$_GET['code']) {
    echo "<script>display_organisme_parametres_produits_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/reseaux-de-soins') {
    echo '<script>display_organisme_parametres_reseaux_de_soins_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/reseaux-de-soins?code='.$_GET['code']) {
    echo "<script>display_organisme_parametres_reseaux_de_soins_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/paniers-de-soins') {
    echo '<script>display_organisme_parametres_paniers_de_soins_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['code']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/paniers-de-soins?code='.$_GET['code']) {
    echo "<script>display_organisme_parametres_paniers_de_soins_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/remboursements/') {
    echo '<script>display_organisme_remboursements_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/dashboard/') {
    echo '<script>display_organisme_dashboard_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/support/') {
    echo '<script>display_organisme_support_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/') {
    echo '<script>display_organisme_parametres_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/utilisateurs') {
    echo '<script>display_organisme_parametres_utilisateurs_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif (isset($_GET['uid']) && $Links['ACTIVE_URL'] == $Links['URL'] . 'organisme/parametres/utilisateurs?uid='.$_GET['uid']) {
    echo "<script>display_organisme_parametres_utilisateurs_page('".$Links['ACTIVE_URL']."',getUrlVars()['uid'])</script>";
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/utilisateurs/') {
    echo '<script>display_parametres_utilisateurs_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['uid'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/utilisateurs/?uid=' . $_GET['uid']) {
    echo "<script>display_parametres_utilisateurs_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['uid'])</script>";
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/reseaux-de-soins/') {
    echo '<script>display_parametres_reseaux_de_soins_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['code'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/reseaux-de-soins/?code=' . $_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_index_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ((isset($_GET['code'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/reseaux-de-soins/etablissements?code=' . $_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_etablissements_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ((isset($_GET['code'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/reseaux-de-soins/medicaments?code=' . $_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_medicaments_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ((isset($_GET['code'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/reseaux-de-soins/actes-medicaux?code=' . $_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_actes_medicaux_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}

elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/securite/') {
    echo '<script>display_parametres_securite_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/securite/mot-de-passe') {
    echo '<script>display_parametres_securite_mdp_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/securite/compte') {
    echo '<script>display_parametres_securite_compte_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/support/') {
    echo '<script>display_parametres_support_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/') {
    echo '<script>display_parametres_referentiels_index_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/pathologies') {
    echo '<script>display_parametres_referentiels_pathologies_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/actes-medicaux') {
    echo '<script>display_parametres_referentiels_actes_medicaux_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/medicaments') {
    echo '<script>display_parametres_referentiels_medicaments_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
elseif ((isset($_GET['code'])) && $Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/medicaments?code=' . $_GET['code']) {
    echo "<script>display_parametres_referentiels_medicaments_medicament_page('".$Links['ACTIVE_URL']."',getUrlVars()['code'])</script>";
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'parametres/referentiels/collectivites') {
    echo '<script>display_parametres_referentiels_collectivites_page("' . $Links['ACTIVE_URL'] . '")</script>';
}
else {
    echo '<script>window.location.href="' . $Links['URL'] . 'page-introuvable"</script>';
}
?>
</body>
<footer><?= date('Y',time()) == '2021'? date('Y',time()): '2021 - '.date('Y',time());?>: &copy; Ouagolo. Tous droits réservés.</footer>
</html>
