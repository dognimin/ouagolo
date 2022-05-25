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
                                                    if (in_array('AFF_PHCIE', $modules, true) && in_array('AFF_PHCIE_CMDS', $sous_modules, true)) {
                                                        $service = $ETABLISSEMENTS->trouver_service($ets['code'], 'PHCIE');
                                                        if ($service) {
                                                            if (isset($parametres['url'])) {
                                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                                if ($audit['success'] === true) {
                                                                    include "../../../Menu.php";
                                                                    if (isset($_POST['numero'])) {
                                                                        $commande = $ETABLISSEMENTS->trouver_commande($ets['code'], $_POST['numero']);
                                                                        if ($commande) {
                                                                            $produits = $ETABLISSEMENTS->lister_commande_produits($commande['code']);
                                                                            $nb_produits = count($commande);
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/pharmacie/';?>"><i class="bi bi-dpad-fill"></i> Pharmacie</a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/pharmacie/commandes';?>"><i class="bi bi-tv-fill"></i> Commandes</a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page">Commande n° <?= $commande['code'];?></li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <div class="row">
                                                                                    <div class="col-sm-5">
                                                                                        <table class="table table-bordered table-sm border-dark">
                                                                                            <tr>
                                                                                                <td style="width: 100px">Etat</td>
                                                                                                <td class="text-<?= str_replace(
                                                                                                    '0',
                                                                                                    'warning',
                                                                                                    str_replace(
                                                                                                        '2',
                                                                                                        'success',
                                                                                                        str_replace('1', 'danger', $commande['statut'])
                                                                                                    )
                                                                                                );?>">
                                                                                                    <strong>
                                                                                                        <?= str_replace(
                                                                                                            '0',
                                                                                                            'EN COURS',
                                                                                                            str_replace(
                                                                                                                '2',
                                                                                                                'RÉCEPTIONNÉ',
                                                                                                                str_replace('1', 'ANNULÉ', $commande['statut'])
                                                                                                            )
                                                                                                        );?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>N° Commande</td>
                                                                                                <td><strong><?= $commande['code'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Date</td>
                                                                                                <td><strong><?= date('d/m/Y', strtotime($commande['date_commande']));?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Fournisseur</td>
                                                                                                <td><strong><?= $commande['libelle_fournisseur'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Initiée par</td>
                                                                                                <td><strong><?= $commande['nom'].' '.$commande['prenoms'];?></strong></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="modal fade" id="receptionnerModal" tabindex="-1" aria-labelledby="receptionnerModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content bg-white text-dark">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="receptionnerModalLabel">Réception de la commande n° <?= $commande['code'];?></h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body"><?php include "../../_Forms/form_etablissement_reception_commande.php";?></div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal fade" id="annulerModal" tabindex="-1" aria-labelledby="annulerModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-sm">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="annulerModalLabelLabel">Commande n° <?= $commande['code'];?></h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        ...
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="p_button align_right">
                                                                                            <?php
                                                                                            if (in_array('EDT_PHCIE_CMDS', $sous_modules, true)) {
                                                                                                if ($commande['statut'] === '0') {
                                                                                                    ?>
                                                                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#receptionnerModal" title="Réceptionner la commande"><i class="bi bi-check"></i></button>
                                                                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#annulerModal" title="Annuler la commande"><i class="bi bi-x"></i></button>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            if ($commande['statut'] !== '1') {
                                                                                                ?>
                                                                                                <button class="btn btn-sm btn-secondary button_imprimer" title="Imprimer la commande" id="<?= $commande['code'];?>"><i class="bi bi-printer"></i></button>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <?php
                                                                                        if ($nb_produits != 0) {
                                                                                            ?>
                                                                                            <table class="table table-bordered table-sm border-dark">
                                                                                                <thead class="bg-indigo text-white">
                                                                                                <tr>
                                                                                                    <th style="width: 5px">#</th>
                                                                                                    <th style="width: 100px">CODE</th>
                                                                                                    <th>DESIGNATION</th>
                                                                                                    <th style="width: 100px">PRIX UNITAIRE</th>
                                                                                                    <th style="width: 100px">QUANTITE</th>
                                                                                                    <th style="width: 100px">MONTANT</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php
                                                                                                $ligne = 1;
                                                                                                $montant_commande = 0;
                                                                                                foreach ($produits as $produit) {
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?= $ligne;?></td>
                                                                                                        <td><strong><?= $produit['code'];?></strong></td>
                                                                                                        <td><?= $produit['libelle'];?></td>
                                                                                                        <td class="align_right"><?= number_format($produit['prix_unitaire'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                        <td class="align_right"><?= number_format($produit['quantite'], '0', '', ' ');?></td>
                                                                                                        <td class="align_right"><?= number_format((int)($produit['prix_unitaire'] * $produit['quantite']), '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    $montant_commande += (int)($produit['prix_unitaire'] * $produit['quantite']);
                                                                                                    $ligne++;
                                                                                                }
                                                                                                ?>
                                                                                                </tbody>
                                                                                                <tfoot class="bg-indigo text-white">
                                                                                                <tr>
                                                                                                    <th colspan="5">TOTAL</th>
                                                                                                    <th class="align_right"><?= number_format($montant_commande, '0', '', ' ').' '.$ets['libelle_monnaie'];?></th>
                                                                                                </tr>
                                                                                                </tfoot>
                                                                                            </table>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/pharmacie/commandes"</script>';
                                                                        }
                                                                    } else {
                                                                        $fournisseurs = $ETABLISSEMENTS->lister_fournisseurs($ets['code']);
                                                                        ?>
                                                                        <div class="container-xl" id="div_main_page">
                                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                <ol class="breadcrumb">
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                    <li class="breadcrumb-item"><a href="<?= URL.'etablissement/pharmacie/';?>"><i class="bi bi-dpad-fill"></i> Pharmacie</a></li>
                                                                                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-tv-fill"></i> Commandes</li>
                                                                                </ol>
                                                                            </nav>
                                                                            <?php
                                                                            if (in_array('EDT_PHCIE_CMDS', $sous_modules, true)) {
                                                                                ?>
                                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#commandeModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                                <div class="modal fade" id="commandeModal" tabindex="-1" aria-labelledby="commandeModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                        <div class="modal-content bg-white text-dark">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="commandeModalLabel">Nouvelle commande</h5>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body"><?php include "../../_Forms/form_etablissement_commande.php";?></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <p class="p_page_titre h4"><i class="bi bi-tv-fill"></i> Commandes</p>
                                                                            <?php include "../../_Forms/form_search_commandes.php";?>
                                                                        </div>
                                                                        <script>
                                                                            let code_commande       = $("#code_commande_search_input").val().trim(),
                                                                                code_fournisseur    = $("#code_fournisseur_search_input").val().trim(),
                                                                                statut              = $("#statut_search_input").val().trim(),
                                                                                date_debut  = $("#date_debut_search_input").val().trim(),
                                                                                date_fin    = $("#date_fin_search_input").val().trim();
                                                                            if (date_debut && date_fin) {
                                                                                display_etablissement_commandes(code_commande, code_fournisseur, statut, date_debut, date_fin);
                                                                                setInterval(function () {
                                                                                    display_etablissement_commandes(code_commande, code_fournisseur, statut, date_debut, date_fin);
                                                                                }, 300000);
                                                                            }
                                                                        </script>
                                                                        <?php
                                                                    }

                                                                    echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                    echo '<script src="'.JS.'page_etablissement_commandes.js"></script>';
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
