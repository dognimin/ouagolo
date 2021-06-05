<?php
require_once "../../Classes/UTILISATEURS.php";
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if($user_mdp) {
                            if($user_mdp['statut'] == 0) {
                                ?>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-4 col-md-auto" id="div_mot_de_passe">
                                                <p class="align_center"><img class="img_half_page" src="<?= IMAGES . 'logos/logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                                                <?php include "_Forms/form_mot_de_passe.php";?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="<?= JS.'page_connexion.js';?>"></script>
                                <?php
                            }else {
                                echo '<script>window.location.href="'.URL.'"</script>';
                            }
                        }else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                }else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        }else {
            session_destroy();
            echo '<script>window.location.href="'.URL.'connexion"</script>';
        }
    }else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}