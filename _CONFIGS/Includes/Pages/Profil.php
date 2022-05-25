<?php
require_once "../../Classes/UTILISATEURS.php";
require_once "../../Functions/Functions.php";
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
                                    if (isset($parametres['url'])) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                        if ($audit['success'] == true) {
                                            require_once "../../Classes/SEXES.php";
                                            require_once "../../Classes/CIVILITES.php";
                                            require_once "../../Classes/ORGANISMES.php";
                                            require_once "../../Classes/TYPESPERSONNES.php";
                                            require_once "../../Classes/ETABLISSEMENTS.php";
                                            require_once "../../Classes/TYPESCOORDONNEES.php";
                                            require_once "../../Classes/PROFILSUTILISATEURS.php";
                                            require_once "../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";

                                            $SEXES = new SEXES();
                                            $CIVILITES = new CIVILITES();
                                            $ORGANISMES = new ORGANISMES();
                                            $ETABLISSEMENTS = new ETABLISSEMENTS();
                                            $TYPESPERSONNES = new TYPESPERSONNES();
                                            $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                            $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                                            $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                            if ($profil['code_profil'] === 'ETABLI') {
                                                $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                                if ($user_profil) {
                                                    $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                                }
                                            } elseif ($profil['code_profil'] === 'ORGANI') {
                                                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                                                if ($user_profil) {
                                                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                                                }
                                            }

                                            include "../Menu.php";

                                            $utilisateur = $user;



                                            $civilites = $CIVILITES->lister();
                                            $sexes = $SEXES->lister();
                                            $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                            $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                            $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                            $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);

                                            $profils = $PROFILSUTILISATEURS->lister();
                                            $types_personnes = $TYPESPERSONNES->lister();
                                            $types_coordonnees = $TYPESCOORDONNEES->lister();

                                            $utilisateur_profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
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

                                            $utilisateur_organisme = $UTILISATEURS->trouver_utilisateur_organisme($utilisateur['id_user']);
                                            $utilisateur_ets = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                                            $utilisateur_coordonnees = $UTILISATEURS->lister_coordonnnees($utilisateur['id_user']);
                                            $coordonnees_requises = array('MOBPER','MOBPRO');
                                            ?>
                                            <div class="container-xl" id="div_main_page">
                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person"></i> <?= $utilisateur['nom'].' '.$utilisateur['prenoms'];?></li>
                                                    </ol>
                                                </nav>
                                                <p class="p_page_titre h4"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></p>
                                                <div id="div_resultats_user"></div>
                                                <div class="div_buttons">
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i> Editer</button>
                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editionModalLabel">
                                                                        Edition <?= ucwords(strtolower($utilisateur['nom'])) . ' ' . ucwords(strtolower($utilisateur['prenoms'])); ?></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php include "_Forms/form_utilisateur.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionCoordonneesModal"><i class="bi bi-pencil-square"></i> Coordonnées</button>
                                                    <div class="modal fade" id="editionCoordonneesModal" tabindex="-1" aria-labelledby="editionCoordonneesModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editionCoordonneesModalLabel">Mise à jour des coordonnées</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php include "_Forms/form_utilisateur_coordonnee.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionMotDePasseModal"><i class="bi bi-lock"></i> Mot de passe</button>
                                                    <div class="modal fade" id="editionMotDePasseModal" tabindex="-1" aria-labelledby="editionMotDePasseModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editionMotDePasseModalLabel">Modifier le mot de passe</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php include "_Forms/form_mot_de_passe.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                                    <button type="button" id="button_utilisateur_photo" class="btn" data-bs-toggle="modal" data-bs-target="#editionPhotoModal"><img src="<?php if ($utilisateur['photo']) {
                                                                        echo IMAGES.'photos_profil/utilisateurs/'.$utilisateur['id_user'].'/'.$utilisateur['photo'];
                                                                                                                                                                                                         } else {
                                                                                                                                                                                                             echo IMAGES.'photos_profil/avatar.png';
                                                                                                                                                                                                         }?>" style="width: 100%" class="img-thumbnail" alt="Photo <?= $utilisateur['prenoms'];?>"></button>
                                                                    <div class="modal fade" id="editionPhotoModal" tabindex="-1" aria-labelledby="editionPhotoModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="editionPhotoModalLabel">
                                                                                        Photo <?= $utilisateur['prenoms'];?></h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <?php include "_Forms/form_utilisateur_photo.php"; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <table class="table table-bordered table-sm table-stripped table-hover">
                                                                        <tr>
                                                                            <td><strong>Profil</strong></td>
                                                                            <td><?= $utilisateur['code_profil'];?></td>
                                                                        </tr>
                                                                        <?php
                                                                        if ($utilisateur_profil['code_profil'] == 'ORGANI') {
                                                                            ?>
                                                                            <tr>
                                                                                <td><strong>Organisme</strong></td>
                                                                                <td><a href="<?= URL.'organismes/?code='.$utilisateur_organisme['code_organisme'];?>" target="_blank"><?= $utilisateur_organisme['libelle'];?></a></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        if ($utilisateur_profil['code_profil'] == 'ETABLI') {
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
                                            </div>
                                            <?php
                                            echo '<script src="' . JS . 'deconnexion_0.js"></script>';
                                            echo '<script src="' . JS . 'page_profil.js"></script>';
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                    }
                                    echo '<script src="' . JS . 'deconnexion_0.js"></script>';
                                    echo '<script src="' . JS . 'page_profil.js"></script>';
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
