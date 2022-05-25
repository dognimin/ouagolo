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
                                                        ?>
                                                        <div class="container-xl" id="div_main_page">
                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                <ol class="breadcrumb">
                                                                    <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-question-circle"></i> Support</li>
                                                                </ol>
                                                            </nav>
                                                            <div class="row  justify-content-md-center">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-dark text-white">
                                                                                <i class="bi bi-stickies-fill"></i>
                                                                                <p>999 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Tickets</a></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-success text-white">
                                                                                <i class="bi bi-check2-circle"></i>
                                                                                <p>99 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Résolus</a></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-warning text-white">
                                                                                <i class="bi bi-card-heading"></i>
                                                                                <p>99 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">En cours</a></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-danger text-white">
                                                                                <i class="bi bi-megaphone-fill"></i>
                                                                                <p>9 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Urgent!</a></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-info text-white">
                                                                                <i class="bi bi-box-seam"></i>
                                                                                <p>2 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Demandes</a></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-secondary text-white">
                                                                                <i class="bi bi-bullseye"></i>
                                                                                <p>12 K</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Incidents</a></small>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-primary text-white">
                                                                                <i class="bi bi-clock"></i>
                                                                                <p>1</p>
                                                                                <small><a class="btn btn-sm btn-light" href="">Tickets du jour</a></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="div_support_boxes bg-dark">Test</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <p class="align_right"><button type="button" class="btn btn-primary btn-sm" title="Nouveau ticket"><i class="bi bi-plus"></i></button></p>
                                                                            <p class="p_page_titre h4">Tickets du jour (<?= date('d/m/Y',time());?>)</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
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