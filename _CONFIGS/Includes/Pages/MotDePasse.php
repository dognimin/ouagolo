<?php
require_once "../../Classes/UTILISATEURS.php";
require_once "../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null, null);
            if ($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if ($user_statut) {
                    if ((int)$user_statut['statut'] === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)$user_mdp['statut'] === 0) {
                                if (isset($parametres['url'])) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                    if ($audit['success'] == true) {
                                        ?>
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="row justify-content-md-center">
                                                    <div class="col-md-4 col-md-auto" id="div_mot_de_passe">
                                                        <p class="align_center"><img class="img_half_page" src="<?= IMAGES . 'logos/logo-ouagolo.png'; ?>" alt="Logo Ouagolo"></p>
                                                        <?php include "_Forms/form_mot_de_passe.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script src="<?= JS . 'page_connexion.js'; ?>"></script>
                                        <?php
                                    } else {
                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                    }
                                } else {
                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                }
                            } else {
                                echo '<script>window.location.href="' . URL . '"</script>';
                            }
                        } else {
                            session_destroy();
                            echo '<script>window.location.href="' . URL . 'connexion"</script>';
                        }
                    } else {
                        session_destroy();
                        echo '<script>window.location.href="' . URL . 'connexion"</script>';
                    }
                } else {
                    session_destroy();
                    echo '<script>window.location.href="' . URL . 'connexion"</script>';
                }
            } else {
                $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                if ($fermer_session['success'] == true) {
                    session_destroy();
                    echo '<script>window.location.href="' . URL . 'connexion"</script>';
                } else {
                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                }
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . URL . 'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="' . URL . 'connexion"</script>';
}