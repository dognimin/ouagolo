<?php
require_once "../../../../Classes/UTILISATEURS.php";
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        require_once "../../../../Classes/PROFILSUTILISATEURS.php";
        require_once "../../../../Classes/CIVILITES.php";
        require_once "../../../../Classes/SEXES.php";
        require_once "../../../../Classes/TYPESPERSONNES.php";
        require_once "../../../../Classes/ETABLISSEMENTS.php";
        require_once "../../../../Classes/ETABLISSEMENTS.php";
        require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
        require_once "../../../../Classes/PROFILSUTILISATEURS.php";
        require_once "../../../../Classes/TYPESCOORDONNEES.php";
        require_once "../../../../Classes/GROUPESSANGUINS.php";
        require_once "../../../../Functions/Functions.php";
        $UTILISATEURS = new UTILISATEURS();
        $CIVILITES = new CIVILITES();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $SEXES = new SEXES();
        $TYPESPERSONNESECU = new TYPESPERSONNES();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
        $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
        $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
        $GROUPESSANGUINS = new GROUPESSANGUINS();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        if ($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if ($user_statut) {
                if ($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if ($user_mdp) {
                        if ($user_mdp['statut'] == 1) {
                            if (isset($_POST['uid'])) {
                                $sexes = $SEXES->lister();
                                $civilites = $CIVILITES->lister();
                                $profils = $PROFILSUTILISATEURS->lister();
                                $utilisateur = $UTILISATEURS->trouver($_POST['uid'], null, null);

                                if ($utilisateur) {
                                    $etablissement_responsable = $ETABLISSEMENTS->trouver_responsable($_POST['uid']);
                                    $etablissement_agent= $ETABLISSEMENTS->trouver_agent($_POST['uid']);
                                    $etablissement = $ETABLISSEMENTS->trouver_etablissement($etablissement_responsable['code_etablissement']);
                                    $profil_u = $PROFILSUTILISATEURS->trouver($utilisateur['code_profil_utilisateur']);
                                    $statut_u = $UTILISATEURS->trouver_statut($utilisateur['id_user']);
                                    $sexe_u = $SEXES->trouver($utilisateur['code_sexe']);
                                    $civilite_u = $CIVILITES->trouver($utilisateur['code_civilite']);
                                    $typespersonnes = $TYPESPERSONNESECU->lister();
                                    $coordonnees = $UTILISATEURS->lister_coordonnnees($_POST['uid']);
                                    $profils = $PROFILSUTILISATEURS->lister();
                                    $civilites = $CIVILITES->lister();
                                    $sexes = $SEXES->lister();
                                    $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($utilisateur['code_pays']);
                                    $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($utilisateur['code_region']);
                                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($utilisateur['code_departement']);
                                    $ECU = $UTILISATEURS->lister_ecu($_POST['uid']);
                                    $types_coordonnees = $TYPESCOORDONNEES->lister();

                                    include "../../../Menu.php";
                                    ?>
                                    <div class="container-xl" id="div_main_page">
                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                <li class="breadcrumb-item"><a href="<?= URL . 'parametres/utilisateurs/'; ?>"><i class="bi bi-person-bounding-box"></i> Utilisateurs</a></li>
                                                <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($utilisateur['nom'] . ' ' . $utilisateur['prenoms'])); ?></li>
                                            </ol>
                                        </nav>
                                        <p class="p_page_titre h4"><?= ucwords(strtolower($utilisateur['nom'].' '.$utilisateur['prenoms'])); ?></p>
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

                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reinitialisationMotDePasseModal"><i class="bi bi-bootstrap-reboot"></i> Reinitialiser mot de passe</button>
                                            <div class="modal fade" id="reinitialisationMotDePasseModal" tabindex="-1" aria-labelledby="reinitialisationMotDePasseModal" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="reinitialisationMotDePasseModal">Voulez <?=  $etablissement['code_etablissement'] ?>vous
                                                                vraiment reinitialiser le mot de passe?</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php include "../../_Forms/form_utilisateur_reinitialisation_mot_de_passe.php"; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionProfilModal"><i class="bi bi-pencil-square"></i> Modifier le profil</button>
                                            <div class="modal fade" id="editionProfilModal" tabindex="-1" aria-labelledby="editionProfilModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editionProfilModal">Edition du
                                                                profil <?= ucwords(strtolower($utilisateur['prenoms'])); ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php include "../../_Forms/form_utilisateur_profil.php"; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="div_profil">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p class="h5 align_center">
                                                                <b class="b_photo">
                                                                    <button><?php $acronyme = acronyme(ucwords(strtolower($utilisateur['nom'])) . ' ' . ucwords(strtolower($utilisateur['prenoms'])), 2);echo $acronyme; ?></button>
                                                                </b><br/>
                                                                <?= ucwords(strtolower($utilisateur['nom'])) . ' ' . ucwords(strtolower($utilisateur['prenoms'])); ?>
                                                                <br/>
                                                                <small><?= ucwords(strtolower($profil_u['libelle'])); ?></small><br/>
                                                                <small>Lieu résidence</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p id="p_groupe_sanguin"><strong><?= $utilisateur['groupe_sanguin'];?><sup><?= $utilisateur['code_rhesus'];?></sup></strong></p>
                                                            <table class="table table-bordered table-lg table-hover">
                                                                <tr>
                                                                    <td><strong>Statut</strong></td>
                                                                    <td>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" id="statut_check_input" <?php if ($statut_u['statut'] == 1) {echo 'checked';} ?>>
                                                                            <label class="form-check-label" for="statut_check_input"> <?= str_replace('1', 'Actif', str_replace('0', 'Inactif', $statut_u['statut'])); ?></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Pseudo</strong></td>
                                                                    <td><?= $utilisateur['pseudo']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Civilité</strong></td>
                                                                    <td><?= $civilite_u['libelle']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Nom complet</strong></td>
                                                                    <td><?= $utilisateur['nom'] . ' ' . $utilisateur['prenoms']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Sexe</strong></td>
                                                                    <td><?= $sexe_u['libelle']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Email</strong></td>
                                                                    <td><a href="mailto:<?= $utilisateur['email']; ?>"><?= $utilisateur['email']; ?></a></td>
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
                                            <br/>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <nav>
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <button class="nav-link active" id="nav-coordonnees-tab" data-bs-toggle="tab" data-bs-target="#nav-coordonnees" type="button" role="tab" aria-controls="nav-coordonnees" aria-selected="true"><strong>Coordonnées</strong></button>
                                                                    <button class="nav-link" id="nav-personnel-tab" data-bs-toggle="tab" data-bs-target="#nav-personnel" type="button" role="tab" aria-controls="nav-personnel" aria-selected="false"><strong>Infos personnelles</strong></button>
                                                                    <button class="nav-link" id="nav-sante-tab" data-bs-toggle="tab" data-bs-target="#nav-sante" type="button" role="tab" aria-controls="nav-sante" aria-selected="false"><strong>Santé</strong></button>
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content" id="nav-tabContent">
                                                                <div class="tab-pane fade show active" id="nav-coordonnees" role="tabpanel" aria-labelledby="nav-coordonnees-tab"></div>
                                                                <div class="tab-pane fade" id="nav-personnel" role="tabpanel" aria-labelledby="nav-personnel-tab"></div>
                                                                <div class="tab-pane fade" id="nav-sante" role="tabpanel" aria-labelledby="nav-sante-tab"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    echo '<script src="' . JS . 'deconnexion_1.js"></script>';
                                    echo '<script src="' . JS . 'page_parametres_utilisateurs.js"></script>';
                                } else {
                                    echo '<script>window.location.href="' . URL . 'parametres/utilisateurs/"</script>';
                                }
                            } else {
                                echo '<script>window.location.href="' . URL . 'parametres/utilisateurs/"</script>';
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
?>
