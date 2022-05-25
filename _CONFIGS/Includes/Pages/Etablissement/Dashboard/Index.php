<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
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
                    if ((int)$user_statut['statut'] === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)$user_mdp['statut'] === 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] === 'ETABLI') {
                                        require_once "../../../../Classes/ETABLISSEMENTS.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_DSHBS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../../Menu.php";
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-graph-up"></i> Dashboard</li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row justify-content-md-center bg-indigo" style="display: none">
                                                                        <div class="col-sm-5"><?php include "../../_Forms/form_search_ets_datas.php"; ?></div>
                                                                    </div><br />
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width: 80%;">
                                                                                                <strong class="h1" id="strong_nombre_factures">0</strong><br />
                                                                                                <small class="h6">Factures</small>
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="d-grid gap-2">
                                                                                                    <button class="btn btn-dark" type="button" disabled><i class="bi bi-journal-check h1"></i></button>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width: 80%;">
                                                                                                <strong class="h1" id="strong_nombre_patients">0</strong><br />
                                                                                                <small class="h6">Patients</small>
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="d-grid gap-2">
                                                                                                    <button class="btn btn-primary" type="button" disabled><i class="bi bi-person-circle h1"></i></button>
                                                                                                </div>

                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width: 80%;">
                                                                                                <strong class="h1" id="strong_nombre_dossiers">0</strong><br />
                                                                                                <small class="h6">Dossiers</small>
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="d-grid gap-2">
                                                                                                    <button class="btn btn-warning" type="button" disabled><i class="bi bi-folder2-open h1"></i></button>
                                                                                                </div>

                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width: 80%;">
                                                                                                <strong class="h1" id="strong_nombre_medecins">0</strong><br />
                                                                                                <small class="h6">Medecins</small>
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="d-grid gap-2">
                                                                                                    <button class="btn btn-success" type="button" disabled><i class="bi bi-person-rolodex h1"></i></button>
                                                                                                </div>

                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width: 80%;">
                                                                                                <strong class="h1" id="strong_nombre_utilisateurs">0</strong><br />
                                                                                                <small class="h6">Utilisateurs</small>
                                                                                            </td>
                                                                                            <td>
                                                                                                <div class="d-grid gap-2">
                                                                                                    <button class="btn btn-danger" type="button" disabled><i class="bi bi-people h1"></i></button>
                                                                                                </div>

                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><br />
                                                                    <div class="row">
                                                                        <div class="col-sm">
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <canvas id="canvas_nombre_patients_par_jour" style="max-height: 380px"></canvas>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><br />
                                                                            <div class="row">
                                                                                <div class="col-sm-8">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <canvas id="canvas_nombre_patients_par_organisme"></canvas>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <canvas id="canvas_nombre_patients_par_sexe"></canvas>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><br />
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <div class="card">
                                                                                        <div class="card-body">30</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm">
                                                                                    <div class="card">
                                                                                        <div class="card-body">31</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <canvas id="canvas_nombre_factures_par_type"></canvas>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><br />
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    <div class="card">
                                                                                        <div class="card-body"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><br />
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    <div class="card">
                                                                                        <div class="card-body"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_dashboard.js"></script>';
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                        }
                                                    } else {
                                                        echo '<script>window.location.href="'.URL.'etablissement/"</script>';
                                                    }
                                                } else {
                                                    echo '<script>window.location.href="'.URL.'etablissement/"</script>';
                                                }
                                            } else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                } else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            } else {
                                echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                            }
                        } else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                    } else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                } else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            } else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}
?>
<script>
    let date_debut = $("#date_debut_search_input").val().trim(),
        date_fin = $("#date_fin_search_input").val().trim();
    if(date_debut && date_fin) {
        etablissement_nombre_patients(date_debut, date_fin);
        etablissement_nombre_medecins(date_debut, date_fin);
        etablissement_nombre_utilisateurs(date_debut, date_fin);
        etablissement_nombre_factures(date_debut, date_fin);
        etablissement_nombre_dossiers(date_debut, date_fin);
        etablissement_nombre_factures_par_type(date_debut, date_fin);
        etablissement_nombre_patients_par_sexe(date_debut, date_fin);
        etablissement_nombre_patients_par_organisme(date_debut, date_fin);
        etablissement_nombre_patients_par_jour(date_debut, date_fin);
    }
</script>
