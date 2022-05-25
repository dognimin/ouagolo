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
                                    if ($profil['code_profil'] === 'ETABLI') {
                                        require_once "../../../Classes/ETABLISSEMENTS.php";
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
                                                    if (in_array('AFF_FRNSS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../Menu.php";
                                                                require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                                if (isset($_POST['code'])) {
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><i class="bi bi-building"></i><a href="<?= URL.'etablissement/';?>"><?= acronyme($ets['raison_sociale'], -1); ?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-circle-square"></i> Fournisseurs</li>
                                                                            </ol>
                                                                        </nav>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    $payss = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions(null);
                                                                    $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements(null);
                                                                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes(null);

                                                                    $fournisseurs = $ETABLISSEMENTS->lister_fournisseurs($ets['code']);
                                                                    $nb_fournisseurs = count($fournisseurs);
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><i class="bi bi-building"></i><a href="<?= URL.'etablissement/';?>"><?= acronyme($ets['raison_sociale'], -1); ?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-circle-square"></i> Fournisseurs</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_FRNS', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fournissaurModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                            <div class="modal fade" id="fournissaurModal" tabindex="-1" aria-labelledby="fournissaurModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="fournissaurModalLabel">Nouveau fournisseur</h5>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body"><?php include "../_Forms/form_fournisseur.php";?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <p class="p_page_titre h4"><i class="bi bi-circle-square"></i> Fournisseurs</p>

                                                                        <?php
                                                                        if ($nb_fournisseurs != 0) {
                                                                            ?>
                                                                            <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_fournisseurs">
                                                                                <thead class="bg-indigo text-white">
                                                                                <tr>
                                                                                    <th style="width: 5px">#</th>
                                                                                    <th style="width: 15px">CODE</th>
                                                                                    <th>RAISON SOCIALE</th>
                                                                                    <th style="width: 115px">EMAIL</th>
                                                                                    <th style="width: 100px">N° TELEPHONE</th>
                                                                                    <?php
                                                                                    if (in_array('AFF_FRNS', $sous_modules, true)) {
                                                                                        echo '<th style="width: 5px"></th>';
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $ligne = 1;
                                                                                foreach ($fournisseurs as $fournisseur) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                        <td><?= $fournisseur['code'];?></td>
                                                                                        <td><?= $fournisseur['libelle'];?></td>
                                                                                        <td>
                                                                                            <a href="mailto:<?= $fournisseur['email']; ?>"><?= $fournisseur['email'];?></a></td>
                                                                                        <td><?= $fournisseur['num_telephone_1'];?></td>
                                                                                        <?php
                                                                                        if (in_array('AFF_FRNS', $sous_modules, true)) {
                                                                                            ?><td class="bg-info"><a href="<?= URL.'etablissement/fournisseurs?code='.strtolower($fournisseur['code']);?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td><?php
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $ligne++;
                                                                                }
                                                                                ?>
                                                                                </tbody>
                                                                            </table>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <p class="align_center alert alert-warning">Aucun fournisseur n'a encore été enregistré. <br />Cliquez sur <a href="" class="" data-bs-toggle="modal" data-bs-target="#fournissaurModal"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_fournisseurs.js"></script>';
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
