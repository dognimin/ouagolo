<?php
require_once "../../../Classes/UTILISATEURS.php";
require_once "../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if ($user_statut) {
                    if ($user_statut['statut'] == 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ($user_mdp['statut'] == 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] == 'ADMN') {
                                        if (isset($parametres['url'])) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                            if ($audit['success'] == true) {
                                                include "../../Menu.php";
                                                require_once "../../../Classes/TABLESDEVALEURS.php";
                                                $TABLESDEVALEURS = new TABLESDEVALEURS();
                                                $tables = $TABLESDEVALEURS->lister();
                                                ?>
                                                <div class="container-xl" id="div_main_page">
                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="<?= URL; ?>"><i
                                                                            class="bi bi-house-door-fill"></i>
                                                                    Accueil</a>
                                                            </li>
                                                            <li class="breadcrumb-item"><a
                                                                        href="<?= URL . 'parametres/'; ?>"><i
                                                                            class="bi bi-gear-wide-connected"></i>
                                                                    Paramètres</a>
                                                            </li>
                                                            <li class="breadcrumb-item active" aria-current="page"><i
                                                                        class="bi bi-award"></i> Tables de valeurs
                                                            </li>
                                                        </ol>
                                                    </nav>
                                                    <p class="p_page_titre h4">Tables de valeurs</p>
                                                    <div class="row">
                                                        <div class="col-sm-3" id="div_sidebar">
                                                            <?php include "../_Forms/form_tables_de_valeurs.php"; ?>
                                                        </div>
                                                        <div class="col-sm" id="div_tables_de_valeurs">
                                                            <div class="container">
                                                                <div class="row g-3">
                                                                    <?php
                                                                    foreach ($tables as $table) {
                                                                        ?>
                                                                        <div class="col-4">
                                                                            <div class="d-grid gap-2">
                                                                                <button class="btn btn-primary btn-sm button_table_de_valeur"
                                                                                        id="<?= $table['code']; ?>"
                                                                                        type="button"><?= $table['libelle']; ?></button>
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
                                                <?php
                                                echo '<script src="' . JS . 'page_parametres_tables_de_valeurs.js"></script>';
                                                echo '<script src="' . JS . 'deconnexion_1.js"></script>';
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
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            } else {

                                echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
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
    session_destroy();
    echo '<script>window.location.href="' . URL . 'connexion"</script>';
}