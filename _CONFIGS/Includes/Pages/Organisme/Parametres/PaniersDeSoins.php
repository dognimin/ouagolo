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
                                                require_once "../../../../Classes/PANIERSDESOINS.php";
                                                $PANIERSDESOINS = new PANIERSDESOINS();
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
                                                        include "../../../Menu.php";
                                                        if(isset($_POST['code'])) {
                                                            $panier = $PANIERSDESOINS->trouver($organisme['code'], strtoupper($_POST['code']));
                                                            if($panier) {
                                                                $actes = $PANIERSDESOINS->lister_panier_actes_medicaux($panier['code']);
                                                                $medicaments = $PANIERSDESOINS->lister_panier_medicaments($panier['code']);
                                                                $pathologies = $PANIERSDESOINS->lister_panier_pathologies($panier['code']);

                                                                $nb_actes = count($actes);
                                                                $nb_medicaments = count($medicaments);
                                                                $nb_pathologies = count($pathologies);
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/parametres/paniers-de-soins';?>"><i class="bi bi-cart-plus"></i> Paniers de soins</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $panier['libelle'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <div class="row">
                                                                        <div class="modal fade" id="afficherModal" tabindex="-1" aria-labelledby="afficherModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                                <div class="modal-content bg-white text-dark">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="afficherModalLabel">Affichage</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body" id="div_afficher"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal fade" id="ajouterModal" tabindex="-1" aria-labelledby="ajouterModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content bg-white text-dark">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="ajouterModalLabel">Ajout</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div id="div_panier_acte"><?php include "../../_Forms/form_panier_de_soins_acte.php";?></div>
                                                                                        <div id="div_panier_medicament"><?php include "../../_Forms/form_panier_de_soins_medicament.php";?></div>
                                                                                        <div id="div_panier_pathologie"><?php include "../../_Forms/form_panier_de_soins_pathologie.php";?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <input type="hidden" id="code_panier_input" value="<?= $panier['code'];?>">
                                                                            <div class="card border-dark">
                                                                                <div class="card-header bg-indigo text-white">
                                                                                    <strong class="h5"><i class="bi bi-ui-radios-grid"></i> Actes médicaux</strong>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info btn_afficher" id="btn_afficher_actes" data-bs-toggle="modal" data-bs-target="#afficherModal" title="Afficher"><i class="bi bi-eye"></i></button>
                                                                                        <button type="button" class="btn btn-primary btn_ajouter" id="btn_ajouter_acte" data-bs-toggle="modal" data-bs-target="#ajouterModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button>
                                                                                    </div><hr />
                                                                                    <p class="p_chiffre_important"><?= number_format($nb_actes, '0', '', ' ');?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card border-dark">
                                                                                <div class="card-header bg-indigo text-white">
                                                                                    <strong class="h5"><i class="bi bi-toggles"></i> Médicaments</strong>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info btn_afficher" id="btn_afficher_medicaments" data-bs-toggle="modal" data-bs-target="#afficherModal" title="Afficher"><i class="bi bi-eye"></i></button>
                                                                                        <button type="button" class="btn btn-primary btn_ajouter" id="btn_ajouter_medicament" data-bs-toggle="modal" data-bs-target="#ajouterModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button>
                                                                                    </div><hr />
                                                                                    <p class="p_chiffre_important"><?= number_format($nb_medicaments, '0', '', ' ');?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card border-dark">
                                                                                <div class="card-header bg-indigo text-white">
                                                                                    <strong class="h5"><i class="bi bi-file-medical-fill"></i> Pathologies</strong>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info btn_afficher" id="btn_afficher_pathologies" data-bs-toggle="modal" data-bs-target="#afficherModal" title="Afficher"><i class="bi bi-eye"></i></button>
                                                                                        <button type="button" class="btn btn-primary btn_ajouter" id="btn_ajouter_pathologie" data-bs-toggle="modal" data-bs-target="#ajouterModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button>
                                                                                    </div><hr />
                                                                                    <p class="p_chiffre_important"><?= number_format($nb_pathologies, '0', '', ' ');?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }else {
                                                            $paniers = $PANIERSDESOINS->lister($organisme['code']);
                                                            $nb_paniers = count($paniers);
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'organisme/parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-cart-plus"></i> Paniers de soins</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                <p class="p_page_titre h4"><i class="bi bi-cart-plus"></i> Paniers de soins</p>
                                                                <div class="row justify-content-md-center">
                                                                    <div id="div_form">
                                                                        <div class="row justify-content-md-center">
                                                                            <div class="col-md-10">
                                                                                <div class="card">
                                                                                    <div class="card-body row">
                                                                                        <h5 class="card-title"></h5>
                                                                                        <div class="row justify-content-md-center">
                                                                                            <?php include "../../_Forms/form_panier_de_soins.php";?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="div_datas">
                                                                        <?php
                                                                        if($nb_paniers == 0) {
                                                                            ?>
                                                                            <p class="align_center alert alert-warning">Aucun panier de soins n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
                                                                            <?php
                                                                        }else {
                                                                            ?>
                                                                            <table class="table table-bordered table-hover table-sm table-striped" id="table_paniers_de_soins" style="background: #ffffff">
                                                                                <thead class="bg-indigo text-white">
                                                                                <tr>
                                                                                    <th style="width: 5px">N°</th>
                                                                                    <th style="width: 10px">CODE</th>
                                                                                    <th>LIBELLE</th>
                                                                                    <th style="width: 100px">DATE EFFET</th>
                                                                                    <th style="width: 5px"></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $ligne = 1;
                                                                                foreach ($paniers as $panier) {
                                                                                    $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($panier['date_debut'])));
                                                                                    $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                                                                                    if(strtotime($date_fin) > strtotime($date_edition)) {
                                                                                        $validite_edition = 1;
                                                                                    }else {
                                                                                        $validite_edition = 0;
                                                                                    }
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                        <td><?= $panier['code'];?></td>
                                                                                        <td><?= $panier['libelle'];?></td>
                                                                                        <td class="align_center"><?= date('d/m/Y',strtotime($panier['date_debut']));?></td>
                                                                                        <td class="bg-info"><a href="<?= URL.'organisme/parametres/paniers-de-soins?code='.strtolower($panier['code']);?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
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
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_parametres_paniers_de_soins.js"></script>';
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