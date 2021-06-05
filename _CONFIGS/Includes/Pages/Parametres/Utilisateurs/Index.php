<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/CIVILITES.php";
require_once "../../../../Classes/SEXES.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $CIVILITES = new CIVILITES();
        $SEXES = new SEXES();
        $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if($user_mdp) {
                        if($user_mdp['statut'] == 1) {
                            $civilites = $CIVILITES->lister();
                            $sexes = $SEXES->lister();
                            $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                            $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                            $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                            $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                            include "../../../Menu.php";
                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-bounding-box"></i> Utilisateurs</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-person-bounding-box"></i> Utilisateurs</p>
                                <div class="col-sm-12"><?php include "../../_Forms/form_search_utilisateurs.php"; ?></div>
                                <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editionModalLabel">Nouvel utilisateur</h5>
                                            </div>
                                            <div class="modal-body">
                                                <?php include "../../_Forms/form_utilisateur.php";?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>


                            </script>
                            <?php

                            echo '<script src="'.JS.'deconnexion_1.js"></script>';
                            echo '<script src="'.JS.'page_parametres_utilisateurs.js"></script>';
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