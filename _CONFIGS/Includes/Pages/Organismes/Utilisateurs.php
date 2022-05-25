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
                                            require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                            require_once "../../../Classes/PROFILSUTILISATEURS.php";
                                            require_once "../../../Classes/CIVILITES.php";
                                            require_once "../../../Classes/SEXES.php";
                                            $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                            $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                                            $CIVILITES = new CIVILITES();
                                            $SEXES = new SEXES();
                                            require_once "../../../Classes/ORGANISMES.php";
                                            $ORGANISMES = new ORGANISMES();
                                            $payss = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                            ?>
                                            <div class="container-xl" id="div_main_page">
                                                <?php
                                                if (isset($_POST['code']) && $_POST['code']) {
                                                    $organisme = $ORGANISMES->trouver(strtoupper(clean_data($_POST['code'])));
                                                    if($organisme) {
                                                        $profils = $PROFILSUTILISATEURS->lister();
                                                        $organismes = $ORGANISMES->lister();
                                                        $civilites = $CIVILITES->lister();
                                                        $sexes = $SEXES->lister();
                                                        $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($organisme['code_pays']);
                                                        $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($organisme['code_region']);
                                                        $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($organisme['code_departement']);
                                                        $organisme_utilisateurs = $ORGANISMES->lister_utilisateurs($organisme['code']);
                                                        $nb_organisme_utilisateurs = count($organisme_utilisateurs);
                                                        ?>
                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL.'organismes/';?>"><i class="bi bi-award"></i> Assurances / Mutuelles</a></li>
                                                                <li class="breadcrumb-item"><a href="<?= URL.'organismes/?code='.$organisme['code'];?>"><?= $organisme['libelle'];?></a></li>
                                                                <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
                                                            </ol>
                                                        </nav>
                                                        <p class="p_page_titre h4"><i class="bi bi-people"></i> Utilisateurs <?= $organisme['libelle'];?></p>
                                                        <p class="align_right"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button></p>
                                                        <div class="col-sm-12">
                                                            <?php
                                                            if($nb_organisme_utilisateurs != 0) {
                                                                ?>
                                                                <table class="table table-bordered table-hover table-sm table-striped" id="table_utilisateurs">
                                                                    <thead class="bg-secondary">
                                                                    <tr>
                                                                        <th style="width: 5px">N°</th>
                                                                        <th style="width: 80px">N° SECU</th>
                                                                        <th>NOM & PRENOM(S)</th>
                                                                        <th>EMAIL</th>
                                                                        <th style="width: 5px"><i class="bi bi-person-fill"></i></th>
                                                                        <th style="width: 5px"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $ligne = 1;
                                                                    foreach ($organisme_utilisateurs as $organisme_utilisateur) {
                                                                        ?>
                                                                        <tr>
                                                                            <td class="align_right"><?= $ligne; ?></td>
                                                                            <td><?= $organisme_utilisateur['num_secu']; ?></td>
                                                                            <td><?= $organisme_utilisateur['nom'] . ' ' . $organisme_utilisateur['prenoms']; ?></td>
                                                                            <td><strong><a href="mailto:<?= $organisme_utilisateur['email']; ?>"><?= $organisme_utilisateur['email']; ?></a></strong></td>
                                                                            <td class="align_center h6"><i class="<?= str_replace(1, 'bi bi-person-check-fill text-success', str_replace(0, 'bi bi-person-x-fill text-danger', $organisme_utilisateur['statut']));?>"></i></td>
                                                                            <td><a href="<?= URL . 'organismes/utilisateurs/?code-organisme='.strtolower($organisme['code']).'&uid=' . $organisme_utilisateur['id_user']; ?>"
                                                                                   class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                                                                        </tr>
                                                                        <?php
                                                                        $ligne++;
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                                <p class="align_center alert alert-warning">Aucun utilisateur n'a encore été enregistré pour cet organisme. <br />Cliquez sur <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal" title="Ajouter"><i class="bi bi-plus-square-fill"></i></button> pour en ajouter un.</p>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal fade" id="editionModal" tabindex="-1"
                                                             aria-labelledby="editionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editionModalLabel">Nouvel utilisateur</h5></div>
                                                                    <div class="modal-body">
                                                                        <?php include "../_Forms/form_utilisateur.php"; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }else {
                                                        echo '<script>window.location.href="'.URL.'organismes/"</script>';
                                                    }
                                                }
                                                else {
                                                    echo '<script>window.location.href="'.URL.'organismes/"</script>';
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            echo '<script src="'.JS.'deconnexion_1.js"></script>';
                                            echo '<script src="'.JS.'page_organismes.js"></script>';
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