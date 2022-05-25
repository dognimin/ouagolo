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
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            require_once "../../../../Classes/ETABLISSEMENTS.php";
                                            $ETABLISSEMENTS = new ETABLISSEMENTS();
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_FCTS', $modules, true)) {
                                                        if (in_array('AFF_FCT', $sous_modules, true) && in_array('EDT_FCT', $sous_modules, true)) {
                                                            if (isset($parametres['url'])) {
                                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                                if ($audit['success'] == true) {
                                                                    include "../../../Menu.php";

                                                                    require_once "../../../../Classes/FACTURESMEDICALES.php";
                                                                    require_once "../../../../Classes/TYPESREGLEMENTS.php";
                                                                    require_once "../../../../Classes/DOSSIERS.php";
                                                                    $FACTURESMEDICALES = new FACTURESMEDICALES();
                                                                    $TYPESREGLEMENTS = new TYPESREGLEMENTS();
                                                                    $DOSSIERS = new DOSSIERS();
                                                                    if (isset($_POST['num_patient']) && $_POST['num_patient']) {
                                                                        $patient = $ETABLISSEMENTS->trouver_patient($ets['code'], $_POST['num_patient']);
                                                                        if ($patient) {
                                                                            require_once "../../../../Classes/TYPESFACTURESMEDICALES.php";
                                                                            require_once "../../../../Classes/ORGANISMES.php";
                                                                            $TYPESFACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                                                                            $ORGANISMES = new ORGANISMES();
                                                                            $dossiers_ouverts = $ETABLISSEMENTS->lister_dossiers_ouverts($ets['code'], $patient['num_population']);
                                                                            $types_factures = $TYPESFACTURESMEDICALES->lister();
                                                                            $assurances = $ORGANISMES->lister();
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'etablissement/patients/'; ?>"><i class="bi bi-person-circle"></i> Patients</a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page">
                                                                                            <a href="<?= URL . 'etablissement/patients/?nip='.$patient['num_population']; ?>"><?= $patient['nom'] . ' ' . $patient['prenom'];?></a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page">Nouvelle facture</li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <p class="p_page_titre h4">Nouvelle facture</p>
                                                                                <?php include "../../_Forms/form_etablissement_facture.php";?>
                                                                            </div>
                                                                            <?php
                                                                            echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                            echo '<script src="'.JS.'page_etablissement_factures.js"></script>';
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/patients/"</script>';
                                                                        }
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/patients/"</script>';
                                                                    }
                                                                } else {
                                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                                }
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<script>window.location.href="'.URL.'etablissement/factures/"</script>';
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
