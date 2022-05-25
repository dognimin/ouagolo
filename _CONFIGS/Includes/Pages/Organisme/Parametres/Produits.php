<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'],null);
            if($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if($user_statut) {
                    if($user_statut['statut'] == 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if($user_mdp) {
                            if($user_mdp['statut'] == 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if($profil['code_profil'] == 'ORGANI') {
                                        require_once "../../../../Classes/ORGANISMES.php";
                                        $ORGANISMES = new ORGANISMES();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                                        if($user_profil) {
                                            $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                                            if($organisme) {
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
                                                        include "../../../Menu.php";

                                                        require_once "../../../../Classes/RESEAUXDESOINS.php";
                                                        require_once "../../../../Classes/PANIERSDESOINS.php";
                                                        require_once "../../../../Classes/PRODUITS.php";
                                                        $RESEAUXDESOINS = new RESEAUXDESOINS();
                                                        $PANIERSDESOINS = new PANIERSDESOINS();
                                                        $PRODUITS = new \App\PRODUITS();

                                                        $reseaux = $RESEAUXDESOINS->lister($organisme['code']);
                                                        $paniers = $PANIERSDESOINS->lister($organisme['code']);

                                                        if(isset($_POST['code'])) {
                                                            $produit = $PRODUITS->trouver($organisme['code'], $_POST['code']);
                                                            if($produit) {
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/produits'; ?>"><i class="bi bi-bag-fill"></i> Produits</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $produit['libelle'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content bg-white text-dark">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="editionModalLabel">Edition <?= $produit['libelle'];?></h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body"><?php include "../../_Forms/form_organisme_produit.php";?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="p_page_titre h4"><i class="bi bi-bag-fill"></i> <?= $produit['libelle'];?></p>
                                                                    <p><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pen"></i></button></p>
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <div class="card border-dark">
                                                                                <div class="card-header"><strong>Détails</strong></div>
                                                                                <div class="card-body">
                                                                                    <table class="table table-sm">
                                                                                        <tr>
                                                                                            <td>Code</td>
                                                                                            <td class="align_right"><strong><?= $produit['code'];?></strong></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Libellé</td>
                                                                                            <td class="align_right"><strong><?= $produit['libelle'];?></strong></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Date début</td>
                                                                                            <td class="align_right"><strong><?= date('d/m/Y', strtotime($produit['date_debut']));?></strong></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Panier de soins</td>
                                                                                            <td class="align_right"><strong><a target="_blank" href="<?= URL.'organisme/parametres/paniers-de-soins?code='.$produit['code_panier_soins'];?>"><?= $produit['libelle_panier_soins'];?></a></strong></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Réseau de soins</td>
                                                                                            <td class="align_right"><strong><a target="_blank" href="<?= URL.'organisme/parametres/reseaux-de-soins?code='.$produit['code_reseau_soins'];?>"><?= $produit['libelle_reseau_soins'];?></a></strong></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="align_center" colspan="2">Description</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2"><strong><?= $produit['description'];?></strong></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card border-dark">
                                                                                <div class="card-header"><strong>Collèges associés au produit</strong></div>
                                                                                <div class="card-body">
                                                                                    <?php
                                                                                    $colleges = $PRODUITS->lister_contrats($produit['code']);
                                                                                    $nb_colleges = count($colleges);
                                                                                    if($nb_colleges !== 0) {
                                                                                        ?>
                                                                                        <table class="table table-bordered table-sm table-stripped table-hover" id="table_contrats">
                                                                                            <thead class="bg-indigo text-white">
                                                                                            <tr>
                                                                                                <th style="width: 5px">#</th>
                                                                                                <th style="width: 120px">CODE</th>
                                                                                                <th>LIBELLE</th>
                                                                                                <th>COLLECTIVITE</th>
                                                                                                <th style="width: 5px"></th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            <?php
                                                                                            $ligne = 1;
                                                                                            foreach ($colleges as $college) {
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td class="align_right"><?= $ligne;?></td>
                                                                                                    <td><?= $college['code_contrat'];?></td>
                                                                                                    <td><?= $college['libelle_contrat'];?></td>
                                                                                                    <td><?= $college['raison_sociale'];?></td>
                                                                                                    <td class="bg-info"><a href="<?= URL . 'organisme/colleges/?id-police='.$college['id_police'].'&code='.$college['code_college']; ?>" target="_blank" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                                $ligne++;
                                                                                            }
                                                                                            ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <?php
                                                                                    }else {
                                                                                        echo '<p class="alert alert-info align_center">Aucun contrat n\'a encore été assigné à ce produit.</p>';
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }else {
                                                                echo '<script>window.location.href="'.URL.'organisme/parametres/produits"</script>';
                                                            }
                                                        } else {
                                                            $produits = $PRODUITS->lister($organisme['code']);
                                                            $nb_produits = count($produits);
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-bag-fill"></i> Produits</li>
                                                                    </ol>
                                                                </nav>
                                                                <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content bg-white text-dark">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Nouveau produit</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body"><?php include "../../_Forms/form_organisme_produit.php";?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                <p class="p_page_titre h4"><i class="bi bi-bag-fill"></i> Produits</p>
                                                                <?php
                                                                if($nb_produits !== 0) {
                                                                    ?>
                                                                    <table class="table table-bordered table-sm table-stripped table-hover" id="table_produits">
                                                                        <thead class="bg-indigo text-white">
                                                                        <tr>
                                                                            <th style="width: 5px">#</th>
                                                                            <th style="width: 50px">CODE</th>
                                                                            <th>LIBELLE</th>
                                                                            <th>PANIER DE SOINS</th>
                                                                            <th>RESEAU DE SOINS</th>
                                                                            <th style="width: 5px"></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $ligne = 1;
                                                                        foreach ($produits as $produit) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= $ligne; ?></td>
                                                                                <td><?= $produit['code']; ?></td>
                                                                                <td><?= $produit['libelle']; ?></td>
                                                                                <td><?= $produit['libelle_panier_soins']; ?></td>
                                                                                <td><?= $produit['libelle_reseau_soins']; ?></td>
                                                                                <td class="bg-info"><a href="<?= URL.'organisme/parametres/produits?code='.$produit['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                            </tr>
                                                                            <?php
                                                                            $ligne++;
                                                                        }
                                                                        ?>
                                                                        </tbody>
                                                                    </table>
                                                                    <?php
                                                                } else {
                                                                    echo '<p class="alert alert-info">Aucun produit n\'a encore été enregistré. Cliquez sur <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus"></i></button> pour en ajouter un.</p>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_parametres_produits.js"></script>';
                                                    }else {
                                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                    }
                                                }else {
                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                }
                                            }else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        }else{
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    }else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                }else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            }else {

                                echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                            }
                        }else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                    }else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                }else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        }else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    }else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}