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
                                                    if (in_array('AFF_PRMTRS', $modules, true) && in_array('AFF_PRMTRS_CHBRS', $sous_modules, true)) {
                                                        $services = $ETABLISSEMENTS->lister_servies($ets['code']);
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";
                                                                if (isset($_POST['code_chambre']) && $_POST['code_chambre']) {
                                                                    $chambre = $ETABLISSEMENTS->trouver_chambre($ets['code'], $_POST['code_chambre']);
                                                                    if ($chambre) {
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/chambres';?>"><i class="bi bi-door-open-fill"></i> Chambres</a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page"><?= $chambre['libelle'];?></li>
                                                                                </ol>
                                                                            </nav>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#chambreModal"><i class="bi bi-pencil"></i></button></p>
                                                                            <p class="p_page_titre h4"><i class="bi bi-door-open-fill"></i> <?= $chambre['libelle'];?></p>
                                                                            <div class="modal fade" id="chambreModal" tabindex="-1" aria-labelledby="chambreModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="chambreModalLabel">Edition <?= $chambre['libelle'];?></h5>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body"><?php include "../../_Forms/form_chambre.php";?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/parametres/chambres"</script>';
                                                                    }
                                                                } else {
                                                                    $chambres = $ETABLISSEMENTS->lister_chambres($ets['code']);
                                                                    $nb_chambres = count($chambres);
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-door-open-fill"></i> Chambres</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PRMTRS_CHBRS', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#chambreModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-door-open-fill"></i> Chambres</p>
                                                                        <div class="modal fade" id="chambreModal" tabindex="-1" aria-labelledby="chambreModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="chambreModalLabel">Nouvelle chambre</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body"><?php include "../../_Forms/form_chambre.php";?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        if ($nb_chambres !== 0) {
                                                                            ?>
                                                                            <table class="table table-bordered table-sm table-stripped table-hover" id="table_chambres">
                                                                                <thead class="bg-indigo text-white">
                                                                                <tr>
                                                                                    <th style="width: 5px">#</th>
                                                                                    <th style="width: 100px">CODE</th>
                                                                                    <th>LIBELLE</th>
                                                                                    <th style="width: 100px">NB. LITS</th>
                                                                                    <th style="width: 5px">STATUT</th>
                                                                                    <th style="width: 5px"></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $ligne = 1;
                                                                                foreach ($chambres as $chambre) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                        <td><strong><?= $chambre['code'];?></strong></td>
                                                                                        <td><?= $chambre['libelle'];?></td>
                                                                                        <td class="align_right"></td>
                                                                                        <td class="align_center"><strong><?= !$chambre['date_fin']?'<i class="bi bi-check text-success"></i>': '<i class="bi bi-x text-danger"></i>';?></strong></td>
                                                                                        <td class="bg-info"><a href="<?= URL.'etablissement/parametres/chambres?code='.$chambre['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $ligne++;
                                                                                }
                                                                                ?>
                                                                                </tbody>
                                                                            </table>
                                                                            <?php
                                                                        } else {
                                                                            echo '<p class="alert alert-info">Aucune chambre n\'a encore été définie pour cet établissement.</p>';
                                                                        }
                                                                        ?>

                                                                    </div>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'page_etablissement_chambres.js"></script>';
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
