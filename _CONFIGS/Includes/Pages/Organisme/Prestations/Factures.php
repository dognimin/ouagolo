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
                                                        if(isset($_POST['rubrique']) && $_POST['rubrique']){
                                                            if(isset($_POST['num_facture']) && $_POST['num_facture']) {
                                                                require_once "../../../../Classes/FACTURESMEDICALES.php";
                                                                $FACTURESMEDICALES = new FACTURESMEDICALES();
                                                                $facture = $FACTURESMEDICALES->trouver($_POST['num_facture']);
                                                                if($facture) {
                                                                    $facture_organisme = $FACTURESMEDICALES->trouver_organisme_facture($organisme['code'], $facture['num_facture']);
                                                                    if($facture_organisme) {
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/';?>"><i class="bi bi-file-earmark-medical"></i> Prestations</a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/factures';?>"><i class="bi bi-journal-medical"></i> Factures</a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/factures?r='.$_POST['rubrique'];?>"><?= strtoupper($_POST['rubrique']);?></a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page">Facture n° <?= $facture['num_facture'];?></li>
                                                                                </ol>
                                                                            </nav>
                                                                            <p class="p_page_titre h4"><i class="bi bi-journal-medical"></i> Facture n° <?= $facture['num_facture'];?></p>
                                                                            <div class="col">
                                                                                <div class="row">
                                                                                    <div class="col"></div>
                                                                                    <div class="col-sm-7" id="div_facture">
                                                                                        <div class="row" id="div_patient_identification">
                                                                                            <div class="col">
                                                                                                <table class="table table-sm table-bordered">
                                                                                                    <tr>
                                                                                                        <td><strong>IDENTIFICATION</strong></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }else {
                                                                        echo '<script>window.location.href="'.URL.'organisme/prestations/factures?r=liquidation"</script>';
                                                                    }
                                                                }else {
                                                                    echo '<script>window.location.href="'.URL.'organisme/prestations/factures?r=liquidation"</script>';
                                                                }

                                                            }else {
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/';?>"><i class="bi bi-file-earmark-medical"></i> Prestations</a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/factures';?>"><i class="bi bi-journal-medical"></i> Factures</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= strtoupper($_POST['rubrique']);?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="col">
                                                                        <?php
                                                                        if($_POST['rubrique'] === 'reception' || $_POST['rubrique'] === 'liquidation') {
                                                                            include "../../_Forms/form_search_organisme_factures.php";
                                                                        }else {
                                                                            include "../../_Forms/form_search_organisme_bordereaux.php";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            echo '<script src="'.JS.'page_organisme_prestations_factures.js"></script>';
                                                        }else {
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/prestations/';?>"><i class="bi bi-file-earmark-medical"></i> Prestations</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-journal-medical"></i> Factures</li>
                                                                    </ol>
                                                                </nav>
                                                                <div class="row  justify-content-md-center">
                                                                    <div class="col-sm-3">
                                                                        <div class="d-grid div_boxes"><a href="<?= URL . 'organisme/prestations/factures?r=reception'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-signpost"></i><br/> Réception</a></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="d-grid div_boxes"><a href="<?= URL . 'organisme/prestations/factures?r=liquidation'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-cpu-fill"></i><br/> Liquidation</a></div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="d-grid div_boxes"><a href="<?= URL . 'organisme/prestations/factures?r=bordereaux'; ?>" class="btn btn-primary btn-sm"><i class="bi bi-receipt-cutoff"></i><br/> Bordereaux</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
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