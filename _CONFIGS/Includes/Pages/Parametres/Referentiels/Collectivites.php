<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if ($user_statut) {
                    if ($user_statut['statut'] == 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ($user_mdp['statut'] == 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] == 'ADMN') {
                                        if (isset($parametres['url'])) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                            if ($audit['success'] == true) {
                                                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                require_once "../../../../Classes/SECTEURSACTIVITES.php";
                                                require_once "../../../../Classes/COLLECTIVITES.php";
                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                $SECTEURSACTIVITES = new SECTEURSACTIVITES();
                                                $COLLECTIVITES = new COLLECTIVITES();
                                                include "../../../Menu.php";

                                                $secteurs = $SECTEURSACTIVITES->lister();
                                                $payss = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);

                                                if(isset($_POST['code']) && $_POST['code']) {

                                                }else {
                                                    $collectivites_secteurs = $COLLECTIVITES->lister_secteurs_activites();
                                                }
                                                ?>
                                                <div class="container-xl" id="div_main_page">
                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                            <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                            <li class="breadcrumb-item"><a href="<?= URL . 'parametres/referentiels/'; ?>"><i class="bi bi-clipboard-plus"></i> Référentiels</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-bookmarks"></i> Collectivités</li>
                                                        </ol>
                                                    </nav>
                                                    <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                    <p class="p_page_titre h4"><i class="bi bi-bookmarks"></i> Collectivités</p>
                                                    <div class="col-sm-12"><?php include "../../_Forms/form_search_collectivites.php"; ?></div>
                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editionModalLabel">Nouvelle collectivité</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php include "../../_Forms/form_collectivite.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                                                echo '<script src="' . JS . 'page_parametres_collectivites.js"></script>';
                                            } else {
                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<script>window.location.href="' . URL . '"</script>';
                                    }
                                } else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                }
                            } else {
                                echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
                            }
                        } else {
                            $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                            if ($fermer_session['success'] == true) {
                                session_destroy();
                                echo '<script>window.location.href="' . URL . 'connexion"</script>';
                            } else {
                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                            }
                        }
                    } else {
                        $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                        if ($fermer_session['success'] == true) {
                            session_destroy();
                            echo '<script>window.location.href="' . URL . 'connexion"</script>';
                        } else {
                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                        }
                    }
                } else {
                    $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                    if ($fermer_session['success'] == true) {
                        session_destroy();
                        echo '<script>window.location.href="' . URL . 'connexion"</script>';
                    } else {
                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                    }
                }
            } else {
                $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                if ($fermer_session['success'] == true) {
                    session_destroy();
                    echo '<script>window.location.href="' . URL . 'connexion"</script>';
                } else {
                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                }
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . URL . 'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="' . URL . 'connexion"</script>';
}