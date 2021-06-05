<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/RESEAUXDESOINS.php";
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $RESEAUX = new RESEAUXDESOINS();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if($user_mdp) {
                        if($user_mdp['statut'] == 1) {
                            include "../../../Menu.php";
                            if ($_POST['code']){
                                $reseau= $RESEAUX->trouver($_POST['code']);
                                if ($reseau){
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
                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-diagram-3"></i> <?= $reseau['libelle'] ?></li>
                                            </ol>
                                        </nav>
                                        <p class="p_page_titre h4"><i class="bi bi-diagram-3"></i> Réseau: <?= $reseau['libelle'];?></p>
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
                                                                <?php include "../../_Forms/form_reseau_de_soin.php";?>
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
                                                       <a href="<?= URL.'parametres/reseaux-de-soins/etablissements?code='.$_POST['code'];?>" class="btn btn-sm btn-primary ">Etablissement</a>
                                                   </div>
                                               </div>
                                               <div class="col-sm-2">
                                                   <div class="d-grid div_boxes">
                                                       <a href="<?= URL.'parametres/reseaux-de-soins/actes-medicaux?code='.$_POST['code'];?>" class="btn btn-sm btn-primary ">Actes medicaux</a>
                                                   </div>
                                               </div>
                                               <div class="col-sm-2">
                                                   <div class="d-grid div_boxes">
                                                       <a href="<?= URL.'parametres/reseaux-de-soins/medicaments?code='.$_POST['code'];?>" class="btn btn-sm btn-primary ">Mediacements</a>
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
                                    echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                    echo '<script src="'.JS.'page_parametres_reseaux_de_soins.js"></script>';

                                }else{
                                    echo '<script>window.location.href="'.URL.'parametres/reseaux-de-soins/"</script>';
                                }
                            }else{
                                //echo '<script>window.location.href="'.URL.'parametres/reseaux-de-soins/"</script>';
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