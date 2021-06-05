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
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-gear-wide-connected"></i> Paramètres</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-gear-wide-connected"></i> Paramètres</p>
                                <div class="row  justify-content-md-center">
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/etablissements/';?>" class="btn btn-primary btn-sm"><i class="bi bi-building"></i><br /> Etablissements</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/reseaux-de-soins/';?>" class="btn btn-primary btn-sm"><i class="bi bi-diagram-3"></i><br /> Réseaux de soins</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/utilisateurs/';?>" class="btn btn-primary btn-sm"><i class="bi bi-person-bounding-box"></i><br /> Utilisateurs</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/referentiels/';?>" class="btn btn-primary btn-sm"><i class="bi bi-clipboard-plus"></i><br /> Référentiels</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/tables-de-valeurs';?>" class="btn btn-primary btn-sm"><i class="bi bi-award"></i><br /> Tables de valeurs</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= URL.'parametres/securite/';?>" class="btn btn-primary btn-sm"><i class="bi bi-shield-check"></i><br /> Sécurité</a>
                                        </div>
                                    </div>
                                </div>

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