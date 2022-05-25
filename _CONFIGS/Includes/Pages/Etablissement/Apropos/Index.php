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
                                                    if (in_array('AFF_APRPS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";

                                                                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                                require_once "../../../../Classes/SECTEURSACTIVITES.php";
                                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                                $SECTEURSACTIVITES = new SECTEURSACTIVITES();

                                                                $types = $ETABLISSEMENTS->lister_types_ets();
                                                                $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
                                                                $secteurs = $SECTEURSACTIVITES->lister();
                                                                $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($ets['code_pays']);
                                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($ets['code_region']);
                                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($ets['code_departement']);
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-info-circle"></i> A propos</li>
                                                                        </ol>
                                                                    </nav>
                                                                    <p class="p_page_titre h4"><i class="bi bi-building"></i> <?= ucwords(strtoupper($ets['raison_sociale']));?></p>
                                                                    <?php
                                                                    if (in_array('EDT_APRP', $sous_modules, true)) {
                                                                        ?>
                                                                        <div class="div_buttons">
                                                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i>Editer</button>
                                                                            <div class="modal fade" id="editionModal" tabindex="-1"
                                                                                 aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="editionModalLabel">Edition <?= ucwords(strtolower($ets['raison_sociale'])); ?></h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <?php include "../../_Forms/form_etablissement.php"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal fade" id="editionLogoModal" tabindex="-1" aria-labelledby="editionLogoModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="editionLogoModalLabel">
                                                                                                Logo <?= $ets['raison_sociale'];?></h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <?php include "../../_Forms/form_etablissement_logo.php"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div><br />
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div id="div_profil">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-sm-3">
                                                                                        <div class="card text-center">
                                                                                            <button type="button" id="button_ets_logo" class="btn" data-bs-toggle="modal" data-bs-target="#editionLogoModal"><img src="
                                                                                            <?php if (!$ets['logo']) {
                                                                                                echo IMAGES.'logos/etablissements/avatar.png';
                                                                                            } else {
                                                                                                echo IMAGES.'logos/etablissements/'.$ets['code'].'/'.$ets['logo'];
                                                                                            } ?>" class="card-img-top" alt="..."></button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <table class="table table-bordered table-lg table-hover">
                                                                                            <tr>
                                                                                                <td><strong>Code</strong></td>
                                                                                                <td id="code_ets_td" class="text-danger fw-bold"><?= $ets['code']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Raison sociale</strong></td>
                                                                                                <td><?= $ets['raison_sociale']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Niveau sanitaire</strong></td>
                                                                                                <td><?= $ets['libelle']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Secteur d'activité</strong></td>
                                                                                                <td><?= $ets['code_secteur_activite']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Situation géographique</strong></td>
                                                                                                <td><?= $ets['pays'] . ', ' . $ets['region'] . ', ' . $ets['departement'] . ', ' . $ets['commune']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Adresse postale</strong></td>
                                                                                                <td><?= $ets['adresse_postale']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Adresse géographique</strong></td>
                                                                                                <td><?= $ets['adresse_geographique']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>Coordonnées GPS</strong></td>
                                                                                                <td><?= $ets['latitude'] . ',' . $ets['longitude']; ?></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br/>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <p class="align_right">
                                                                                            <button type="button" id="button_ets_coordonnees" class="btn btn-outline-secondary btn-sm button_ets" disabled>Coordonnées</button>
                                                                                        </p><hr />
                                                                                        <div id="div_ets_donnees"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    display_ets_coordonnees(2, '<?= $ets['code'];?>');
                                                                </script>
                                                                <?php
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_a_propos.js"></script>';
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
