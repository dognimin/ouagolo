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
                                            if($audit['success'] == true) {
                                                include "../../Menu.php";
                                                require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                require_once "../../../Classes/ORGANISMES.php";
                                                $ORGANISMES = new ORGANISMES();
                                                $payss = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                ?>
                                                <div class="container-xl" id="div_main_page">
                                                    <?php
                                                    if (isset($_POST['code']) && $_POST['code']) {
                                                        $organisme = $ORGANISMES->trouver(strtoupper(clean_data($_POST['code'])));
                                                        if($organisme) {
                                                            $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($organisme['code_pays']);
                                                            $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($organisme['code_region']);
                                                            $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($organisme['code_departement']);
                                                            ?>
                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                <ol class="breadcrumb">
                                                                    <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organismes/';?>"><i class="bi bi-award"></i> Assurances / Mutuelles</a></li>
                                                                    <li class="breadcrumb-item active" aria-current="page"><?= $organisme['libelle'];?></li>
                                                                </ol>
                                                            </nav>
                                                            <p class="p_page_titre h4"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></p>
                                                            <div id="div_resultats_organisme"></div>
                                                            <div class="div_buttons">
                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i>Editer</button>
                                                                <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Edition <?= $organisme['libelle']; ?></h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php include "../_Forms/form_organisme.php"; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="<?= URL.'organismes/utilisateurs?code-organisme='.strtolower($organisme['code']);?>" class="btn btn-warning btn-sm"><i class="bi bi-people"></i> Utilisateurs</a>
                                                            </div>
                                                            <br/>
                                                            <div id="div_profil">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="card text-center">
                                                                                    <button type="button" id="button_ets_logo" class="btn" data-bs-toggle="modal" data-bs-target="#editionLogoModal"><img src="<?php if(!$organisme['logo']){echo '1';}else {echo '2';}?>" class="card-img-top" alt="..."></button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                    <tr>
                                                                                        <td style="width: 150px"><strong>Nom</strong></td>
                                                                                        <td><?= $organisme['libelle']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Adresse postale</strong></td>
                                                                                        <td><?= $organisme['adresse_postale']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Adresse géographique</strong></td>
                                                                                        <td><?= $organisme['adresse_geographique']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Pays</strong></td>
                                                                                        <td><?= $organisme['nom_pays']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Région</strong></td>
                                                                                        <td><?= $organisme['nom_region']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Département</strong></td>
                                                                                        <td><?= $organisme['nom_departement']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><strong>Commune</strong></td>
                                                                                        <td><?= $organisme['nom_commune']; ?></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }else {
                                                            echo '<script>window.location.href="'.URL.'organismes/"</script>';
                                                        }
                                                    }
                                                    else {
                                                        $pays_organismes = $ORGANISMES->lister_pays();
                                                        $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                                        $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                                        $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);
                                                        ?>
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-award"></i> Organismes</li>
                                                            </ol>
                                                        </nav>
                                                        <p class="align_right p_button">
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Nouvel organisme"><i class="bi bi-plus-square-fill"></i></button>
                                                            <a href="<?= URL.'organismes/baremes';?>" class="btn btn-dark btn-sm" title="Barèmes"><i class="bi bi-water"></i></a>
                                                        </p>
                                                        <p class="p_page_titre h4"><i class="bi bi-award"></i> Organismes</p>
                                                        <div class="col-sm-12"><?php include "../_Forms/form_search_organismes.php"; ?></div>
                                                        <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editionModalLabel">Nouvel
                                                                            organisme</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php include "../_Forms/form_organisme.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                                echo '<script src="'.JS.'page_organismes.js"></script>';
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