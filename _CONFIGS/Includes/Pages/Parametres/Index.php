<?php
use App\GLOBALS;
use App\UTILISATEURS;
require_once "../../../../vendor/autoload.php";
require_once "../../../Functions/Functions.php";

$GLOBALS = new GLOBALS();
$Headers = $GLOBALS->headers(0);
$Links = $GLOBALS->links();
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {

        $autorisation = verifier_utilisateur_acces('../../../../', $parametres['url'], $_SESSION['nouvelle_session']);
        if($autorisation['success']){
            $UTILISATEURS = new UTILISATEURS();
            $profil = $UTILISATEURS->trouver_profil($autorisation['id_user']);
            if ($profil) {
                if ($profil['code_profil'] == 'ADMN') {
                    if (isset($parametres['url'])) {
                        $audit = $UTILISATEURS->editer_piste_audit($autorisation['code_session'], $parametres['url'], 'AFFICHAGE', null);
                        if ($audit['success'] == true) {
                            include "../../Menu.php";
                            ?>
                            <div class="container-fluid" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= $Links['URL']; ?>"><i
                                                        class="bi bi-house-door-fill"></i>
                                                Accueil</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i
                                                    class="bi bi-gear-wide-connected"></i>
                                            Paramètres
                                        </li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-gear-wide-connected"></i>
                                    Paramètres
                                </p>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/reseaux-de-soins/'; ?>"
                                               class="btn btn-outline-danger btn-sm"><i
                                                        class="bi bi-diagram-3 display-4"></i><br/> Réseaux de
                                                soins</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/utilisateurs/'; ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-person-bounding-box display-4"></i><br/>Utilisateurs</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/support/'; ?>"
                                               class="btn btn-outline-danger btn-sm"><i
                                                        class="bi bi-question-circle display-4"></i><br/>
                                                Support</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/referentiels/'; ?>"
                                               class="btn btn-outline-danger btn-sm"><i
                                                        class="bi bi-clipboard-plus display-4"></i><br/>
                                                Référentiels</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/tables-de-valeurs'; ?>"
                                               class="btn btn-outline-danger btn-sm"><i
                                                        class="bi bi-award display-4"></i><br/>
                                                Tables de valeurs</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-grid div_boxes">
                                            <a href="<?= $Links['URL'] . 'parametres/securite/'; ?>"
                                               class="btn btn-outline-danger btn-sm"><i
                                                        class="bi bi-shield-check display-4"></i><br/>
                                                Sécurité</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php
                            echo '<script src="' . $Links['JS'] . 'deconnexion_1.js"></script>';
                        } else {
                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                        }
                    } else {
                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                    }
                } else {
                    echo '<script>window.location.href="' . $Links['URL'] . '"</script>';
                }
            } else {
                echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
            }
        }else{
            if($autorisation['id_user']) {
                if($autorisation['password_reset']) {
                    echo '<script>window.location.href="' . $Links['URL'] . 'mot-de-passe"</script>';
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