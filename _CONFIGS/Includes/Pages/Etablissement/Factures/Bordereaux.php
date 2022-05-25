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
                                        require_once "../../../../Classes/TYPESFACTURESMEDICALES.php";
                                        require_once "../../../../Classes/FACTURESMEDICALES.php";
                                        require_once "../../../../Classes/TYPESREGLEMENTS.php";
                                        require_once "../../../../Classes/ETABLISSEMENTS.php";
                                        require_once "../../../../Classes/ORGANISMES.php";
                                        require_once "../../../../Classes/DOSSIERS.php";
                                        $TYPESFACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                                        $FACTURESMEDICALES = new FACTURESMEDICALES();
                                        $TYPESREGLEMENTS = new TYPESREGLEMENTS();
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $ORGANISMES = new ORGANISMES();
                                        $DOSSIERS = new DOSSIERS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_FCTS', $modules, true)) {
                                                        if (in_array('AFF_FCTS_BRDRS', $sous_modules, true)) {
                                                            if (isset($parametres['url'])) {
                                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                                if ($audit['success'] == true) {
                                                                    include "../../../Menu.php";
                                                                    if(isset($_POST['num_bordereau']) && $_POST['num_bordereau']) {
                                                                        $bordereau = $ETABLISSEMENTS->trouver_bordereau($ets['code'], $_POST['num_bordereau']);
                                                                        if ($bordereau) {
                                                                            $editeur = $UTILISATEURS->trouver($bordereau['id_user'], null);
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/factures/';?>"><i class="bi bi-journal-check"></i> Factures</a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/factures/bordereaux';?>"><i class="bi bi-book-fill"></i> Bordereaux</a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page">Bordereau n° <?= $bordereau['num_bordereau'];?></li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <p class="p_page_titre h4"><i class="bi bi-book-fill"></i> Bordereau n° <strong id="strong_num_bordereau"><?= $bordereau['num_bordereau'];?></strong></p>
                                                                                <p class="align_right"><button type="button" id="button_imprimer_bordereau" class="badge bg-secondary"><i class="bi bi-printer"></i> Imprimer</button></p>
                                                                                <div class="row">
                                                                                    <div class="col-sm-5">
                                                                                        <div class="card">
                                                                                            <div class="card-header"><strong>Infos</strong></div>
                                                                                            <div class="card-body">
                                                                                                <table class="table table-sm">
                                                                                                    <tr>
                                                                                                        <td>N° Bordereau</td>
                                                                                                        <td class="align_right"><strong><?= $bordereau['num_bordereau'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Période</td>
                                                                                                        <td class="align_right">du <strong><?= date('d/m/Y', strtotime($bordereau['date_debut']));?></strong> au <strong><?= date('d/m/Y', strtotime($bordereau['date_fin']));?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Organisme</td>
                                                                                                        <td class="align_right"><strong><?= $bordereau['libelle_organisme'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Type factures</td>
                                                                                                        <td class="align_right"><strong><?= $bordereau['libelle_type_facture'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Nombre de factures</td>
                                                                                                        <td class="align_right"><strong><?= number_format($bordereau['nombre_factures'], '0', '', ' ');?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Nombre d'actes</td>
                                                                                                        <td class="align_right"><strong><?= number_format($bordereau['nombre_actes'], '0', '', ' ');?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Montant RGB</td>
                                                                                                        <td class="align_right"><strong><?= number_format($bordereau['montant_rgb'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Montant Organisme</td>
                                                                                                        <td class="align_right"><strong><?= number_format($bordereau['montant_rc'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></strong></td>
                                                                                                    </tr>
                                                                                                </table><hr />
                                                                                                <table class="table table-sm text-secondary">
                                                                                                    <tr>
                                                                                                        <td>Date création</td>
                                                                                                        <td class="align_right"><strong><?= date('d/m/Y H:i', strtotime($bordereau['date_creation']));?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Editeur</td>
                                                                                                        <td class="align_right"><strong><?= $editeur['nom'].' '.$editeur['prenoms'];?></strong></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="card">
                                                                                            <div class="card-header"><strong>Factures</strong></div>
                                                                                            <div class="card-body">
                                                                                                <?php
                                                                                                $factures = $ETABLISSEMENTS->lister_bordereau_factures($bordereau['num_bordereau']);
                                                                                                $nb_factures = count($factures);
                                                                                                if($nb_factures != 0) {
                                                                                                    ?>
                                                                                                    <table class="table table-sm table-bordered table-stripped table-hover">
                                                                                                        <thead class="bg-indigo text-white">
                                                                                                        <tr>
                                                                                                            <th style="width: 5px">#</th>
                                                                                                            <th>NUM FACTURE</th>
                                                                                                            <th>NUM BON</th>
                                                                                                            <th>NB. ACTES</th>
                                                                                                            <th>MT. RGB</th>
                                                                                                            <th>MT. RC</th>
                                                                                                            <th style="width: 5px"></th>
                                                                                                        </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                        <?php
                                                                                                        $ligne = 1;
                                                                                                        foreach ($factures as $facture) {
                                                                                                            ?>
                                                                                                            <tr>
                                                                                                                <td class="align_right"><?= $ligne;?></td>
                                                                                                                <td class="align_right"><?= $facture['num_facture'];?></td>
                                                                                                                <td class="align_right"><?= $facture['num_bon'];?></td>
                                                                                                                <td class="align_right"><?= number_format($facture['nombre_actes'], '0', '', ' ');?></td>
                                                                                                                <td class="align_right"><?= number_format($facture['montant_rgb'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                <td class="align_right"><?= number_format($facture['montant_rc'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                <td></td>
                                                                                                            </tr>
                                                                                                            <?php
                                                                                                            $ligne++;
                                                                                                        }
                                                                                                        ?>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/factures/bordereaux"</script>';
                                                                        }
                                                                    } else {
                                                                        $organismes = $ORGANISMES->lister();
                                                                        $types_factures = $TYPESFACTURESMEDICALES->lister();
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/factures/';?>"><i class="bi bi-journal-check"></i> Factures</a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-book-fill"></i> Bordereaux</li>
                                                                                </ol>
                                                                            </nav>
                                                                            <?php
                                                                            if (in_array('EDT_FCTS_BRDRS', $sous_modules, true)) {
                                                                                ?>
                                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bordereauModal"><i class="bi bi-plus-square"></i></button></p>
                                                                                <div class="modal fade" id="bordereauModal" tabindex="-1" aria-labelledby="bordereauModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="bordereauModalLabel">Nouveau bordereau</h5>
                                                                                            </div>
                                                                                            <div class="modal-body"><?php include "../../_Forms/form_etablissement_factures_bordereau.php";?></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <p class="p_page_titre h4"><i class="bi bi-book-fill"></i> Bordereaux</p>
                                                                            <div class="row  justify-content-md-center">
                                                                                <div class="col-sm-12"><?php include "../../_Forms/form_search_ets_bordereaux.php"; ?></div>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            let date_debut          = $("#date_debut_search_input").val().trim(),
                                                                                date_fin            = $("#date_fin_search_input").val().trim(),
                                                                                code_organisme      = $("#code_organisme_search_input").val().trim(),
                                                                                code_type_facture   = $("#code_type_facture_search_input").val().trim()
                                                                            display_etablissement_search_borderaux(code_organisme, code_type_facture, date_debut, date_fin);
                                                                        </script>
                                                                        <?php
                                                                    }

                                                                    echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                    echo '<script src="'.JS.'page_etablissement_factures_bordereaux.js"></script>';
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
