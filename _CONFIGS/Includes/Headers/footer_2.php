<script src="<?= NODE_MODULES.'jquery/dist/jquery.min.js';?>"></script>
<script src="<?= NODE_MODULES.'jqueryui/jquery-ui.js';?>"></script>

<!-- Bootstrap -->
<script src="<?= NODE_MODULES.'bootstrap/dist/js/bootstrap.min.js';?>"></script>

<!-- DataTables -->
<script src="<?= NODE_MODULES.'datatables.net/js/jquery.dataTables.js';?>"></script>
<script src="<?= NODE_MODULES.'datatables.net-dt/js/dataTables.dataTables.min.js';?>"></script>

<!-- Ouagolo JS -->
<script src="<?= JS.'index.js';?>"></script>
<script src="<?= JS.'deconnexion_2.js';?>"></script>
<?php
if(ACTIVE_URL == URL.'parametres/utilisateurs/') {
    echo '<script>display_parametres_utilisateurs_index_page()</script>';
}

if(ACTIVE_URL == URL.'parametres/reseaux-de-soins/') {
    echo '<script>display_parametres_reseaux_de_soins_index_page()</script>';
}
if((isset($_GET['code'])) && ACTIVE_URL == URL .'parametres/reseaux-de-soins/details?code='.$_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_details_page(getUrlVars()['code'])</script>";
}
if((isset($_GET['code'])) && ACTIVE_URL == URL .'parametres/reseaux-de-soins/etablissements?code='.$_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_etablissements_page(getUrlVars()['code'])</script>";
}
if((isset($_GET['code'])) && ACTIVE_URL == URL .'parametres/reseaux-de-soins/medicaments?code='.$_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_medicaments_page(getUrlVars()['code'])</script>";
}
if((isset($_GET['code'])) && ACTIVE_URL == URL .'parametres/reseaux-de-soins/actes-medicaux?code='.$_GET['code']) {
    echo "<script>display_parametres_reseaux_de_soins_actes_medicaux_page(getUrlVars()['code'])</script>";
}


if(ACTIVE_URL == URL.'parametres/securite/') {
    echo '<script>display_parametres_securite_index_page()</script>';
}
if(ACTIVE_URL == URL.'parametres/securite/mot-de-passe') {
    echo '<script>display_parametres_securite_mdp_page()</script>';
}
if(ACTIVE_URL == URL.'parametres/securite/compte') {
    echo '<script>display_parametres_securite_compte_page()</script>';
}
if((isset($_GET['uid'])) && ACTIVE_URL == URL .'parametres/utilisateurs/details?uid='.$_GET['uid']) {
    echo "<script>display_parametres_utilisateur_details_page(getUrlVars()['uid'])</script>";
}


elseif(ACTIVE_URL == URL.'parametres/etablissements/') {
    echo '<script>display_parametres_etablissements_index_page()</script>';
}
if(ACTIVE_URL == URL.'parametres/etablissements/details' || (isset($_GET['code'])) && ACTIVE_URL == URL .'parametres/etablissements/details?code='.$_GET['code']) {
    echo "<script>display_parametres_etablissements_details_page(getUrlVars()['code'])</script>";
}
elseif(ACTIVE_URL == URL.'parametres/referentiels/') {
    echo '<script>display_parametres_referentiels_index_page()</script>';
}elseif(ACTIVE_URL == URL.'parametres/referentiels/pathologies') {
    echo '<script>display_parametres_referentiels_pathologies_page()</script>';
}elseif(ACTIVE_URL == URL.'parametres/referentiels/actes-medicaux') {
    echo '<script>display_parametres_referentiels_actes_medicaux_page()</script>';
}elseif(ACTIVE_URL == URL.'parametres/referentiels/medicaments') {
    echo '<script>display_parametres_referentiels_medicaments_page()</script>';
}
?>
</body>
</html>