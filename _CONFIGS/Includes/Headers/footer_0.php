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
if ($Links['ACTIVE_URL'] == $Links['URL']) {
    echo '<script>display_index_page("' . $Links['URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'connexion') {
    echo '<script>display_connexion_page()</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'profil') {
    echo '<script>display_profil_page("' . $Links['URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'mot-de-passe') {
    echo '<script>display_mot_de_passe_page("' . $Links['URL'] . '")</script>';
}
elseif ($Links['ACTIVE_URL'] == $Links['URL'] . 'page-introuvable') {
    echo '<script>display_introuvable_page()</script>';
}
?>
</body>
<?php
if($Links['ACTIVE_URL'] !== $Links['URL'].'connexion') {
    ?>
    <footer><?= date('Y',time()) == '2021'? date('Y',time()): '2021 - '.date('Y',time());?>: &copy; Ouagolo. Tous droits réservés.</footer>
    <?php
}
?>
</html>