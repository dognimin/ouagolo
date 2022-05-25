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
                                                    if (in_array('AFF_PRMTRS', $modules, true) && in_array('AFF_PRMTRS_PNS', $sous_modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";
                                                                require_once "../../../../Classes/TYPESFACTURESMEDICALES.php";
                                                                require_once "../../../../Classes/ACTESMEDICAUX.php";
                                                                $TYPESFACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                                                                $ACTESMEDICAUX = new ACTESMEDICAUX();
                                                                $actes = $ACTESMEDICAUX->lister_actes_medicaux(null);
                                                                $nb_actes = count($actes);
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'etablissement/parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-cart-plus"></i> Panier de soins</li>
                                                                        </ol>
                                                                    </nav>
                                                                    <p class="p_page_titre h4"><i class="bi bi-cart-plus"></i> Panier de soins</p>
                                                                    <?php
                                                                    if ($nb_actes != 0) {
                                                                        $types = $TYPESFACTURESMEDICALES->lister();
                                                                        ?>
                                                                        <div class="modal fade" id="editionActeModal" tabindex="-1" aria-labelledby="editionActeModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionActeModalLabel"></h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_etablissement_panier_soins.php";?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_actes">
                                                                            <thead class="bg-secondary text-white">
                                                                            <tr>
                                                                                <th>N°</th>
                                                                                <th>CODE</th>
                                                                                <th>LIBELLE</th>
                                                                                <th>FACTURE</th>
                                                                                <th style="width: 50px">TARIF</th>
                                                                                <th style="width: 70px">DATE DEBUT</th>
                                                                                <?php
                                                                                if (in_array('EDT_PRMTRS_PNS', $sous_modules, true)) {
                                                                                    echo '<th style="width: 5px"></th>';
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $ligne = 1;
                                                                            foreach ($actes as $acte) {
                                                                                $panier_acte = $ETABLISSEMENTS->trouver_panier_acte($ets['code'], $acte['code']);
                                                                                if (!$panier_acte) {
                                                                                    $panier_acte = array(
                                                                                        'code_type_facture' => null,
                                                                                        'date_debut' => null,
                                                                                        'tarif' => null
                                                                                    );
                                                                                }
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="align_right"><?= $ligne;?></td>
                                                                                    <td><?= $acte['code'];?></td>
                                                                                    <td><?= $acte['libelle'];?></td>
                                                                                    <td><?= $panier_acte['code_type_facture'];?></td>
                                                                                    <td class="align_right"><?= number_format($panier_acte['tarif'], '0', '', ' ');
                                                                                        if ($panier_acte['tarif']) {
                                                                                            echo $ets['libelle_monnaie'];
                                                                                        }?></td>
                                                                                    <td class="align_center"><?= $panier_acte['date_debut']? date('d/m/Y', strtotime($panier_acte['date_debut'])): null;?></td>
                                                                                    <?php
                                                                                    if (in_array('EDT_PRMTRS_PNS', $sous_modules, true)) {
                                                                                        ?>
                                                                                        <td><button type="button" id="<?= $acte['code'];?>" class="badge bg-warning button_edition_acte" data-bs-toggle="modal" data-bs-target="#editionActeModal"><i class="bi bi-pencil-square"></i></button></td>
                                                                                        <?php
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
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                echo '<script src="'.JS.'page_etablissement_parametres_panier_soins.js"></script>';
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                        }
                                                    } else {
                                                        echo '<script>window.location.href="'.URL.'etablissement/parametres/"</script>';
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
