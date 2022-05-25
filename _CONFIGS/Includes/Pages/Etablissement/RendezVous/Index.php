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
                                        require_once "../../../../Classes/MONTH.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    if (in_array('AFF_RDVS', $modules, true)) {
                                                        $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../../Menu.php";
                                                                if (isset($_POST['mois']) && isset($_POST['annee'])) {
                                                                    $month = new MONTH(clean_data($_POST['mois']), clean_data($_POST['annee']));
                                                                    $annee = $_POST['annee'];
                                                                } else {
                                                                    $month = new MONTH();
                                                                    $annee = date('Y', time());
                                                                }
                                                                $jours_feries = $month->holydays($annee);
                                                                $start = $month->getStartingDay()->modify('last monday');
                                                                $today = date('Y-m-d', time());
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-calendar2-week"></i> Rendez-vous</li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row justify-content-md-center">
                                                                        <div class="col-sm-3">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td class="align_left"><a href="<?= URL.'etablissement/rendez-vous/?a='.$month->previousMonth()->year.'&m='.$month->previousMonth()->month;?>" class="btn btn-sm btn-dark"><i class="bi bi-caret-left-fill"></i></a></td>
                                                                                            <td class="align_center h5" style="width: 80%"><?= $month->toString();?></td>
                                                                                            <td class="align_right"><a href="<?= URL.'etablissement/rendez-vous/?a='.$month->nextMonth()->year.'&m='.$month->nextMonth()->month;?>" class="btn btn-sm btn-dark"><i class="bi bi-caret-right-fill"></i></a></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table class="calendar__table calendar__table--<?= $month->getWeeks();?>weeks">
                                                                                        <?php
                                                                                        for ($i = 0; $i < $month->getWeeks(); $i++) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <?php
                                                                                                foreach ($month->days as $k => $day) {
                                                                                                    $date = (clone $start)->modify("+".($k + $i * 7)." days");
                                                                                                    ?>
                                                                                                    <td id="<?= strtotime($date->format('Y-m-d')) == strtotime($today) ? 'calendar__today': '';?>" class="<?= $month->withInMonth($date)? '' : 'calendar__othermonth';?> <?= in_array($date->format('Y-m-d'), array_slice($jours_feries, 0)) ? 'bg-secondary text-white' : '';?>">
                                                                                                        <?php if ($i === 0) {
                                                                                                            echo '<div class="calendar__weekday">'.$day.'</div>';
                                                                                                        }?>

                                                                                                        <div class="calendar__day">
                                                                                                            <button type="button" id="<?= $date->format('Y-m-d');?>" class="btn btn-sm btn-light button_jour_calendrier" data-bs-toggle="modal" data-bs-target="#calendrierJourDetailsModal"><?= $date->format('d');?></button>
                                                                                                        </div>
                                                                                                        <div class="div_rdv">
                                                                                                            <?php
                                                                                                            $rdvs = $ETABLISSEMENTS->lister_rendez_vous($ets['code'], null, null, $date->format('Y-m-d'));
                                                                                                            $nb_rdvs = count($rdvs);
                                                                                                            $ligne_rdv = 0;
                                                                                                            foreach ($rdvs as $rdv) {
                                                                                                                if ($ligne_rdv <= 15) {
                                                                                                                    echo '<i class="bi bi-tropical-storm"></i>';
                                                                                                                }
                                                                                                                $ligne_rdv++;
                                                                                                            }
                                                                                                            ?>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="calendrierJourDetailsModal" tabindex="-1" aria-labelledby="calendrierJourDetailsModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="calendrierJourDetailsModalLabel"></h5>
                                                                                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body" id="div_details_calendrier"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_rendez_vous.js"></script>';
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
