<?php
use App\GLOBALS;
use App\SEXES;
use App\CIVILITES;
use App\UTILISATEURS;
require_once "../../../vendor/autoload.php";
require_once "../../Functions/Functions.php";

$GLOBALS = new GLOBALS();
$Headers = $GLOBALS->headers(0);
$Links = $GLOBALS->links();

if (!isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $utilisateurs = $UTILISATEURS->lister();
    $nb_utilisateurs = count($utilisateurs);
    ?>
    <div class="container-fluid">
        <div class="row justify-content-lg-center" id="div_connexion_main_page">
            <?php
            if ($nb_utilisateurs !== 0) {
                ?>
                <div class="col-lg-4" id="">
                    <div id="div_connexion">
                        <p class="align_center"><img class="img_half_page" src="<?= $Links['IMAGES'] . 'logos/logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                        <?php include "_Forms/form_connexion.php"; ?>
                    </div>
                    <div id="div_email">
                        <p class="align_center"><img class="img_half_page" src="<?= $Links['IMAGES'] . 'logos/logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                        <?php include "_Forms/form_email.php"; ?>
                    </div>
                </div>
                <?php
            } else {
                $CIVILITES = new CIVILITES();
                $SEXES = new SEXES();

                $civilites = $CIVILITES->lister();
                $nb_civilites = count($civilites);
                $sexes = $SEXES->lister();
                $nb_sexes = count($sexes);
                ?>
                <div class="col-sm-8 col-sm-auto" id="div_creation_admin">
                    <p class="align_center"><img class="img_half_page" src="<?= $Links['IMAGES'] . 'logos/logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                    <?php include "_Forms/form_utilisateur.php"; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <script src="<?= $Links['JS'] . 'page_connexion.js'; ?>"></script>
    <?php
} else {
    echo '<script>window.location.href="' . $Links['URL'] . '"</script>';
}
?>