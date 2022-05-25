<?php
use App\GLOBALS;
use App\ORGANISMES;
use App\UTILISATEURS;
use App\ETABLISSEMENTS;
require_once "../../../vendor/autoload.php";
require_once "../../Functions/Functions.php";

$GLOBALS = new GLOBALS();
$Headers = $GLOBALS->headers(0);
$Links = $GLOBALS->links();
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $autorisation = verifier_utilisateur_acces('../../../', $parametres['url'], $_SESSION['nouvelle_session']);
        if($autorisation['success']) {
            $UTILISATEURS = new UTILISATEURS();
            $profil = $UTILISATEURS->trouver_profil($autorisation['id_user']);
            if ($profil) {
                if ($profil['code_profil'] === 'ADMN') {
                    if (isset($parametres['url'])) {
                        include "../Menu.php";
                        ?>
                        <div class="container-fluid" id="div_main_page">
                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                <ol class="breadcrumb"><li class="breadcrumb-item active"><i class="bi bi-house-door-fill"></i> Accueil</li></ol>
                            </nav>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'etablissements/'; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-building display-4"></i><br/> Etablissements</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'organismes/'; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-award display-4"></i><br/> Organismes</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'factures/'; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-spreadsheet display-4"></i><br/> Factures</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'comptabilite/'; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-wallet display-4"></i><br/> Comptabilité</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'support/'; ?>" class="btn btn-outline-dark btn-sm"><i class="bi bi-question-circle display-4"></i><br/> Support</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'dashboard/'; ?>" class="btn btn-outline-dark btn-sm"><i class="bi bi-graph-up display-4"></i><br/> Dashboard</a></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-grid div_boxes"><a href="<?= $Links['URL'] . 'parametres/'; ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-gear-wide-connected display-4"></i><br/> Paramètres</a></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '<script src="' . $Links['JS'] . 'deconnexion_0.js"></script>';
                    } else {
                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                    }
                }
                elseif ($profil['code_profil'] === 'ETABLI') {
                    require_once "../../Classes/ETABLISSEMENTS.php";
                    $ets = $UTILISATEURS->trouver_utilisateur_ets($autorisation['id_user']);
                    if($ets) {
                        echo '<script>window.location.href="' . $Links['URL'] . 'etablissement/"</script>';
                    }else {
                        //echo '<p class="alert alert-danger align_center">Votre profil '.$profil['code_profil'].' ne correspond à aucun organisme géré par Ouagolo, veuillez SVP contacter votre administrateur.</p>';
                    }
                }
                elseif ($profil['code_profil'] === 'ORGANI') {
                    $ORGANISMES = new ORGANISMES();
                    $organisme = $UTILISATEURS->trouver_utilisateur_organisme($autorisation['id_user']);
                    if($organisme) {
                        echo '<script>window.location.href="' . $Links['URL'] . 'organisme/"</script>';
                    }else {
                        echo '<p class="alert alert-danger align_center">Votre profil '.$profil['code_profil'].' ne correspond à aucun organisme géré par Ouagolo, veuillez SVP contacter votre administrateur.</p>';
                    }
                } else {
                    echo '<p class="alert alert-danger align_center">Votre profil '.$profil['code_profil'].' ne correspond à aucun service de Ouagolo, veuillez SVP contacter votre administrateur.</p>';
                }
            } else {
                echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
            }
        }else {
            if($autorisation['id_user']) {
                if($autorisation['password_reset']) {
                    echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
                }else {
                    session_destroy();
                    echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
            }
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
}
