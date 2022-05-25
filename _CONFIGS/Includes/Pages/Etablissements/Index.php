<?php
require_once "../../../Classes/UTILISATEURS.php";
require_once "../../../Functions/Functions.php";
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
                                    if($profil['code_profil'] == 'ADMN') {
                                        if (isset($parametres['url'])) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                            if ($audit['success'] == true) {
                                                include "../../Menu.php";
                                                require_once "../../../Classes/ETABLISSEMENTS.php";
                                                require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                require_once "../../../Classes/SECTEURSACTIVITES.php";
                                                $ETABLISSEMENTS = new ETABLISSEMENTS();
                                                $SECTEURS = new SECTEURSACTIVITES();
                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                $types = $ETABLISSEMENTS->lister_types_ets();
                                                $types_ets = $ETABLISSEMENTS->lister_types();
                                                $secteurs = $SECTEURS->lister();
                                                $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                                                $niveaux = $ETABLISSEMENTS->lister_niveaux_sanitaires();
                                                $niveaux_ets = $ETABLISSEMENTS->lister_niveaux();

                                                if(isset($_POST['code'])) {
                                                    $ets = $ETABLISSEMENTS->trouver($_POST['code'], null);
                                                    if($ets) {
                                                        ?>
                                                        <div class="container-xl" id="div_main_page">
                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                <ol class="breadcrumb">
                                                                    <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissements/';?>"><i class="bi bi-building"></i> Etablissements</a></li>
                                                                    <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtoupper($ets['raison_sociale']));?></li>
                                                                </ol>
                                                            </nav>
                                                            <p class="p_page_titre h4"><i class="bi bi-building"></i> <?= ucwords(strtoupper($ets['raison_sociale']));?></p>
                                                            <div class="div_buttons">
                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i> Editer</button>
                                                                <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Edition <?= ucwords(strtolower($ets['raison_sociale']));?></h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php include "../_Forms/form_etablissement.php";?>
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
                                                                                <?php include "../_Forms/form_etablissement_logo.php"; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><br />
                                                            <div id="div_profil">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="card text-center">
                                                                                    <button type="button" id="button_ets_logo" class="btn" data-bs-toggle="modal" data-bs-target="#editionLogoModal"><img src="<?php if(!$ets['logo']){echo IMAGES.'logos/etablissements/avatar.png';}else {echo IMAGES.'logos/etablissements/'.$ets['code'].'/'.$ets['logo'];} ?>" class="card-img-top" alt="..."></button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <table class="table table-bordered table-lg table-hover">
                                                                                    <tr>
                                                                                        <td><strong>Statut</strong></td>
                                                                                        <td>
                                                                                            <div class="form-check form-switch">
                                                                                                <input class="form-check-input" type="checkbox">
                                                                                                <label class="form-check-label" for="statut_check_input"> </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Code</strong></td>
                                                                                        <td><?= $ets['code']; ?></td>
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
                                                                                        <td><?=  $ets['code_secteur_activite']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Localisation géographique</strong></td>
                                                                                        <td><?=  $ets['pays'].' | '.$ets['region'].' | '.$ets['departement'].' | '.$ets['commune']; ?></td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td><strong>Donnée géographique</strong></td>
                                                                                        <td><?=  $ets['latitude'].','.$ets['longitude']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Site web</strong></td>
                                                                                        <td><a href="<?= strtolower($ets['site_web']);  ?>"><?=  $ets['site_web']; ?></a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Adresse postal</strong></td>
                                                                                        <td><?=  $ets['adresse_postale']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Adresse géographique</strong></td>
                                                                                        <td><?=  $ets['adresse_geographique']; ?></td>
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
                                                                                    <button type="button" id="button_ets_ps" class="btn btn-secondary btn-sm button_ets">Proféssionel(s) santé</button>
                                                                                    <button type="button" id="button_ets_services" class="btn btn-secondary btn-sm button_ets">Service(s)</button>
                                                                                    <button type="button" id="button_ets_utilisateurs" class="btn btn-secondary btn-sm button_ets">Utilisateur(s)</button>
                                                                                </p><hr />
                                                                                <div id="div_ets_donnees"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }else {
                                                        echo '<script>window.location.href="'.URL.'etablissements/"</script>';
                                                    }
                                                }
                                                else {
                                                    ?>
                                                    <div class="container-xl" id="div_main_page">
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building"></i> Etablissements</li>
                                                            </ol>
                                                        </nav>
                                                        <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Nouvel organisme"><i class="bi bi-plus-square-fill"></i></button></p>
                                                        <p class="p_page_titre h4"><i class="bi bi-building"></i> Etablissements</p>
                                                        <div class="col-sm-12"><?php include "../_Forms/form_search_etablissement.php"; ?></div>
                                                        <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editionModalLabel">Nouvel établissement</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php include "../_Forms/form_etablissement.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                                echo '<script src="'.JS.'page_etablissements.js"></script>';
                                            }else {
                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        }else {
                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
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