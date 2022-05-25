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
                                                require_once "../../../../Classes/RESEAUXDESOINS.php";
                                                $RESEAUXDESOINS = new RESEAUXDESOINS();
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
                                                        include "../../../Menu.php";
                                                        if(isset($_POST['code'])) {
                                                            $reseau = $RESEAUXDESOINS->trouver($organisme['code'], strtoupper($_POST['code']));
                                                            if($reseau) {
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/parametres/reseaux-de-soins';?>"><i class="bi bi-diagram-3"></i> Réseaux de soins</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $reseau['libelle'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <?php
                                                                                    $etablissements = $RESEAUXDESOINS->lister_reseau_etablissements($reseau['code']);
                                                                                    $nb_etablissements = count($etablissements);
                                                                                    ?>
                                                                                    <p class="align_right">
                                                                                        <button type="button" class="btn btn-primary btn-sm btn_add" title="Ajouter un centre de santé"><i class="bi bi-plus-square-fill"></i></button>
                                                                                    </p>
                                                                                    <div class="row  justify-content-md-center">
                                                                                        <div id="div_form">
                                                                                            <div class="row justify-content-md-center">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="card">
                                                                                                        <div class="card-body row">
                                                                                                            <h5 class="card-title"></h5>
                                                                                                            <div class="row justify-content-md-center">
                                                                                                                <?php include "../../_Forms/form_reseau_de_soins_etablissemnt.php";?>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div id="div_datas">
                                                                                            <?php
                                                                                            if($nb_etablissements == 0) {
                                                                                                ?>
                                                                                                <p class="align_center alert alert-warning">Aucun établissement de santé n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour en ajouter un</p>
                                                                                                <?php
                                                                                            }else {
                                                                                                include "../../_Forms/form_export.php";
                                                                                                ?>
                                                                                                <table class="table table-bordered table-hover table-sm table-striped" id="table_reseaux_de_soins_etablissements">
                                                                                                    <thead class="bg-indigo text-white">
                                                                                                    <tr>
                                                                                                        <th style="width: 5px">N°</th>
                                                                                                        <th style="width: 70px">CODE</th>
                                                                                                        <th>RAISON SOCIALE</th>
                                                                                                        <th style="width: 100px">DATE EFFET</th>
                                                                                                        <th style="width: 5px"></th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                    <?php
                                                                                                    $ligne = 1;
                                                                                                    foreach ($etablissements as $etablissement) {
                                                                                                        $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($etablissement['date_debut'])));
                                                                                                        $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                                                                                                        if(strtotime($date_fin) > strtotime($date_edition)) {
                                                                                                            $validite_edition = 1;
                                                                                                        }else {
                                                                                                            $validite_edition = 0;
                                                                                                        }
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td class="align_right"><?= $ligne;?></td>
                                                                                                            <td><?= $etablissement['code_etablissement'];?></td>
                                                                                                            <td><?= $etablissement['raison_sociale'];?></td>
                                                                                                            <td class="align_center"><?= date('d/m/Y',strtotime($etablissement['date_debut']));?></td>
                                                                                                            <td>
                                                                                                                <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $etablissement['code_reseau'].'|'. $etablissement['code_etablissement'];?>|res_etab" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <?php
                                                                                                        $ligne++;
                                                                                                    }
                                                                                                    ?>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <div class="modal fade" id="historiqueModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="historiqueModalLabel"><i class="bi bi-clock-history"></i> Historique des modifications</h5>
                                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                            </div>
                                                                                                            <div class="modal-body" id="div_historique"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        else {
                                                            $reseaux = $RESEAUXDESOINS->lister($organisme['code']);
                                                            $nb_reseaux = count($reseaux);
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-diagram-3"></i> Réseaux de soins</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="p_page_titre h4"><i class="bi bi-diagram-3"></i> Réseaux de soins</p>
                                                                <p class="align_right">
                                                                    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
                                                                </p>
                                                                <div class="row justify-content-md-center">
                                                                    <div id="div_form">
                                                                        <div class="row justify-content-md-center">
                                                                            <div class="col-md-10">
                                                                                <div class="card">
                                                                                    <div class="card-body row">
                                                                                        <h5 class="card-title"></h5>
                                                                                        <div class="row justify-content-md-center">
                                                                                            <?php include "../../_Forms/form_reseau_de_soins.php";?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div id="div_datas">
                                                                        <?php
                                                                        if($nb_reseaux == 0) {
                                                                            ?>
                                                                            <p class="align_center alert alert-warning">Aucun réseau de soins n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
                                                                            <?php
                                                                        }else {
                                                                            ?>
                                                                            <table class="table table-bordered table-hover table-sm table-striped" id="table_reseaux_de_soins">
                                                                                <thead class="bg-indigo text-white">
                                                                                <tr>
                                                                                    <th style="width: 5px">N°</th>
                                                                                    <th style="width: 10px">CODE</th>
                                                                                    <th>LIBELLE</th>
                                                                                    <th style="width: 100px">DATE EFFET</th>
                                                                                    <th style="width: 5px"></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $ligne = 1;
                                                                                foreach ($reseaux as $reseau) {
                                                                                    $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($reseau['date_debut'])));
                                                                                    $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                                                                                    if(strtotime($date_fin) > strtotime($date_edition)) {
                                                                                        $validite_edition = 1;
                                                                                    }else {
                                                                                        $validite_edition = 0;
                                                                                    }
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                        <td><?= $reseau['code'];?></td>
                                                                                        <td><?= $reseau['libelle'];?></td>
                                                                                        <td class="align_center"><?= date('d/m/Y',strtotime($reseau['date_debut']));?></td>
                                                                                        <td class="bg-info"><a href="<?= URL.'organisme/parametres/reseaux-de-soins?code='.strtolower($reseau['code']);?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $ligne++;
                                                                                }
                                                                                ?>
                                                                                </tbody>
                                                                            </table>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_parametres_reseaux_de_soins.js"></script>';
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