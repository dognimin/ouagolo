<?php
require_once "../../../Classes/UTILISATEURS.php";
require_once "../../../Functions/Functions.php";
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
                                    if($profil['code_profil'] == 'ADMN') {
                                        if (isset($parametres['url'])) {
                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                            include "../../Menu.php";

                                            require_once "../../../Classes/BAREMES.php";
                                            $BAREMES = new \App\BAREMES();
                                            if(isset($_POST['code']) && $_POST['code']) {
                                                $bareme = $BAREMES->trouver($_POST['code']);
                                                if($bareme) {
                                                    ?>
                                                    <div class="container-xl" id="div_main_page">
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL.'organismes/';?>"><i class="bi bi-award"></i> Organismes</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL.'organismes/baremes';?>"><i class="bi bi-water"></i> Gabarit de barème</a></li>
                                                                <li class="breadcrumb-item active" aria-current="page"><?= $bareme['libelle'];?></li>
                                                            </ol>
                                                        </nav>
                                                        <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content bg-white text-dark">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editionModalLabel">Edition <?= $bareme['libelle'];?></h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php include "../_Forms/form_bareme.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="align_right p_button">
                                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="édition <?= $bareme['libelle'];?>"><i class="bi bi-pencil-square"></i></button>
                                                        </p>
                                                        <p class="p_page_titre h4"><i class="bi bi-water"></i> <?= $bareme['libelle'];?></p>

                                                    </div>
                                                    <?php
                                                }else {
                                                    echo '<script>window.location.href="'.URL.'organismes/baremes"</script>';
                                                }
                                            }else {
                                                ?>
                                                <div class="container-xl" id="div_main_page">
                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                            <li class="breadcrumb-item"><a href="<?= URL.'organismes/';?>"><i class="bi bi-award"></i> Organismes</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-water"></i> Gabarit de barème</li>
                                                        </ol>
                                                    </nav>
                                                    <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content bg-white text-dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editionModalLabel">Nouveau gabarit</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php include "../_Forms/form_bareme.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="align_right p_button">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Nouveau gabarit"><i class="bi bi-plus-square-fill"></i></button>
                                                    </p>
                                                    <p class="p_page_titre h4"><i class="bi bi-water"></i> Gabarits de Barème</p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <?php
                                                            $baremes = $BAREMES->lister();
                                                            $nb_baremes = count($baremes);
                                                            if($nb_baremes !== 0) {
                                                                ?>
                                                                <table class="table table-bordered table-sm table-stripped table-hover" id="table_baremes">
                                                                    <thead class="bg-indigo text-white">
                                                                    <tr>
                                                                        <th style="width: 5px">#</th>
                                                                        <th style="width: 50px">CODE</th>
                                                                        <th>LIBELLE</th>
                                                                        <th style="width: 5px"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $ligne = 1;
                                                                    foreach ($baremes as $bareme) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $ligne; ?></td>
                                                                            <td><?= $bareme['code']; ?></td>
                                                                            <td><?= $bareme['libelle']; ?></td>
                                                                            <td class="bg-info"><a href="<?= URL.'organismes/baremes?code='.$bareme['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                        </tr>
                                                                        <?php
                                                                        $ligne++;
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php
                                                            } else {
                                                                echo '<p class="alert alert-info">Aucun gabarit n\'a encore été enregistré. Cliquez sur <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus"></i></button> pour en ajouter un.</p>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                            echo '<script src="'.JS.'page_organismes_baremes.js"></script>';
                                        }else {
                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
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