<?php
require_once "../../Classes/UTILISATEURS.php";
if(!isset($_SESSION['nouvelle_session'])) {
    require_once "../../Classes/CIVILITES.php";
    require_once "../../Classes/SEXES.php";
    $UTILISATEURS = new UTILISATEURS();
    $CIVILITES = new CIVILITES();
    $SEXES = new SEXES();
    $utilisateurs = $UTILISATEURS->lister();
    $nb_utilisateurs = count($utilisateurs);

    $civilites = $CIVILITES->lister();
    $nb_civilites = count($civilites);

    $sexes = $SEXES->lister();
    $nb_sexes = count($sexes);
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="row justify-content-md-center">
                <?php
                if($nb_utilisateurs != 0) {
                    ?>
                    <div class="col-md-4 col-md-auto" id="div_connexion">
                        <p class="align_center"><img class="img_half_page" src="<?= IMAGES . 'logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                        <?php include "_Forms/form_connexion.php";?>
                    </div>
                    <div class="col-md-4 col-md-auto" id="div_email">
                        <p class="align_center"><img class="img_half_page" src="<?= IMAGES . 'logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                        <?php include "_Forms/form_email.php";?>
                    </div>
                    <?php
                }else {
                    ?>
                    <div class="col-md-8 col-md-auto" id="div_creation_admin">
                        <p class="align_center"><img class="img_half_page" src="<?= IMAGES . 'logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                        <?php include "_Forms/form_utilisateur.php";?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script src="<?= JS.'page_connexion.js';?>"></script>
    <?php
}else {
    echo '<script>window.location.href="'.URL.'"</script>';
}
?>