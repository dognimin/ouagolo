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
                                                    if (in_array('AFF_PRMTRS', $modules, true) && in_array('AFF_PRMTRS_UT', $sous_modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../../Menu.php";

                                                                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                                require_once "../../../../Classes/PROFILSUTILISATEURS.php";
                                                                require_once "../../../../Classes/CIVILITES.php";
                                                                require_once "../../../../Classes/SEXES.php";
                                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                                $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                                                                $CIVILITES = new CIVILITES();
                                                                $SEXES = new SEXES();

                                                                $profils = $PROFILSUTILISATEURS->lister();
                                                                $etablissements = $ETABLISSEMENTS->lister($ets['code'], null);
                                                                $civilites = $CIVILITES->lister();
                                                                $sexes = $SEXES->lister();
                                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($ets['code_pays']);
                                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($ets['code_region']);
                                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($ets['code_departement']);

                                                                if (isset($_POST['uid']) && $_POST['uid']) {
                                                                    $utilisateur = $ETABLISSEMENTS->trouver_utilisateur($ets['code'], $_POST['uid']);
                                                                    $etablissement_profils = $ETABLISSEMENTS->lister_profils($ets['code']);
                                                                    if ($utilisateur) {
                                                                        $utilisateur_habilitations = $ETABLISSEMENTS->trouver_habilitations($utilisateur['id_user']);

                                                                        require_once "../../../../Classes/TYPESCOORDONNEES.php";
                                                                        require_once "../../../../Classes/TYPESPERSONNES.php";
                                                                        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                                                        $TYPESPERSONNES = new TYPESPERSONNES();
                                                                        $profils = $PROFILSUTILISATEURS->lister();
                                                                        $types_personnes = $TYPESPERSONNES->lister();
                                                                        $types_coordonnees = $TYPESCOORDONNEES->lister();

                                                                        $utilisateur_statut = $UTILISATEURS->trouver_statut($utilisateur['id_user']);
                                                                        if ($utilisateur['code_sexe']) {
                                                                            $utilisateur_sexe = $SEXES->trouver($utilisateur['code_sexe']);
                                                                        } else {
                                                                            $utilisateur_sexe = array('code' => null, 'libelle' => null);
                                                                        }
                                                                        if ($utilisateur['code_civilite']) {
                                                                            $utilisateur_civilite = $SEXES->trouver($utilisateur['code_civilite']);
                                                                        } else {
                                                                            $utilisateur_civilite = array('code' => null, 'libelle' => null);
                                                                        }
                                                                        $utilisateur_coordonnees = $UTILISATEURS->lister_coordonnnees($utilisateur['id_user']);
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL . 'etablissement/parametres/utilisateurs'; ?>"><i class="bi bi-person-bounding-box"></i> Utilisateurs</a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></li>
                                                                                </ol>
                                                                            </nav>
                                                                            <p class="p_page_titre h4"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></p>
                                                                            <div id="div_resultats_user"></div>
                                                                            <?php
                                                                            if (in_array('EDT_PRMTRS_UT', $sous_modules, true)) {
                                                                                ?>
                                                                                <div class="div_buttons">
                                                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i>Editer</button>
                                                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="editionModalLabel">
                                                                                                        Edition <?= ucwords(strtolower($utilisateur['nom'])) . ' ' . ucwords(strtolower($utilisateur['prenoms'])); ?></h5>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <?php include "../../_Forms/form_utilisateur.php"; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <button type="button" class="btn btn-warning btn-sm"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#reinitialisationMotDePasseModal"><i class="bi bi-bootstrap-reboot"></i> Reinitialiser mot de passe</button>
                                                                                    <div class="modal fade" id="reinitialisationMotDePasseModal" tabindex="-1" aria-labelledby="reinitialisationMotDePasseModal" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-centered modal">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="reinitialisationMotDePasseModal">
                                                                                                        Voulez vous vraiment réinitialiser le mot de
                                                                                                        passe?</h5>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <?php include "../../_Forms/form_utilisateur_reinitialisation_mot_de_passe.php"; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <button type="button" class="btn btn-warning btn-sm"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#profilModal"><i class="bi bi-bootstrap-reboot"></i> Profil</button>
                                                                                    <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="profilModalLabel">Profil <?= $utilisateur['prenoms'];?></h5>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <?php include "../../_Forms/form_etablissement_profil_utilisateur.php"; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="modal fade" id="editionPhotoModal" tabindex="-1" aria-labelledby="editionPhotoModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="editionPhotoModalLabel">
                                                                                                        Photo <?= $utilisateur['prenoms'];?></h5>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <?php include "../../_Forms/form_utilisateur_photo.php"; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <div id="div_profil">
                                                                                <div class="row">
                                                                                    <div class="col-sm-2">
                                                                                        <button type="button" id="button_utilisateur_photo" class="btn" data-bs-toggle="modal" data-bs-target="#editionPhotoModal"><img src="
                                                                                <?php if ($utilisateur['photo']) {
                                                                                                echo IMAGES.'photos_profil/utilisateurs/'.$utilisateur['id_user'].'/'.$utilisateur['photo'];
                                                                                } else {
                                                                                    echo IMAGES.'photos_profil/avatar.png';
                                                                                }?>" style="width: 100%" class="img-thumbnail" alt="Photo <?= $utilisateur['prenoms'];?>"></button>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-body">
                                                                                                <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                                    <tr>
                                                                                                        <td><strong>Statut</strong></td>
                                                                                                        <td>
                                                                                                            <div class="form-check form-switch">
                                                                                                                <input class="form-check-input" type="checkbox" id="statut_check_input"
                                                                                                                    <?php
                                                                                                                    if ((int)($utilisateur_statut['statut']) === 1) {
                                                                                                                        echo 'checked';
                                                                                                                    }
                                                                                                                    if ($user['id_user'] === $utilisateur['id_user'] || !in_array('EDT_PRMTRS_UT', $sous_modules, true)) {
                                                                                                                        echo ' disabled';
                                                                                                                    }
                                                                                                                    ?>>
                                                                                                                <label class="form-check-label" for="statut_check_input"> <?= str_replace('1', 'Actif', str_replace('0', 'Inactif', $utilisateur_statut['statut'])); ?></label>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Civilité</strong></td>
                                                                                                        <td><?= $utilisateur_civilite['libelle']; ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Nom complet</strong></td>
                                                                                                        <td><?= $utilisateur['nom'] . ' ' . $utilisateur['prenoms']; ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Sexe</strong></td>
                                                                                                        <td><?= $utilisateur_sexe['libelle']; ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Email</strong></td>
                                                                                                        <td>
                                                                                                            <a href="mailto:<?= $utilisateur['email']; ?>"><?= $utilisateur['email']; ?></a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>N° téléphone</strong></td>
                                                                                                        <td></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Adresse</strong></td>
                                                                                                        <td></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br/>
                                                                                <div class="row" hidden>
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-body">
                                                                                                <p class="align_right">
                                                                                                    <button type="button" class="btn btn-sm btn-secondary">Coordonnées</button>
                                                                                                    <button type="button" class="btn btn-sm btn-secondary">Habilitations</button>
                                                                                                </p><hr />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php

                                                                        echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                                                                        echo '<script src="' . JS . 'page_parametres_utilisateurs.js"></script>';
                                                                    } else {
                                                                        echo '<script>window.location.href="' . URL . 'parametres/utilisateurs/"</script>';
                                                                    }
                                                                } else {
                                                                    $ets_utilisateurs = $ETABLISSEMENTS->lister_utilisateurs($ets['code']);
                                                                    $nb_ets_utilisateurs = count($ets_utilisateurs);
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-bounding-box"></i> Utilisateurs</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PRMTRS_UT', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                            <div class="modal fade" id="editionModal" tabindex="-1"
                                                                                 aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="editionModalLabel">Nouvel utilisateur</h5></div>
                                                                                        <div class="modal-body">
                                                                                            <?php include "../../_Forms/form_utilisateur.php"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-people"></i> Utilisateurs</p>
                                                                        <div class="col-sm-12">
                                                                            <?php
                                                                            if ($nb_ets_utilisateurs !== 0) {
                                                                                ?>
                                                                                <table class="table table-bordered table-sm table-hover table-stripped" id="table_utilisateurs">
                                                                                    <thead class="bg-indigo text-white">
                                                                                    <tr>
                                                                                        <th style="width: 5px">#</th>
                                                                                        <th style="width: 150px">CIVILITE</th>
                                                                                        <th>NOM & PRENOM(S)</th>
                                                                                        <th>EMAIL</th>
                                                                                        <th style="width: 150px">SEXE</th>
                                                                                        <th style="width: 5px"></th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <?php
                                                                                    $ligne = 1;
                                                                                    foreach ($ets_utilisateurs as $ets_utilisateur) {
                                                                                        $ets_utilisateur_civilite = $CIVILITES->trouver($ets_utilisateur['code_civilite']);
                                                                                        $ets_utilisateur_sexe = $SEXES->trouver($ets_utilisateur['code_sexe']);
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td class="align_right"><?= $ligne;?></td>
                                                                                            <td><?= $ets_utilisateur_civilite['libelle'];?></td>
                                                                                            <td><?= $ets_utilisateur['nom'].' '.$ets_utilisateur['prenoms'];?></td>
                                                                                            <td><a href="mailto:<?= $ets_utilisateur['email'];?>"><?= $ets_utilisateur['email'];?></a></td>
                                                                                            <td><?= $ets_utilisateur_sexe['libelle'];?></td>
                                                                                            <td class="bg-info"><a href="<?= URL.'etablissement/parametres/utilisateurs?uid='.$ets_utilisateur['id_user'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $ligne++;
                                                                                    }
                                                                                    ?>
                                                                                    </tbody>
                                                                                </table>
                                                                                <?php
                                                                            } else {
                                                                                echo '<p class="alert alert-info">Aucun utilisateur n\'a encore été enregistré pour cet établissement.</p>';
                                                                            }
                                                                            ?>
                                                                        </div>

                                                                    </div>
                                                                    <?php
                                                                }

                                                                echo '<script src="'.JS.'page_etablissement_parametres_utilisateurs.js"></script>';
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
