<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'],null);
            if($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if($user_statut) {
                    if($user_statut['statut'] == 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if($user_mdp) {
                            if($user_mdp['statut'] == 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if($profil['code_profil'] == 'ORGANI') {
                                        require_once "../../../../Classes/ORGANISMES.php";
                                        $ORGANISMES = new ORGANISMES();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                                        if($user_profil) {
                                            $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                                            if($organisme) {
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
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
                                                        $organismes = $ORGANISMES->lister();
                                                        $civilites = $CIVILITES->lister();
                                                        $sexes = $SEXES->lister();
                                                        $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($organisme['code_pays']);
                                                        $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($organisme['code_region']);
                                                        $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($organisme['code_departement']);


                                                        $organisme_utilisateurs = $ORGANISMES->lister_utilisateurs($organisme['code']);
                                                        $nb_organisme_utilisateurs = count($organisme_utilisateurs);

                                                        if (isset($_POST['uid']) && $_POST['uid']){
                                                            $utilisateur = $ORGANISMES->trouver_utilisateur($organisme['code'], $_POST['uid']);
                                                            if ($utilisateur) {
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
                                                                $coordonnees_requises = array('MOBPER','MOBPRO','MELPRO');
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/utilisateurs'; ?>"><i class="bi bi-person-bounding-box"></i> Utilisateurs</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $utilisateur['nom'].' '.$utilisateur['prenoms'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <p class="p_page_titre h4"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></p>
                                                                    <div id="div_resultats_user"></div>

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
                                                                            <?php
                                                                        }else {
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

                                                                    <div id="div_profil">
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <button type="button" id="button_utilisateur_photo" class="btn" data-bs-toggle="modal" data-bs-target="#editionPhotoModal"><img src="<?= ($utilisateur['photo'])? IMAGES.'photos_profil/utilisateurs/'.$utilisateur['id_user'].'/'.$utilisateur['photo']: IMAGES.'photos_profil/avatar.png'?>" style="width: 100%" class="img-thumbnail" alt="Photo <?= $utilisateur['prenoms'];?>"></button>
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
                                                                                                            if ($user['id_user'] === $utilisateur['id_user']) {
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
                                                            }else {
                                                                echo '<script>window.location.href="'.URL.'organisme/parametres/utilisateurs"</script>';
                                                            }
                                                        }else {
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-bounding-box"></i> Utilisateurs</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                <p class="p_page_titre h4"><i class="bi bi-people"></i> Utilisateurs</p>
                                                                <div class="col-sm-12">
                                                                    <?php
                                                                    if($nb_organisme_utilisateurs != 0) {
                                                                        ?>
                                                                        <table class="table table-bordered table-hover table-sm table-striped" id="table_utilisateurs">
                                                                            <thead class="bg-indigo text-white">
                                                                            <tr>
                                                                                <th style="width: 5px">#</th>
                                                                                <th style="width: 110px">N° SECU</th>
                                                                                <th>NOM & PRENOM(S)</th>
                                                                                <th>EMAIL</th>
                                                                                <th style="width: 5px"></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $ligne = 1;
                                                                            foreach ($organisme_utilisateurs as $organisme_utilisateur) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="align_right"><?= $ligne; ?></td>
                                                                                    <td><?= $organisme_utilisateur['num_secu']; ?></td>
                                                                                    <td><?= $organisme_utilisateur['nom'] . ' ' . $organisme_utilisateur['prenoms']; ?></td>
                                                                                    <td><strong><a href="mailto:<?= $organisme_utilisateur['email']; ?>"><?= $organisme_utilisateur['email']; ?></a></strong></td>
                                                                                    <td class="bg-info"><a href="<?= URL . 'organisme/parametres/utilisateurs?uid=' . $organisme_utilisateur['id_user']; ?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                                                                                </tr>
                                                                                <?php
                                                                                $ligne++;
                                                                            }
                                                                            ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    else {
                                                                        ?>
                                                                        <p class="align_center alert alert-warning">Aucun utilisateur n'a encore été enregistré pour cet organisme. <br />Cliquez sur <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button> pour en ajouter un.</p>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="modal fade" id="editionModal" tabindex="-1"
                                                                     aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Nouvel utilisateur</h5></div>
                                                                            <div class="modal-body">
                                                                                <?php include "../../_Forms/form_utilisateur.php"; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_parametres_utilisateurs.js"></script>';
                                                    }else {
                                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                    }
                                                }else {
                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                }
                                            }else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        }else{
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    }else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                }else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            }else {

                                echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                            }
                        }else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                    }else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                }else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        }else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    }else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}