<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/ETABLISSEMENTS.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
require_once "../../../../Classes/SECTEURSACTIVITES.php";
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
                            include "../../../Menu.php";
                            $ETABLISSEMENTS = new ETABLISSEMENTS();
                            $SECTEURS = new SECTEURSACTIVITES();
                            $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                            $types = $ETABLISSEMENTS->lister_types_ets();
                            $secteurs = $SECTEURS->lister();
                            $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                            $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                            $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                            $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                            $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building"></i> Etablissements</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-building"></i> Etablissements</p>
                                <div class="d-grid gap-2 d-md-block">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" id="btn_niveaux_sanitaires" data-bs-target="#niveauSanitaireModal"> Niveaux sanitaires</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" id="btn_types_etablissements" data-bs-target="#typeEtablissementModal"> Types établissements</button>
                                    <div class="modal fade" id="niveauSanitaireModal" tabindex="-1" aria-labelledby="niveauSanitaireModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="niveauSanitaireModalLabel">Niveaux sanitaires</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="div_niveaux_sanitaires"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="typeEtablissementModal" tabindex="-1" aria-labelledby="typeEtablissementModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="typeEtablissementModalLabel">Types établissements</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="div_types_etablissements"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-12"><?php include "../../_Forms/form_search_etablissement.php"; ?></div>
                                <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editionModalLabel">Nouvel établissement</h5>
                                            </div>
                                            <div class="modal-body">
                                                <?php include "../../_Forms/form_etablissements.php"; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            echo '<script src="'.JS.'deconnexion_2.js"></script>';
                            echo '<script src="'.JS.'page_parametres_etablissements.js"></script>';
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