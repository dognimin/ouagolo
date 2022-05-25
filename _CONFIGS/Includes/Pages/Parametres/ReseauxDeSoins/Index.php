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
                                    if($profil['code_profil'] == 'ADMN') {
                                        if (isset($parametres['url'])) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                            if ($audit['success'] == true) {
                                                require_once "../../../../Classes/RESEAUXDESOINS.php";
                                                $RESEAUXDESOINS = new RESEAUXDESOINS();
                                                include "../../../Menu.php";
                                                if(isset($_POST['code'])) {
                                                    $reseau = $RESEAUXDESOINS->trouver(null, strtoupper($_POST['code']));
                                                    if ($reseau) {
                                                        $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($reseau['date_debut'])));
                                                        $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                                                        if(strtotime($date_fin) > strtotime($date_edition)) {
                                                            $validite_edition = 1;
                                                        }else {
                                                            $validite_edition = 0;
                                                        }
                                                        ?>
                                                        <div class="container-xl" id="div_main_page">
                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                <ol class="breadcrumb">
                                                                    <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL.'parametres/reseaux-de-soins/';?>"><i class="bi bi-diagram-3"></i> Réseaux de soins</a></li>
                                                                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-diagram-3"></i> <?= ucfirst(strtolower($reseau['libelle']));?></li>
                                                                </ol>
                                                            </nav>
                                                            <p class="p_page_titre h4"><i class="bi bi-diagram-3"></i> Réseau: <?= ucfirst(strtolower($reseau['libelle']));?></p>
                                                            <p class="align_right">
                                                                <button type="button" id="<?= $reseau['code'].'|'.$reseau['libelle']; ?>" class="btn btn-sm  btn-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit"><i class="bi bi-brush"></i></button>
                                                                <button type="button" class="btn btn-sm btn-dark button_historique" data-bs-toggle="modal" id="<?= $reseau['code'];?>|res" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
                                                            </p>
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
                                                                <div class="row  justify-content-md-center">

                                                                    <div class="col-sm-2">
                                                                        <div class="d-grid div_boxes">
                                                                            <a href="<?= URL.'parametres/reseaux-de-soins/etablissements?code='.strtolower($reseau['code']);?>" class="btn btn-sm btn-danger"><i class="bi bi-building"></i><br /> Etablissements</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="d-grid div_boxes">
                                                                            <a href="<?= URL.'parametres/reseaux-de-soins/actes-medicaux?code='.strtolower($reseau['code']);?>" class="btn btn-sm btn-danger"><i class="bi bi-ui-radios-grid"></i><br /> Actes médicaux</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="d-grid div_boxes">
                                                                            <a href="<?= URL.'parametres/reseaux-de-soins/medicaments?code='.strtolower($reseau['code']);?>" class="btn btn-sm btn-danger"><i class="bi bi-toggles"></i><br /> Médicaments</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2" hidden>
                                                                        <div class="d-grid div_boxes">
                                                                            <a href="<?= URL.'parametres/reseaux-de-soins/pathologies?code='.$_POST['code'];?>" class="btn btn-sm btn-danger"><i class="bi bi-file-medical-fill"></i><br /> Pathologies</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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


                                                        </div>
                                                        <?php
                                                    }else {
                                                        echo '<script>window.location.href="'.URL.'parametres/reseaux-de-soins/"</script>';
                                                    }
                                                }
                                                else {
                                                    $reseaux = $RESEAUXDESOINS->lister(null);
                                                    $nb_reseaux = count($reseaux)
                                                    ?>
                                                    <div class="container-xl" id="div_main_page">
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
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
                                                                    include "../../_Forms/form_export.php";
                                                                    ?>
                                                                    <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
                                                                        <thead class="bg-secondary">
                                                                        <tr>
                                                                            <th style="width: 5px">N°</th>
                                                                            <th style="width: 10px">CODE</th>
                                                                            <th>LIBELLE</th>
                                                                            <th>ORGANISME</th>
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
                                                                                <td><?= $reseau['libelle_organisme'];?></td>
                                                                                <td class="align_center"><?= date('d/m/Y',strtotime($reseau['date_debut']));?></td>
                                                                                <td>
                                                                                    <a href="<?= URL.'parametres/reseaux-de-soins/?code='.strtolower($reseau['code']);?>" class="badge bg-info"><i class="bi bi-eye"></i></a>
                                                                                </td>
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
                                                echo '<script src="'.JS.'page_parametres_reseaux_de_soins.js"></script>';
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
        }
        else {
            session_destroy();
            echo '<script>window.location.href="'.URL.'connexion"</script>';
        }
    }
    else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}
else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}