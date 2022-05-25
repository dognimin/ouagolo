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
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";
                                                                if (isset($_POST['num_facture']) && $_POST['num_facture']) {
                                                                    if (in_array('AFF_FCT', $sous_modules, true)) {
                                                                        $facture = $ETABLISSEMENTS->trouver_facture($ets['code'], $_POST['num_facture']);
                                                                        if ($facture) {
                                                                            require_once "../../../../Classes/FACTURESMEDICALES.php";
                                                                            require_once "../../../../Classes/TYPESREGLEMENTS.php";
                                                                            require_once "../../../../Classes/PATIENTS.php";
                                                                            require_once "../../../../Classes/DOSSIERS.php";
                                                                            $FACTURESMEDICALES = new FACTURESMEDICALES();
                                                                            $TYPESREGLEMENTS = new TYPESREGLEMENTS();
                                                                            $PATIENTS = new PATIENTS();
                                                                            $DOSSIERS = new DOSSIERS();

                                                                            $dossier = $DOSSIERS->trouver($facture['code_dossier']);
                                                                            if ($dossier) {
                                                                                $actes = $FACTURESMEDICALES->lister_actes($facture['num_facture']);
                                                                                $nb_actes = count($actes);
                                                                                if ($nb_actes != 0) {
                                                                                    $types_reglements = $TYPESREGLEMENTS->lister();
                                                                                    $organisme = $PATIENTS->trouver_organisme($facture['code_organisme'], $facture['num_population'], $facture['date_soins']);

                                                                                    ?>
                                                                                    <div class="container-xl" id="div_main_page">
                                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                            <ol class="breadcrumb">
                                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/factures/';?>"><i class="bi bi-journal-check"></i> Factures</a></li>
                                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-journal-check"></i> Facture n° <?= $facture['num_facture'];?></li>
                                                                                            </ol>
                                                                                        </nav>
                                                                                        <div class="row">
                                                                                            <div class="col">
                                                                                                <table class="table table-bordered table-sm">
                                                                                                    <tr>
                                                                                                        <td colspan="7" class="align_center h5"><strong>FACTURE N° <b id="num_facture_b"><?= $facture['num_facture'];?></b></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="width: 175px">Etab. payeur / Sociétaire</td>
                                                                                                        <td colspan="5" class="h6 bg-secondary"><strong><?= $organisme? $organisme['raison_sociale']: 'N/A';?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Nom & prénom(s) patient(e)</td>
                                                                                                        <td colspan="5" class="h6 bg-secondary"><strong><?= $dossier['code_civilite'].'. '.$dossier['nom'].' '.$dossier['prenom'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>N° BON</td>
                                                                                                        <td style="width: 150px" class="h6"><strong><?= $facture['num_bon'];?></strong></td>
                                                                                                        <td style="width: 150px">Service</td>
                                                                                                        <td colspan="3" class="h6"><strong></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>N.I.P</td>
                                                                                                        <td class="h6"><strong><?= $facture['num_population'];?></strong></td>
                                                                                                        <td>N° sécu</td>
                                                                                                        <td style="width: 100px" class="h6"><strong><?= $facture['num_population'];?></strong></td>
                                                                                                        <td>N° dossier</td>
                                                                                                        <td style="width: 100px" class="h6"><strong><?= $facture['code_dossier'];?></strong></td>
                                                                                                    </tr>
                                                                                                </table><br />
                                                                                                <table class="table table-bordered table-sm">
                                                                                                    <thead class="bg-secondary">
                                                                                                    <tr>
                                                                                                        <th style="width: 80px">Date</th>
                                                                                                        <th style="width: 70px">Code acte</th>
                                                                                                        <th>Libellé acte</th>
                                                                                                        <th style="width: 80px">Qté</th>
                                                                                                        <th style="width: 80px">P.U.</th>
                                                                                                        <th style="width: 80px">Mt. Total</th>
                                                                                                        <th style="width: 80px">Mt. RGB</th>
                                                                                                        <th style="width: 80px">Mt. Assu.</th>
                                                                                                        <th style="width: 80px">Mt. Pat.</th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                    <?php
                                                                                                    $montant_depense = 0;
                                                                                                    $montant_rgb = 0;
                                                                                                    $montant_rc = 0;
                                                                                                    $montant_patient = 0;
                                                                                                    foreach ($actes as $acte) {
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td class="align_center"><?= date('d/m/Y', strtotime($acte['date_debut']));?></td>
                                                                                                            <td><?= $acte['code'];?></td>
                                                                                                            <td><?= strlen($acte['libelle']) > 70 ? substr(strtolower($acte['libelle']), 0, 70)."..." : strtolower($acte['libelle']);?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['quantite'], '0', '', ' ');?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['prix_unitaire'], '0', '', ' ');?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['montant_depense'], '0', '', ' ');?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['montant_rgb'], '0', '', ' ');?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['montant_rc'], '0', '', ' ');?></td>
                                                                                                            <td class="align_right"><?= number_format($acte['montant_patient'], '0', '', ' ');?></td>
                                                                                                        </tr>
                                                                                                        <?php
                                                                                                        $montant_depense += $acte['montant_depense'];
                                                                                                        $montant_rgb += $acte['montant_rgb'];
                                                                                                        $montant_rc += $acte['montant_rc'];
                                                                                                        $montant_patient += $acte['montant_patient'];
                                                                                                    }
                                                                                                    ?>
                                                                                                    </tbody>
                                                                                                    <tfoot class="bg-secondary">
                                                                                                    <tr>
                                                                                                        <th colspan="5">TOTAL</th>
                                                                                                        <th class="align_right"><?= number_format($montant_depense, '0', '', ' ');?></th>
                                                                                                        <th class="align_right"><?= number_format($montant_rgb, '0', '', ' ');?></th>
                                                                                                        <th class="align_right"><?= number_format($montant_rc, '0', '', ' ');?></th>
                                                                                                        <th class="align_right"><?= number_format($montant_patient, '0', '', ' ');?></th>
                                                                                                    </tr>
                                                                                                    </tfoot>
                                                                                                </table>
                                                                                                <p class="align_right"><button type="button" class="btn btn-sm btn-secondary" id="button_impression_facture"><i class="bi bi-printer"></i> Impression facture</button></p>
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <div class="card bg-indigo">
                                                                                                    <div class="card-body">
                                                                                                        <p class="align_center h5">Paiement</p>
                                                                                                        <?php
                                                                                                        if ($facture['code_statut'] !== 'P') {
                                                                                                            if (in_array('EDT_FCT', $sous_modules, true)) {
                                                                                                                include "../../_Forms/form_facture_medicale_paiement.php";
                                                                                                            }
                                                                                                        } else {
                                                                                                            $paiement = $ETABLISSEMENTS->trouver_facture_paiement($facture['num_facture']);
                                                                                                            ?>
                                                                                                            <table class="table table-sm bg-white">
                                                                                                                <tr>
                                                                                                                    <td>MODE REGLEMENT</td>
                                                                                                                    <td><strong><?= $paiement['libelle_type_reglement'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>N° PAIEMENT</td>
                                                                                                                    <td><strong id="num_paiement_strong"><?= $paiement['num_paiement'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>DATE</td>
                                                                                                                    <td><strong><?= date('d/m/Y H:i', strtotime($paiement['date_creation']));?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>MONTANT</td>
                                                                                                                    <td><strong><?= number_format($paiement['montant_net'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></strong></td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <p class="align_right"><button type="button" class="btn btn-sm btn-secondary" id="button_impression_recu"><i class="bi bi-printer"></i> Impression reçu</button></p>
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
                                                                                    echo '<script>window.location.href="'.URL.'etablissement/factures/"</script>';
                                                                                }
                                                                            } else {
                                                                                echo '<script>window.location.href="'.URL.'etablissement/factures/"</script>';
                                                                            }
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/factures/"</script>';
                                                                        }
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/factures/"</script>';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-journal-check"></i> Factures</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('AFF_FCTS_BRDRS', $sous_modules, true)) {
                                                                            ?><p class="align_right p_button"><a href="<?= URL.'etablissement/factures/bordereaux';?>" class="btn btn-primary btn-sm"><i class="bi bi-book-fill"></i> Bordereaux</a></p><?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-journal-check"></i> Factures</p>
                                                                        <div class="row  justify-content-md-center">
                                                                            <div class="col-sm-12"><?php include "../../_Forms/form_search_ets_factures.php"; ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        let num_facture = $("#num_facture_search_input").val().trim(),
                                                                            num_secu    = $("#num_secu_search_input").val().trim(),
                                                                            num_patient = $("#nip_search_input").val().trim(),
                                                                            nom_prenoms = $("#nom_prenoms_input").val().trim(),
                                                                            date_debut  = $("#date_debut_search_input").val().trim(),
                                                                            date_fin    = $("#date_fin_search_input").val().trim();
                                                                        if (date_debut && date_fin) {
                                                                            display_etablissement_factures(num_facture, num_secu, num_patient, nom_prenoms, date_debut, date_fin);
                                                                            setInterval(function () {
                                                                                display_etablissement_factures(num_facture, num_secu, num_patient, nom_prenoms, date_debut, date_fin);
                                                                            }, 300000);
                                                                        }
                                                                    </script>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_factures.js"></script>';
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
