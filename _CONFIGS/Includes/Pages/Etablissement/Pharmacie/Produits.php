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
                    if ((int)$user_statut['statut'] === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)$user_mdp['statut'] === 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] === 'ETABLI') {
                                        require_once "../../../../Classes/ETABLISSEMENTS.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_PHCIE', $modules, true) && in_array('AFF_PHCIE_PDTS', $sous_modules, true)) {
                                                        $service = $ETABLISSEMENTS->trouver_service($ets['code'], 'PHCIE');
                                                        if ($service) {
                                                            if (isset($parametres['url'])) {
                                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                                if ($audit['success'] == true) {
                                                                    include "../../../Menu.php";
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/pharmacie/';?>"><i class="bi bi-dpad-fill"></i> Pharmacie</a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-bullseye"></i> Produits</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PHCIE_PDTS', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#produitModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                            <div class="modal fade" id="produitModal" tabindex="-1" aria-labelledby="produitModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="produitModalLabel">Nouveau produit</h5>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body"><?php include "../../_Forms/form_produit.php";?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-bullseye"></i> Produits</p>
                                                                        <?php include "../../_Forms/form_search_produits.php";?>
                                                                    </div>
                                                                    <?php
                                                                    echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                    echo '<script src="'.JS.'page_etablissement_produits.js"></script>';
                                                                } else {
                                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                                }
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<script>window.location.href="'.URL.'etablissement/"</script>';
                                                        }
                                                    } else {
                                                        echo '<script>window.location.href="'.URL.'etablissement/pharmacie/"</script>';
                                                    }
                                                } else {
                                                    echo '<script>window.location.href="'.URL.'etablissement/pharmacie/"</script>';
                                                }
                                            } else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                } else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            } else {

                                echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                            }
                        } else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                    } else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                } else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            } else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}
