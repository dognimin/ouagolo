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
                                        require_once "../../../../Classes/COLLEGES.php";
                                        require_once "../../../../Classes/POLICES.php";
                                        require_once "../../../../Classes/COLLECTIVITES.php";
                                        $COLLEGES = new COLLEGES();
                                        $ORGANISMES = new ORGANISMES();
                                        $POLICES = new POLICES();
                                        $COLLECTIVITES = new COLLECTIVITES();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                                        if($user_profil) {
                                            $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                                            if($organisme) {
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
                                                        include "../../../Menu.php";
                                                        if(isset($_POST['id']) && $_POST['id']) {
                                                            $police = $POLICES->trouver($organisme['code'], strtoupper($_POST['id']));
                                                            if($police) {
                                                                $collectivite = $COLLECTIVITES->trouver($police['code_collectivite']);
                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/polices/';?>"><i class="bi bi-file-earmark-font-fill"></i> Polices</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $police['nom'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <p class="p_page_titre h4"><i class="bi bi-file-earmark-font-fill"></i> <?= $police['nom'];?></p>
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="card border-dark">
                                                                                    <div class="card-header bg-indigo text-white">
                                                                                        <h5>Informations</h5>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <table class="table table-sm">
                                                                                            <tr>
                                                                                                <td>N° de la police</td>
                                                                                                <td class="align_right"><strong><?= $police['id_police'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Libellé</td>
                                                                                                <td class="align_right"><strong><?= $police['nom'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Validité</td>
                                                                                                <td class="align_right"><strong><?= $police['date_fin']? 'Du '.date('d/m/Y', strtotime($police['date_debut'])).' au '.date('d/m/Y', strtotime($police['date_fin'])): 'Depuis le '.date('d/m/Y', strtotime($police['date_debut']));?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Code du souscripteur</td>
                                                                                                <td class="align_right"><strong><?= $police['code_collectivite'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Raison sociale souscripteur</td>
                                                                                                <td class="align_right"><strong><?= $police['raison_sociale'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Secteur d'activité</td>
                                                                                                <td class="align_right"><strong><?= $collectivite['code_secteur_activite'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Adresse</td>
                                                                                                <td class="align_right"><strong><?= $collectivite['nom_pays'].', '.$collectivite['nom_region'].', '.$collectivite['nom_departement'].', '.$collectivite['nom_commune'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Adresse postale</td>
                                                                                                <td class="align_right"><strong><?= $collectivite['adresse_postale'];?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Adresse géographique</td>
                                                                                                <td class="align_right"><strong><?= $collectivite['adresse_geographique'];?></strong></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="card border-dark">
                                                                                    <div class="card-header bg-success text-white">
                                                                                        <h5>Collège(s)</h5>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <?php
                                                                                        $colleges = $POLICES->lister_colleges($police['id_police']);
                                                                                        $nb_colleges = count($colleges);
                                                                                        if($nb_colleges != 0) {
                                                                                            ?>
                                                                                            <table class="table table-sm table-bordered table-hover table-stripped">
                                                                                                <thead class="bg-indigo text-white">
                                                                                                <tr>
                                                                                                    <th style="width: 5px">#</th>
                                                                                                    <th>DESIGNATION</th>
                                                                                                    <th style="width: 50px">DEBUT</th>
                                                                                                    <th style="width: 50px">FIN</th>
                                                                                                    <th style="width: 5px"></th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php
                                                                                                $ling_contrat = 1;
                                                                                                foreach ($colleges as $college) {
                                                                                                    $college_statut = $COLLEGES->trouver_statut($college['code']);
                                                                                                    ?>
                                                                                                    <tr style="font-weight: bold" class="bg-<?= $college_statut? str_replace('ACT', 'light', str_replace('SUS', 'warning', str_replace('RES', 'danger', $college_statut['statut']))): 'secondary';?>">
                                                                                                        <td><?= $ling_contrat;?></td>
                                                                                                        <td><?= $college['libelle'];?></td>
                                                                                                        <td class="align_center"><?= date('d/m/Y', strtotime($college['date_debut']));?></td>
                                                                                                        <td class="align_center"><?= $college['date_fin']? date('d/m/Y', strtotime($college['date_fin'])): null;?></td>
                                                                                                        <td class=" bg-info"><a href="<?= URL.'organisme/colleges/?id-police='.$police['id_police'].'&code='.$college['code'];?>" target="_blank" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    $ling_contrat++;
                                                                                                }
                                                                                                ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <?php
                                                                                        }else {
                                                                                            echo '<p class="alert alert-info align_center">Aucun collège n\'a encore été ajouté à cette police.</p>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }else {
                                                                echo '<script>window.location.href="'.URL.'organisme/collectivites/"</script>';
                                                            }

                                                        }else {
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-file-earmark-font-fill"></i> Polices</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                <p class="p_page_titre h4"><i class="bi bi-file-earmark-font-fill"></i> Polices</p>
                                                                <div class="col-sm-12"><?php include "../../_Forms/form_search_organisme_polices.php"; ?></div>
                                                                <div class="modal fade" id="editionModal" tabindex="-1"
                                                                     aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content bg-white text-dark">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editionModalLabel">Nouvelle police</h5></div>
                                                                            <div class="modal-body">
                                                                                <?php include "../../_Forms/form_organisme_police.php"; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_polices.js"></script>';
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