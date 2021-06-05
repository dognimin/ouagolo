<?php
require_once "../../../../Functions/Functions.php";
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/ETABLISSEMENTS.php";
require_once "../../../../Classes/SECTEURSACTIVITES.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
require_once "../../../../Classes/TYPESCOORDONNEES.php";
require_once "../../../../Classes/ETABLISSEMENTSSERVICES.php";


if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {

        $UTILISATEURS = new UTILISATEURS();
        $ETABLISSEMENTS = new ETABLISSEMENTS();
        $SECTEURS = new SECTEURSACTIVITES();
        $SERVICESETABLISSMENTS = new ETABLISSEMENTSSERVICES();
        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
        $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        $etablissement = $ETABLISSEMENTS->trouver_etablissement($_POST['code']);
        $responsables = $ETABLISSEMENTS->lister_ets_responsables_libres();
        if ($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if ($user_statut) {
                if ($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    $responsable_etablissement = $ETABLISSEMENTS->trouver_responsable($_POST['code']);
                    $types = $ETABLISSEMENTS->lister_types_ets();
                    $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
                    $secteurs = $SECTEURS->lister();
                    $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($etablissement['code_pays']);
                    $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($etablissement['code_region']);
                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($etablissement['code_departement']);
                    $types_coordonnees = $TYPESCOORDONNEES->lister();
                    $services_etablissements = $SERVICESETABLISSMENTS->lister();

                    if ($user_mdp) {
                        if ($user_mdp['statut'] == 1) {
                            if (isset($_POST['code'])) {
                                include "../../../Menu.php";
                                ?>
                                <div class="container-xl" id="div_main_page">
                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                            <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                            <li class="breadcrumb-item"><a href="<?= URL . 'parametres/etablissements/'; ?>"><i class="bi bi-building"></i> Etablissements</a></li>
                                            <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtoupper($etablissement['raison_sociale'])); ?></li>
                                        </ol>
                                    </nav>
                                    <p class="p_page_titre h4"><i class="bi bi-building"></i> <?= ucwords(strtoupper($etablissement['raison_sociale'])); ?>
                                    </p>
                                    <div id="div_resultats_user"></div>
                                    <div class="div_buttons">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i>
                                            Editer
                                        </button>
                                        <div class="modal fade" id="editionModal" tabindex="-1"
                                             aria-labelledby="editionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editionModalLabel">
                                                            Edition <?= ucwords(strtolower($etablissement['raison_sociale'])); ?></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php include "../../_Forms/form_etablissements.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionResponsableModal"><?php if ($responsable_etablissement) {echo 'Retirer Responsable';} else {echo 'Ajouter Responsable';} ?></button>
                                        <div class="modal fade" id="editionResponsableModal" tabindex="-1"
                                             aria-labelledby="editionResponsableModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editionResponsableModalLabel"><?php if ($responsable_etablissement) {echo 'Retirer Responsable';} else {echo 'Ajouter Responsable';} ?></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php include "../../_Forms/form_etablissement_responsable.php"; ?>
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
                                                            <b class="b_photo"><button><?php $acronyme = acronyme(ucwords(strtolower($etablissement['raison_sociale'])) . ' ' . ucwords(strtolower($etablissement['raison_sociale'])), 2);echo $acronyme; ?></button></b><br/>
                                                            <?= $etablissement['raison_sociale']; ?>
                                                            <br/>
                                                            <small><b><?= $etablissement['libelle'];?></b></small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-lg table-hover">
                                                            <tr>
                                                                <td style="width: 200px"><strong>Responsable</strong></td>
                                                                <td><a href="<?= URL . 'parametres/utilisateurs/details?uid=' . $responsable_etablissement['id_user']; ?>"><h6> <?= ucwords(strtoupper($responsable_etablissement['nom'] . ' ' . $responsable_etablissement['prenoms'])); ?></h6></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Code</strong></td>
                                                                <td id="code_ets_td" class="text-danger fw-bold"><?= $etablissement['code']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Raison sociale</strong></td>
                                                                <td><?= $etablissement['raison_sociale']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Niveau sanitaire</strong></td>
                                                                <td><?= $etablissement['libelle']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Secteur d'activité</strong></td>
                                                                <td><?= $etablissement['code_secteur_activite']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Site web</strong></td>
                                                                <td><a href="<?= strtolower($etablissement['site_web']); ?>"><?= $etablissement['site_web']; ?></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Situation géographique</strong></td>
                                                                <td><?= $etablissement['pays'] . ', ' . $etablissement['region'] . ', ' . $etablissement['departement'] . ', ' . $etablissement['commune']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Adresse postal</strong></td>
                                                                <td><?= $etablissement['adresse_postale']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Adresse géographique</strong></td>
                                                                <td><?= $etablissement['adresse_geographique']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Coordonnées GPS</strong></td>
                                                                <td><?= $etablissement['latitude'] . ',' . $etablissement['longitude']; ?></td>
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
                                                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-coordonnees" type="button" role="tab" aria-controls="nav-coordonnees" aria-selected="true">Coordonnées</button>
                                                                <button class="nav-link" id="nav-professionnel-sante-tab" data-bs-toggle="tab" data-bs-target="#nav-professionnel-sante" type="button" role="tab" aria-controls="nav-professionnel-sante" aria-selected="false">Professionnels de santé</button>
                                                                <button class="nav-link" id="nav-agent-tab" data-bs-toggle="tab" data-bs-target="#nav-agent" type="button" role="tab" aria-controls="nav-agent" aria-selected="false">Agents</button>
                                                                <button class="nav-link" id="nav-service-tab" data-bs-toggle="tab" data-bs-target="#nav-service" type="button" role="tab" aria-controls="nav-service" aria-selected="false">Services du centre</button>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="nav-coordonnees" role="tabpanel" aria-labelledby="nav-coordonnees-tab"></div>
                                                            <div class="tab-pane fade" id="nav-professionnel-sante" role="tabpanel" aria-labelledby="nav-professionnel-sante-tab"></div>
                                                            <div class="tab-pane fade" id="nav-agent" role="tabpanel" aria-labelledby="nav-agent-tab"></div>
                                                            <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                                echo '<script src="' . JS . 'page_parametres_etablissements.js"></script>';

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
