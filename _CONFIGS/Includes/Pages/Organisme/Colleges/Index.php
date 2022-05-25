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
                                                        require_once "../../../../Classes/POLICES.php";
                                                        require_once "../../../../Classes/COLLEGES.php";
                                                        $COLLEGES = new COLLEGES();
                                                        $POLICES = new POLICES();


                                                        $polices = $POLICES->lister($organisme['code']);
                                                        include "../../../Menu.php";
                                                        if(isset($_POST['id_police']) && $_POST['id_police']) {
                                                            $police = $POLICES->trouver($organisme['code'], $_POST['id_police']);
                                                            if($police) {
                                                                if(isset($_POST['code'])) {


                                                                    $college = $COLLEGES->trouver($police['id_police'], $_POST['code']);
                                                                    if($college) {
                                                                        require_once "../../../../Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                                                                        require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                                        require_once "../../../../Classes/SITUATIONSFAMILIALES.php";
                                                                        require_once "../../../../Classes/SECTEURSACTIVITES.php";
                                                                        require_once "../../../../Classes/TYPESCOORDONNEES.php";
                                                                        require_once "../../../../Classes/GROUPESSANGUINS.php";
                                                                        require_once "../../../../Classes/QUALITESCIVILES.php";
                                                                        require_once "../../../../Classes/RESEAUXDESOINS.php";
                                                                        require_once "../../../../Classes/PROFESSIONS.php";
                                                                        require_once "../../../../Classes/CIVILITES.php";
                                                                        require_once "../../../../Classes/PRODUITS.php";
                                                                        require_once "../../../../Classes/SEXES.php";
                                                                        $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                                                                        $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                                        $SITUATIONSFAMILIALES = new SITUATIONSFAMILIALES();
                                                                        $SECTEURSACTIVITES = new SECTEURSACTIVITES();
                                                                        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                                                        $GROUPESSANGUINS = new GROUPESSANGUINS();
                                                                        $QUALITESCIVILES = new QUALITESCIVILES();
                                                                        $RESEAUXDESOINS = new RESEAUXDESOINS();
                                                                        $PROFESSIONS = new PROFESSIONS();
                                                                        $CIVILITES = new CIVILITES();
                                                                        $PRODUITS = new \App\PRODUITS();
                                                                        $SEXES = new SEXES();
                                                                        $categories_socio_professionnelles = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                                                                        $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                                        $situations_familiales = $SITUATIONSFAMILIALES->lister();
                                                                        $secteurs_activites = $SECTEURSACTIVITES->lister();
                                                                        $types_coordonnees = $TYPESCOORDONNEES->lister();
                                                                        $groupes_sanguins = $GROUPESSANGUINS->lister();
                                                                        $qualites_civiles = $QUALITESCIVILES->lister();
                                                                        $professions = $PROFESSIONS->lister();
                                                                        $Rhesus = $GROUPESSANGUINS->lister_rhesus();
                                                                        $civilites = $CIVILITES->lister();
                                                                        $produits = $PRODUITS->lister($organisme['code']);
                                                                        $sexes = $SEXES->lister();
                                                                        $assures = $COLLEGES->lister_assures($police['id_police'], $college['code']);
                                                                        $assures_payeurs = $COLLEGES->lister_assures_payeurs($police['id_police'], $college['code']);
                                                                        $nb_assures = count($assures);

                                                                        $college_statut = $COLLEGES->trouver_statut($college['code']);
                                                                        $college_produit = $COLLEGES->trouver_produit($college['code']);
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/colleges/';?>"><i class="bi bi-menu-up"></i> Collèges</a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page"><?= $college['libelle'];?></li>
                                                                                </ol>
                                                                            </nav>
                                                                            <div class="col-sm-12">
                                                                                <div class="row" id="div_affiche_details">
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-body div_cols">
                                                                                                <p class="h5 p_page_titre"><i class="bi bi-circle-fill text-<?= $college_statut? str_replace('ACT', 'success', str_replace('SUS', 'warning', str_replace('RES', 'danger', $college_statut['statut']))): null;?>"></i> N° <strong id="strong_num_college"><?= $college['code'];?></strong></p>
                                                                                                <?php
                                                                                                if(!$college['date_fin']) {
                                                                                                    if($college_statut) {
                                                                                                        ?>
                                                                                                        <p class="align_right">
                                                                                                            <button type="button" class="btn btn-sm btn-warning button_college_statut" data-bs-toggle="modal" data-bs-target="#editionCollegeModal" title="Editer"><i class="bi bi-pen"></i></button>
                                                                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editionProduitCollegeModal" title="Produit"><i class="bi bi-bag-plus-fill"></i></button>
                                                                                                            <?php
                                                                                                            if($college_statut['statut'] === 'ACT') {
                                                                                                                ?>
                                                                                                                <button type="button" class="btn btn-sm btn-secondary button_college_statut" data-bs-toggle="modal" data-bs-target="#editionStatutCollegeModal" id="sus" title="Suspension"><i class="bi bi-app-indicator"></i></button>
                                                                                                                <button type="button" class="btn btn-sm btn-danger button_college_statut" data-bs-toggle="modal" data-bs-target="#editionStatutCollegeModal" id="res" title="Résiliation"><i class="bi bi-clipboard-x"></i></button>
                                                                                                                <?php
                                                                                                            }else {
                                                                                                                ?>
                                                                                                                <button type="button" class="btn btn-sm btn-success button_college_statut" data-bs-toggle="modal" data-bs-target="#editionStatutCollegeModal" id="act" title="Activer"><i class="bi bi-check"></i></button>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </p>
                                                                                                        <?php
                                                                                                    } else {
                                                                                                        ?>
                                                                                                        <p class="d-grid gap-2">
                                                                                                            <button type="button" class="btn btn-sm btn-success button_college_statut" data-bs-toggle="modal" data-bs-target="#editionStatutCollegeModal" id="act" title="Activer"><i class="bi bi-check"></i> Activer le college</button>
                                                                                                        </p>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                    <div class="modal fade" id="editionStatutCollegeModal" tabindex="-1" aria-labelledby="editionStatutCollegeModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                                                            <div class="modal-content bg-white text-dark">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="editionStatutCollegeModalLabel">Statut du college n° <?= $college['code'];?></h5>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    <?php include "../../_Forms/form_college_statut.php"; ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal fade" id="editionCollegeModal" tabindex="-1" aria-labelledby="editionCollegeModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                            <div class="modal-content bg-white text-dark">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="editionCollegeModalLabel">Edition du college n° <?= $college['code'];?></h5>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    <?php include "../../_Forms/form_organisme_college.php"; ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal fade" id="editionProduitCollegeModal" tabindex="-1" aria-labelledby="editionProduitCollegeModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                                            <div class="modal-content bg-white text-dark">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="editionProduitCollegeModalLabel">Edition du produit</h5>
                                                                                                                </div>
                                                                                                                <div class="modal-body"><?php include "../../_Forms/form_college_produit.php";?></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                                <div class="table-responsive">
                                                                                                    <table class="table table-sm">
                                                                                                        <tr>
                                                                                                            <td>ID police</td>
                                                                                                            <td class="align_right"><strong id="strong_id_police"><?= $police['id_police'];?></strong></td>
                                                                                                        </tr>
                                                                                                        <tr style="width: 150px">
                                                                                                            <td>Police / Sociétaire</td>
                                                                                                            <td class="align_right"><a target="_blank" href="<?= URL.'organisme/polices/?id='.strtolower($police['id_police']);?>"><strong><?= $police['nom'];?></strong></a></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>Libellé college</td>
                                                                                                            <td class="align_right"><strong><?= $college['libelle'];?></strong></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="align_center" colspan="2">Description</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2"><strong><?= $college['description'];?></strong></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-body div_cols">
                                                                                                <div class="modal fade" id="listerAssuresModal" tabindex="-1" aria-labelledby="listerAssuresModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="listerAssuresModalLabel">Liste des assurés</h5>
                                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <div class="row">
                                                                                                                    <div class="col">
                                                                                                                        <?php
                                                                                                                        if($nb_assures != 0) {
                                                                                                                            ?>
                                                                                                                            <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                                                                <thead class="bg-indigo text-white">
                                                                                                                                <tr>
                                                                                                                                    <th style="width: 5px">#</th>
                                                                                                                                    <th style="width: 50px">N° PAYEUR</th>
                                                                                                                                    <th style="width: 100px">N° ASSURE</th>
                                                                                                                                    <th style="width: 100px">N° RGB</th>
                                                                                                                                    <th style="width: 50px">CIVILITE</th>
                                                                                                                                    <th>NOM & PRENOM(S)</th>
                                                                                                                                    <th style="width: 120px">DATE DE NAISSANCE</th>
                                                                                                                                    <th style="width: 5px"></th>
                                                                                                                                </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                                                                                                <?php
                                                                                                                                $ligne = 1;
                                                                                                                                foreach ($assures as $assure) {
                                                                                                                                    ?>
                                                                                                                                    <tr style="<?= ($assure['contractant_num_population'] === $assure['num_population'])? 'font-weight: bold': null;?>">
                                                                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                                                                        <td class="align_right"><?= $assure['contractant_num_population'];?></td>
                                                                                                                                        <td class="align_right"><?= $assure['num_population'];?></td>
                                                                                                                                        <td class="align_right"><?= $assure['num_rgb'];?></td>
                                                                                                                                        <td><?= $assure['code_civilite'];?></td>
                                                                                                                                        <td><?= $assure['nom'].' '.$assure['prenoms'];?></td>
                                                                                                                                        <td class="align_center"><?= date('d/m/Y', strtotime($assure['date_naissance']));?></td>
                                                                                                                                        <td class="bg-info"><a target="_blank" href="<?= URL.'organisme/assures/?num='.$assure['num_population'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                    $ligne++;
                                                                                                                                }
                                                                                                                                ?>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                            <?php
                                                                                                                        }else {
                                                                                                                            echo '<p>Aucun assuré n\'a encore été enregistré pour ce college. Cliquez sur <button class="btn bnt-sm button_ajout"><strong><i class="bi bi-plus-square"></i></strong></button> pour en ajouter un. </p>';
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal fade" id="ajouterAssureModal" tabindex="-1" aria-labelledby="ajouterAssureModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="ajouterAssureModalLabel">Nouvel assuré</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <?php include "../../_Forms/form_assure_college.php";?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <p class="h5 p_page_titre">Assurés</p>

                                                                                                <p class="align_right">
                                                                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#listerAssuresModal" title="Lister les assurés"><i class="bi bi-list-task"></i></button>

                                                                                                    <?php
                                                                                                    if(!$college['date_fin'] || ($college['date_fin'] && strtotime($college['date_fin']) >= strtotime(date('Y-m-d', time())))) {
                                                                                                        if($college_statut && $college_statut['statut'] === 'ACT') {
                                                                                                            ?>
                                                                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterAssureModal" title="Ajouter"><i class="bi bi-person-plus"></i></button>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </p>
                                                                                                <div class="col div_charts_numbers">
                                                                                                    <p>
                                                                                                        <strong><sub><i class="bi bi-people-fill"></i></sub> <?= number_format($nb_assures, '0', ',',' ');?></strong><br />
                                                                                                        <small>Nombre total d'assurés</small>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-body div_cols">
                                                                                                <p class="h5 p_page_titre">Consommations</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }else {
                                                                        echo '<script>window.location.href="'.URL.'organisme/colleges/"</script>';
                                                                    }
                                                                }else {
                                                                    echo '<script>window.location.href="'.URL.'organisme/colleges/"</script>';
                                                                }
                                                            }else {
                                                                echo '<script>window.location.href="'.URL.'organisme/colleges/"</script>';
                                                            }
                                                        }
                                                        else {
                                                            $annees = $COLLEGES->lister_annees($organisme['code']);
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-menu-up"></i> Collèges</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square"></i></button></p>
                                                                <p class="p_page_titre h4"><i class="bi bi-menu-up"></i> Collèges</p>
                                                                <div class="col-sm-12"><?php include "../../_Forms/form_search_colleges.php"; ?></div>
                                                                <div class="modal fade" id="editionModal" tabindex="-1"
                                                                     aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content bg-white text-dark">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Nouveau collège</h5></div>
                                                                            <div class="modal-body">
                                                                                <?php include "../../_Forms/form_organisme_college.php"; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_colleges.js"></script>';
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