<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/RESEAUXDESOINS.php";
require_once "../../../../Classes/MEDICAMENTS.php";

if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $RESEAUX = new RESEAUXDESOINS();
        $MEDICAMENTS = new MEDICAMENTS();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if($user_mdp) {
                        if($user_mdp['statut'] == 1) {
                            include "../../../Menu.php";
                            $reseau_medicamnets= $RESEAUX->lister_reseau_medicaments($_POST['code']);
                            $medicaments= $MEDICAMENTS->lister_medicaments();
                            $reseaux_de_soins= $RESEAUX->trouver($_POST['code']);
                            $nb_reseaux_de_soins= count($reseau_medicamnets)
                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/reseaux-de-soins/';?>"><i class="bi bi-diagram-3"></i> Réseaux de soins</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"> Médicament</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-diagram-3"></i> <?= $reseaux_de_soins['libelle'] ?></p>
                               <h4>Medicaments</h4>
                                <p class="align_right">
                                    <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
                                </p>
                                <div class="row  justify-content-md-center">
                                    <div id="div_form">
                                        <div class="row justify-content-md-center">

                                            <div class="col-md-10">
                                                <div class="card">
                                                    <div class="card-body row">
                                                        <h5 class="card-title"></h5>
                                                        <div class="row justify-content-md-center">
                                                            <?php include "../../_Forms/form_reseau_de_soin_medicament.php";?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="div_datas">
                                        <?php
                                        if($nb_reseaux_de_soins == 0) {
                                            ?>
                                            <p class="align_center alert alert-warning">Aucun medicament  n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
                                            <?php
                                        }else {
                                            include "../../_Forms/form_export.php";
                                            ?>
                                            <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
                                                <thead class="bg-info">
                                                <tr>
                                                    <th width="5">N°</th>
                                                    <th width="10">CODE RESEAU</th>
                                                    <th>CODE MEDICAMENT</th>
                                                    <th width="100">DATE EFFET</th>
                                                    <th width="5"></th>
                                                    <th width="5"></th>
                                                    <th width="5"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $ligne = 1;
                                                foreach ($reseau_medicamnets as $reseau_medicamnet) {
                                                    $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($reseau_medicamnet['date_debut'])));
                                                    $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                                                    if(strtotime($date_fin) > strtotime($date_edition)) {
                                                        $validite_edition = 1;
                                                    }else {
                                                        $validite_edition = 0;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="align_right"><?= $ligne;?></td>
                                                        <td><?= $reseau_medicamnet['code_reseau'];?></td>
                                                        <td><?= $reseau_medicamnet['code_medicament'];?></td>
                                                        <td><?= $reseau_medicamnet['tarif'];?></td>
                                                        <td class="align_center"><?= date('d/m/Y',strtotime($reseau_medicamnet['date_debut']));?></td>
                                                        <td>
                                                            <button type="button" id="<?= $reseau_medicamnet['code_reseau'].'|'.$reseau_medicamnet['code_medicament'].'|'.$reseau_medicamnet['tarif'];?>" class="badge bg-<?php if($validite_edition == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit" <?php if($validite_edition == 0) {echo 'disabled';} ?>><i class="bi bi-brush"></i></button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="badge bg-dark button_historique" data-bs-toggle="modal" id="<?= $reseau_medicamnet['code_reseau'].'|'. $reseau_medicamnet['code_medicament'];?>|res_med" data-bs-target="#historiqueModal"><i class="bi bi-clock-history"></i></button>
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
                            <?php
                            echo '<script src="'.JS.'deconnexion_2.js"></script>';
                            echo '<script src="'.JS.'page_parametres_reseaux_de_soins_medicaments.js"></script>';

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