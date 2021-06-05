<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
require_once "../../../../Classes/SECURITESCOMPTES.php";
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $SECURITES = new SECURITESCOMPTES();
        $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if($user_mdp) {
                        if($user_mdp['statut'] == 1) {
                            include "../../../Menu.php";
                            $securite= $SECURITES->trouver_securite_compte();
                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/securite';?>"><i class="bi bi-shield-check"></i> Sécurité</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Compte</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-shield-check"></i> Sécurité du compte</p>
                                <div class="row  justify-content-md-center">
                                    <div class="card-body">
                                    <table class="table table-bordered table-sm table-hover">

                                        <tr class="bg-danger text-white">
                                            <td></td>
                                            <td width="50">Statut</td>
                                            <td width="50"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre d'echec d'authentification avant vérouillage</strong></td>
                                            <td class="align_center"><?= $securite['securite_compte_nombre_essaie_authentification']  ?></td>

                                            <td>
                                                <button type="button" id="EDIT" data-bs-toggle="modal"  data-bs-target="#EditionModal" class="badge bg-warning btn_edit" ><i class="bi bi-brush"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Durée de vie du mot de passe</strong></td>
                                            <td class="align_center"><?= $securite['securite_compte_duree_de_vie_mot_de_passe']  ?></td>
                                            <td>
                                                <button type="button" id="EDIT" data-bs-toggle="modal"  data-bs-target="#editionDureevieModal" class="badge bg-warning btn_edit" ><i class="bi bi-brush"></i></button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Autoriser la double authentification </strong></td>
                                            <td class="align_center"><?php if($securite['securite_compte_autorisation_double_authentification'] == 0) {
                                                echo 'NON';}else{ echo 'OUI';} ?></td>
                                            <td>
                                                <button type="button" id="" data-bs-toggle="modal"  data-bs-target="#AutorisationDoubleModal" class="badge bg-warning btn_edit" ><i class="bi bi-brush"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Envoi d'SMS </strong></td>
                                            <td class="align_center"><?php if($securite['securite_compte_autorisation_sms'] == 0) {
                                                    echo 'NON';}else{ echo 'OUI';} ?></td>
                                            <td>
                                                <button type="button" id="" data-bs-toggle="modal"  data-bs-target="#AutorisationSmsModal" class="badge bg-<?php if($securite['securite_compte_autorisation_double_authentification'] == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit"  <?php if ($securite['securite_compte_autorisation_double_authentification'] == 1) {echo '';}else{echo  'disabled';} ?>><i class="bi bi-brush"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Envoi de mail</strong></td>
                                            <td class="align_center"><?php if($securite['securite_compte_autorisation_mail'] == 0) {
                                                    echo 'NON';}else{ echo 'OUI';} ?></td>
                                            <td>
                                                <button type="button" id="AUT" data-bs-toggle="modal"  data-bs-target="#AutorisationMailModal" class="badge bg-<?php if($securite['securite_compte_autorisation_double_authentification'] == 0) {echo 'secondary';}else {echo 'warning';}?> btn_edit " <?php if ($securite['securite_compte_autorisation_double_authentification'] == 1) {echo '';}else{echo  'disabled';} ?> ><i class="bi bi-brush"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                        <div class="modal fade" id="AutorisationDoubleModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="historiqueModalLabel">Autorisation </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_autorisation_double_authentification.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="EditionModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="historiqueModalLabel">Edition</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_nombre_essaie.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="AutorisationSmsModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="historiqueModalLabel"><Autorisation></Autorisation> </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_autorisation_sms.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="AutorisationMailModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="historiqueModalLabel">Autorisation </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_autorisation_mail.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="editionDureevieModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="historiqueModalLabel">Edition</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_compte_duree_de_vie_mdp.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                            echo '<script src="'.JS.'deconnexion_2.js"></script>';
                            echo '<script src="'.JS.'page_parametres_securite.js"></script>';

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
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}