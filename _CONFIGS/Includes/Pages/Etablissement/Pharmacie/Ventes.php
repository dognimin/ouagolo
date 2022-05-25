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
                                        require_once "../../../../Classes/TYPESREGLEMENTS.php";
                                        require_once "../../../../Classes/ETABLISSEMENTS.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $TYPESREGLEMENTS = new TYPESREGLEMENTS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_PHCIE', $modules, true) && in_array('AFF_PHCIE_VNTS', $sous_modules, true)) {
                                                        $service = $ETABLISSEMENTS->trouver_service($ets['code'], 'PHCIE');
                                                        if ($service) {
                                                            if (isset($parametres['url'])) {
                                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                                if ($audit['success'] === true) {
                                                                    include "../../../Menu.php";
                                                                    $types_reglements = $TYPESREGLEMENTS->lister();
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/pharmacie/';?>"><i class="bi bi-dpad-fill"></i> Pharmacie</a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-cart-fill"></i> Ventes</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PHCIE_VNTS', $sous_modules, true)) {
                                                                            ?>
                                                                            <div id="div_nouvelle_vente">
                                                                                <div class="card text-dark">
                                                                                    <div class="card-header h5">Facture n° </div>
                                                                                    <div class="card-body">
                                                                                        <?php include "../../_Forms/form_pharmacie_vente.php";?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <p class="align_right p_button"><button type="button" id="button_nouvelle_vente" class="btn btn-sm btn-success"><i class="bi bi-cart-plus"></i> Nouvelle vente</button></p>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <p class="p_page_titre h4"><i class="bi bi-cart-fill"></i> Ventes du jour</p>
                                                                        <div id="div_ventes_du_jour">
                                                                            <?php
                                                                            $date_debut = date('Y-m-d 00:00:00', time());
                                                                            $date_fin = date('Y-m-d 23:59:59', time());
                                                                            $ventes = $ETABLISSEMENTS->lister_ventes($ets['code'], $date_debut, $date_fin);
                                                                            $nb_ventes = count($ventes);
                                                                            if ($nb_ventes !== 0) {
                                                                                ?>
                                                                                <table class="table table-bordered table-sm table-stripped table-hover" id="table_ventes">
                                                                                    <thead class="bg-indigo text-white">
                                                                                    <tr>
                                                                                        <th style="width: 5px">#</th>
                                                                                        <th style="width: 60px">DATE</th>
                                                                                        <th style="width: 40px">HEURE</th>
                                                                                        <th style="width: 100px">N° TICKET</th>
                                                                                        <th style="width: 100px">MONTANT BRUT</th>
                                                                                        <th style="width: 100px">MONTANT RGB</th>
                                                                                        <th style="width: 100px">MONTANT ORG.</th>
                                                                                        <th style="width: 100px">REMISE</th>
                                                                                        <th style="width: 100px">MONTANT NET</th>
                                                                                        <th>CAISSIER</th>
                                                                                        <th style="width: 5px"></th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <?php
                                                                                    $ligne = 1;
                                                                                    $montant_caisse = 0;
                                                                                    foreach ($ventes as $vente) {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td class="align_right"><?= $ligne;?></td>
                                                                                            <td class="align_center"><?= date('d/m/Y', strtotime($vente['date_creation']));?></td>
                                                                                            <td class="align_center"><?= date('H:i', strtotime($vente['date_creation']));?></td>
                                                                                            <td class="align_right"><?= $vente['num_ticket'];?></td>
                                                                                            <td class="align_right"><?= number_format($vente['montant_brut'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                            <td class="align_right"><?= number_format($vente['montant_rgb'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                            <td class="align_right"><?= number_format($vente['montant_organisme'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                            <td class="align_right"><?= number_format($vente['taux_remise'], '0', '', ' ').' %';?></td>
                                                                                            <td class="align_right"><?= number_format($vente['montant_net'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                            <td><?= $vente['nom_caissier'].' '.$vente['prenom_caissier'];?></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $ligne++;
                                                                                        $montant_caisse += $vente['montant_net'];
                                                                                    }
                                                                                    ?>
                                                                                    </tbody>
                                                                                    <tfoot class="bg-indigo text-white">
                                                                                    <tr>
                                                                                        <th colspan="8">MONTANT EN CAISSE</th>
                                                                                        <th class="align_right"><?= number_format($montant_caisse, '0', '', ' ').' '.$ets['libelle_monnaie'];?></th>
                                                                                        <th colspan="2"></th>
                                                                                    </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <p class="align_center alert alert-info">Aucune vente n'a encore été faite ce jour.</p>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                    echo '<script src="'.JS.'page_etablissement_pharmacie.js"></script>';
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
                                                        echo '<script>window.location.href="'.URL.'etablissement/pharmacie/"</script>';
                                                    }
                                                } else {
                                                    echo '<script>window.location.href="'.URL.'etablissement/pharmacie/"</script>';
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
