<?php
require_once "../../../Classes/UTILISATEURS.php";
require_once "../../../Functions/Functions.php";
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
                    if ((int)($user_statut['statut']) === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)($user_mdp['statut']) === 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] === 'ETABLI') {
                                        require_once "../../../Classes/ETABLISSEMENTS.php";
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
                                                    if ($nb_modules === 1) {
                                                        $destination = str_replace(array('AFF_PRMTRS', 'AFF_APRPS', 'AFF_SPPTS', 'AFF_DSHBS', 'AFF_RDVS', 'AFF_PFSS', 'AFF_PHCIE', 'AFF_FRNSS', 'AFF_CPTS', 'AFF_FCTS', 'AFF_DOSS', 'AFF_PTS'), array('parametres/', 'a-propos/', 'support/', 'dashboard/', 'rendez-vous/', 'professionnels-de-sante/', 'pharmacie/', 'fournisseurs', 'comptabilite/', 'factures/', 'dossiers/', 'patients/'), implode(' ', $modules));
                                                        echo '<script>window.location.href="'.URL.'etablissement/'.$destination.'"</script>';
                                                    } else {
                                                        $services = $ETABLISSEMENTS->lister_servies($ets['code']);
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../Menu.php";
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1); ?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row ">
                                                                        <?php
                                                                        if (in_array('AFF_PTS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/patients/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-person-circle"></i><br/>Patients</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_DOSS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/dossiers/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-folder2-open"></i><br/>Dossiers</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_FCTS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/factures/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-journal-check"></i><br/>Factures</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_CPTS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/comptabilite/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-cash-coin"></i><br/>Comptabilité</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_FRNSS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/fournisseurs'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-circle-square"></i><br/>Fournisseurs</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_PHCIE', $modules, true)) {
                                                                            foreach ($services as $service) {
                                                                                if (in_array('PHCIE', $service, true)) {
                                                                                    ?>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/pharmacie/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-dpad-fill"></i><br/>Pharmacie</a></div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        if (in_array('AFF_PFSS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/professionnels-de-sante/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-person-rolodex"></i><br/>Professionnels de santé</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_RDVS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/rendez-vous/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-calendar2-week"></i><br/>Rendez-vous</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_LABOS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/laboratoire/'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-eyedropper"></i><br/>Laboratoire</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_DSHBS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/dashboard/'; ?>" class="btn btn-dark btn-sm"><i class="bi bi-graph-up"></i><br/> Dashboard</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_SPPTS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/support/'; ?>" class="btn btn-dark btn-sm"><i class="bi bi-question-circle"></i><br/> Support</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_APRPS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/a-propos/'; ?>" class="btn btn-dark btn-sm"><i class="bi bi-info-circle"></i><br/> A propos</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (in_array('AFF_PRMTRS', $modules, true)) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="d-grid div_boxes"><a href="<?= URL . 'etablissement/parametres/'; ?>" class="btn btn-danger btn-sm"><i class="bi bi-gear-wide-connected"></i><br/>Paramètres</a></div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<p class="alert alert-danger align_center">Vous ne disposez d\'aucune habilitation pour accéder à cette ressource.</p>';
                                                }
                                            } else {
                                                echo '<p class="alert alert-danger align_center">Aucun établissement correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
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
