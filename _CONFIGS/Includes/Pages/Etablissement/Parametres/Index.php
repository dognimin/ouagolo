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
                                                    if (in_array('AFF_PRMTRS', $modules, true)) {
                                                        $services = $ETABLISSEMENTS->lister_servies($ets['code']);
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../../Menu.php";
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-gear-wide-connected"></i> Paramètres</li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row  justify-content-md-center">
                                                                        <?php
                                                                        if (in_array('AFF_PRMTRS_PNS', $sous_modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/parametres/panier-de-soins'; ?>" class="btn btn-danger btn-sm"><i class="bi bi-cart-plus"></i><br/>Panier de soins</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_PRMTRS_PRFUT', $sous_modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/parametres/profils-utilisateurs'; ?>" class="btn btn-danger btn-sm"><i class="bi bi-briefcase-fill"></i><br/>Profils utilisateurs</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_PRMTRS_UT', $sous_modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/parametres/utilisateurs'; ?>" class="btn btn-danger btn-sm"><i class="bi bi-person-bounding-box"></i><br/>Utilisateurs</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        foreach ($services as $service) {
                                                                            if (in_array('ADMI', $service, true)) {
                                                                                if (in_array('AFF_PRMTRS_CHBRS', $sous_modules, true)) {
                                                                                    ?>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/parametres/chambres'; ?>" class="btn btn-danger btn-sm"><i class="bi bi-door-open-fill"></i><br/>Chambres</a></div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
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
                                                    echo '<script>window.location.href="'.URL.'etablissement/"</script>';
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
