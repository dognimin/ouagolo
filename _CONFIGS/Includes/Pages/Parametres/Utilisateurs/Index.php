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
                                                $tableau_profil_ets = array('ETABLI');
                                                $tableau_profil_organisme = array('ORGANI');
                                                require_once "../../../../Classes/SEXES.php";
                                                require_once "../../../../Classes/CIVILITES.php";
                                                require_once "../../../../Classes/ORGANISMES.php";
                                                require_once "../../../../Classes/TYPESPERSONNES.php";
                                                require_once "../../../../Classes/ETABLISSEMENTS.php";
                                                require_once "../../../../Classes/TYPESCOORDONNEES.php";
                                                require_once "../../../../Classes/PROFILSUTILISATEURS.php";
                                                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";

                                                $SEXES = new SEXES();
                                                $CIVILITES = new CIVILITES();
                                                $ORGANISMES = new ORGANISMES();
                                                $ETABLISSEMENTS = new ETABLISSEMENTS();
                                                $TYPESPERSONNES = new TYPESPERSONNES();
                                                $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                                $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();

                                                $civilites = $CIVILITES->lister();
                                                $sexes = $SEXES->lister();
                                                $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);


                                                include "../../../Menu.php";
                                                ?>
                                                <div class="container-xl" id="div_main_page">
                                                    <?php
                                                    if (isset($_POST['uid']) && $_POST['uid']) {
                                                        $utilisateur = $UTILISATEURS->trouver($_POST['uid'], null);
                                                        if ($utilisateur) {
                                                            if ($user['id_user'] != $utilisateur['id_user']) {
                                                                $profils = $PROFILSUTILISATEURS->lister();
                                                                $types_personnes = $TYPESPERSONNES->lister();
                                                                $types_coordonnees = $TYPESCOORDONNEES->lister();

                                                                $user_profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                                                                $user_statut = $UTILISATEURS->trouver_statut($utilisateur['id_user']);
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

                                                                $utilisateur_organisme = $UTILISATEURS->trouver_utilisateur_organisme($utilisateur['id_user']);
                                                                $utilisateur_ets = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                                                                $utilisateur_coordonnees = $UTILISATEURS->lister_coordonnnees($utilisateur['id_user']);
                                                                $coordonnees_requises = array('MOBPER','MOBPRO');
                                                                ?>
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i>Accueil</a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'parametres/utilisateurs/'; ?>"><i class="bi bi-person-bounding-box"></i> Utilisateurs</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="p_page_titre h4"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></p>
                                                                <div id="div_resultats_user"></div>
                                                                <div class="div_buttons">
                                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i>Editer</button>
                                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                                                    <?php
                                                                    if ($user['id_user'] != $utilisateur['id_user']) {
                                                                        ?>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reinitialisationMotDePasseModal" <?= ($user_statut['statut'] == 0)? 'disabled': null;?>><i class="bi bi-bootstrap-reboot"></i> Reinitialiser mot de passe</button>
                                                                        <div class="modal fade" id="reinitialisationMotDePasseModal" tabindex="-1" aria-labelledby="reinitialisationMotDePasseModal" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="reinitialisationMotDePasseModal">Voulez vous vraiment réinitialiser le mot de passe?</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_utilisateur_reinitialisation_mot_de_passe.php"; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionProfilModal" <?= ($user_statut['statut'] == 0)? 'disabled': null;?>><i class="bi bi-pencil-square"></i> Modifier le profil</button>
                                                                        <div class="modal fade" id="editionProfilModal" tabindex="-1" aria-labelledby="editionProfilModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionProfilModal">Edition du profil <?= ucwords(strtolower($utilisateur['prenoms'])); ?></h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_utilisateur_profil.php"; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionHabilitationsModal"><i class="bi bi-pencil-square"></i> Habilitations</button>
                                                                        <div class="modal fade" id="editionHabilitationsModal" tabindex="-1" aria-labelledby="editionHabilitationsModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionHabilitationsModal">Habilitations</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_habilitations.php";?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionCoordonneesModal"><i class="bi bi-pencil-square"></i> Coordonnées</button>
                                                                        <div class="modal fade" id="editionCoordonneesModal" tabindex="-1" aria-labelledby="editionCoordonneesModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionCoordonneesModalLabel">Mise à jour des coordonnées</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_utilisateur_coordonnee.php"; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionMotDePasseModal"><i class="bi bi-pencil-square"></i>Mot de passe</button>
                                                                        <div class="modal fade" id="editionMotDePasseModal" tabindex="-1" aria-labelledby="editionMotDePasseModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionMotDePasseModalLabel">Modifier le mot de passe</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_mot_de_passe.php"; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <button type="button" class="btn btn-dark btn-sm button_logs" id="<?= $utilisateur['id_user'];?>" data-bs-toggle="modal" data-bs-target="#affichageLogsModal"><i class="bi bi-pencil-square"></i> Logs</button>
                                                                    <div class="modal fade" id="affichageLogsModal" tabindex="-1" aria-labelledby="affichageLogsModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="affichageLogsModalLabel">Logs <?= $utilisateur['prenoms'];?></h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body" id="div_logs"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br/>
                                                                <div id="div_profil">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <button type="button" id="button_utilisateur_photo" class="btn" data-bs-toggle="modal" data-bs-target="#editionPhotoModal"><img src="<?= ($utilisateur['photo'])? IMAGES.'photos_profil/utilisateurs/'.$utilisateur['id_user'].'/'.$utilisateur['photo']: IMAGES.'photos_profil/avatar.png'?>" style="width: 100%" class="img-thumbnail" alt="Photo <?= $utilisateur['prenoms'];?>"></button>
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
                                                                                <div class="col">
                                                                                    <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                        <tr>
                                                                                            <td><strong>Statut</strong></td>
                                                                                            <td>
                                                                                                <div class="form-check form-switch">
                                                                                                    <input class="form-check-input" type="checkbox" id="statut_check_input" <?= ($user_statut['statut'] == 1)? 'checked': 'null';?> <?= ($user['id_user'] === $utilisateur['id_user'])? ' disabled': null;?>>
                                                                                                    <label class="form-check-label text-<?= str_replace('1', 'success', str_replace('2', 'warning', str_replace('0', 'danger', $user_statut['statut'])));?>" for="statut_check_input"><strong><?= str_replace('1', 'Actif', str_replace('2', 'Vérouillé', str_replace('0', 'Inactif', $user_statut['statut'])));?></strong></label>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><strong>Profil</strong></td>
                                                                                            <td><?= $utilisateur['code_profil'];?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        if ($user_profil['code_profil'] == 'ORGANI') {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><strong>Organisme</strong></td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if($utilisateur_organisme) {
                                                                                                        ?>
                                                                                                        <a href="<?= URL.'organismes/?code='.$utilisateur_organisme['code_organisme'];?>" target="_blank"><?= $utilisateur_organisme['libelle'];?></a>
                                                                                                        <?php
                                                                                                    }else {
                                                                                                        echo '<strong class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Aucun organisme défini. <i class="bi bi-exclamation-triangle-fill"></i></strong>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        if ($user_profil['code_profil'] == 'ETABLI') {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><strong>Etablissement</strong></td>
                                                                                                <td><a href="<?= URL.'etablissements/?code='.$utilisateur_ets['code_etablissement'];?>" target="_blank"><?= $utilisateur_ets['raison_sociale'];?></a></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
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
                                                                                            <td>Nom</td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                echo '<script>window.location.href="' . URL . 'profil"</script>';
                                                            }
                                                        } else {
                                                            echo '<script>window.location.href="' . URL . 'parametres/utilisateurs/"</script>';
                                                        }
                                                    } else {
                                                        $profil_utilisateurs = $UTILISATEURS->lister_profils();
                                                        ?>
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-bounding-box"></i> Utilisateurs</li>
                                                            </ol>
                                                        </nav>
                                                        <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                        <p class="p_page_titre h4"><i class="bi bi-person-bounding-box"></i> Utilisateurs</p>
                                                        <div class="modal fade" id="editionModal" tabindex="-1"
                                                             aria-labelledby="editionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editionModalLabel">Nouvel utilisateur</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php include "../../_Forms/form_utilisateur.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"><?php include "../../_Forms/form_search_utilisateurs.php"; ?></div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                                                echo '<script src="' . JS . 'page_parametres_utilisateurs.js"></script>';
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
                                    echo '<script>window.location.href="' . URL . '"</script>';
                                }
                            } else {
                                echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
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
} else {
    session_destroy();
    echo '<script>window.location.href="' . URL . 'connexion"</script>';
}
