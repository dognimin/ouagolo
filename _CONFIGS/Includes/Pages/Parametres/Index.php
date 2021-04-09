<?php
require_once "../../../Classes/UTILISATEURS.php";
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
                        if($user_mdp['statut'] == 1) {
                            include "../../Menu.php";
                            ?>
                            <nav id="nav_breadcrumb" style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= URL;?>">Accueil</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
                                </ol>
                            </nav>
                            <div class="container-xl" id="div_main_page">
                                <a href="<?= URL.'parametres/tables-de-valeurs';?>" class="btn btn-primary btn-sm">Tables de valeurs</a>
                            </div>
                            <?php
                            echo '<script src="'.JS.'deconnexion_1.js"></script>';
                        }else {

                            echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
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