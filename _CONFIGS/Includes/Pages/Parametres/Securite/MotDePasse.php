<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Classes/SECURITE.php";

if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $SECURITE = new SECURITE();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
        if ($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if ($user_statut) {
                if ($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if ($user_mdp) {
                        if ($user_mdp['statut'] == 1) {
                            include "../../../Menu.php";
                            $securite = $SECURITE->trouver_securite_mdp();

                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL . 'parametres/securite'; ?>"><i class="bi bi-shield-check"></i> Sécurité</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Mot de passe</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"> Sécurité du mot de passe</p>
                                <div class="row  justify-content-md-center">
                                    <div class="card-body">
                                        <table class="table table-bordered table-sm table-hover">
                                            <tr class="bg-danger">
                                                <td>&nbsp;</td>
                                                <td style="width: 5px"><button type="button" data-bs-toggle="modal" data-bs-target="#EditionSecuriteMdpModal" class="badge bg-warning"><i class="bi bi-brush"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Longueur minimale du mot de passe</strong></td>
                                                <td class="align_center"><?= $securite['longueur_minimale'] ?></td>
                                            </tr>

                                            <tr>
                                                <td><strong>Exiger les caractères spéciaux</strong></td>
                                                <td class="align_center"><?= str_replace('0','Non',str_replace('1','Oui',$securite['caracteres_speciaux']));?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Exiger les majuscules</strong></td>
                                                <td class="align_center"><?= str_replace('0','Non',str_replace('1','Oui',$securite['majuscules']));?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Exiger les miniscules</strong></td>
                                                <td class="align_center"><?= str_replace('0','Non',str_replace('1','Oui',$securite['minuscules']));?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Exiger les chiffres</strong></td>
                                                <td class="align_center"><?= str_replace('0','Non',str_replace('1','Oui',$securite['chiffres']));?></td>
                                            </tr>
                                        </table>
                                        <div class="modal fade" id="EditionSecuriteMdpModal" tabindex="-1" aria-labelledby="EditionSecuriteMdpModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="EditionSecuriteMdpModalLabel">sécurité du mot de passe</h5>
                                                    </div>
                                                    <div class="modal-body" id="div_historique">
                                                        <?php include "../../_Forms/form_securite_mdp.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                            echo '<script src="' . JS . 'page_parametres_securite.js"></script>';
                        } else {
                            echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
                        }
                    } else {
                        session_destroy();
                        echo '<script>window.location.href="' . URL . 'connexion"</script>';
                    }
                } else {
                    session_destroy();
                    echo '<script>window.location.href="' . URL . 'connexion"</script>';
                }
            } else {
                session_destroy();
                echo '<script>window.location.href="' . URL . 'connexion"</script>';
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . URL . 'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="' . URL . 'connexion"</script>';
}
?>
<script>

</script>
