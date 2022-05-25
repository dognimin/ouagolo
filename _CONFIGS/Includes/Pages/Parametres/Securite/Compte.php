<?php
use App\GLOBALS;
use App\SECURITE;
use App\UTILISATEURS;
require_once "../../../../../vendor/autoload.php";
require_once "../../../../Functions/Functions.php";

$GLOBALS = new GLOBALS();
$Headers = $GLOBALS->headers(0);
$Links = $GLOBALS->links();
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $autorisation = verifier_utilisateur_acces('../../../../../', $parametres['url'], $_SESSION['nouvelle_session']);
        if($autorisation['success']) {
            $UTILISATEURS = new UTILISATEURS();
            $profil = $UTILISATEURS->trouver_profil($autorisation['id_user']);
            if ($profil) {
                if ($profil['code_profil'] == 'ADMN') {
                    if (isset($parametres['url'])) {
                        $audit = $UTILISATEURS->editer_piste_audit($autorisation['code_session'], $parametres['url'], 'AFFICHAGE', null);
                        if ($audit['success'] == true) {
                            include "../../../Menu.php";
                            $SECURITE = new SECURITE();
                            ?>
                            <div class="container-fluid" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= $Links['URL']; ?>"><i
                                                        class="bi bi-house-door-fill"></i>
                                                Accueil</a></li>
                                        <li class="breadcrumb-item"><a
                                                    href="<?= $Links['URL'] . 'parametres/'; ?>"><i
                                                        class="bi bi-gear-wide-connected"></i>
                                                Paramètres</a></li>
                                        <li class="breadcrumb-item"><a
                                                    href="<?= $Links['URL'] . 'parametres/securite'; ?>"><i
                                                        class="bi bi-shield-check"></i> Sécurité</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Compte
                                        </li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4"><i class="bi bi-shield-check"></i>
                                    Sécurité du compte</p>
                                <div class="row  justify-content-md-center">
                                    <div class="card-body">
                                        <?php
                                        $securite = $SECURITE->trouver_securite_compte();
                                        if ($securite) {
                                            $date_edition = date('Y-m-d', strtotime('+1 day', strtotime($securite['date_debut'])));
                                            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
                                            if (strtotime($date_fin) > strtotime($date_edition)) {
                                                $validite_edition = 1;
                                            } else {
                                                $validite_edition = 0;
                                            }
                                        } else {
                                            $validite_edition = 1;
                                            $securite = array(
                                                'nombre_essais' => null,
                                                'duree_mot_de_passe' => null,
                                                'double_authentification' => null,
                                                'autoriser_sms' => null,
                                                'autoriser_email' => null,
                                                'date_creation' => date('Y-m-d H:i:s', time()),
                                                'nom' => null,
                                                'prenoms' => null
                                            );
                                            echo '<p class="alert alert-danger align_center">Aucune information de sécurité de compte n\'a encore été enregistrée.</p>';
                                        }
                                        ?>
                                        <table class="table table-bordered table-sm table-hover">
                                            <tr class="bg-danger">
                                                <td>&nbsp;</td>
                                                <td style="width: 5px">
                                                    <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#EditionSecuriteModal"
                                                            class="badge bg-<?php if ($validite_edition == 0) {
                                                                echo 'secondary';
                                                            } else {
                                                                echo 'warning';
                                                            } ?>" <?php if ($validite_edition == 0) {
                                                        echo 'disabled';
                                                    } ?>><i class="bi bi-brush"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nombre d'echec d'authentification
                                                        avant
                                                        vérouillage</strong></td>
                                                <td class="align_center"><?= $securite['nombre_essais'] ?></td>
                                            </tr>

                                            <tr>
                                                <td><strong>Durée de vie du mot de
                                                        passe</strong>
                                                </td>
                                                <td class="align_center"><?= $securite['duree_mot_de_passe'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Activer l'authentification à double
                                                        facteur</strong></td>
                                                <td class="align_center"><?= str_replace('0', 'Non', str_replace('1', 'Oui', $securite['double_authentification'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Envoi d'SMS</strong></td>
                                                <td class="align_center"><?= str_replace('0', 'Non', str_replace('1', 'Oui', $securite['autoriser_sms'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Envoi d'Email</strong></td>
                                                <td class="align_center"><?= str_replace('0', 'Non', str_replace('1', 'Oui', $securite['autoriser_email'])); ?></td>
                                            </tr>
                                        </table>
                                        <p class="align_right">Dernière mise à jour le
                                            <strong><i><?= date('d/m/Y', strtotime($securite['date_creation'])); ?></i></strong>
                                            à
                                            <strong><i><?= date('H:i:s', strtotime($securite['date_creation'])); ?></i></strong>
                                            par
                                            <strong><i><?= $securite['prenoms'] . ' ' . $securite['nom']; ?></i></strong>
                                        </p>
                                        <div class="modal fade" id="EditionSecuriteModal"
                                             tabindex="-1"
                                             aria-labelledby="EditionSecuriteModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="EditionSecuriteModalLabel">
                                                            sécurité
                                                            du compte</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php include "../../_Forms/form_securite_compte.php"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo '<script src="' . $Links['JS'] . 'deconnexion_2.js"></script>';
                            echo '<script src="' . $Links['JS'] . 'page_parametres_securite.js"></script>';
                        } else {
                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                        }
                    } else {
                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                    }
                } else {
                    echo '<script>window.location.href="' . $Links['URL'] . '"</script>';
                }
            } else {
                echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
            }
        }else {
            if($autorisation['id_user']) {
                if($autorisation['password_reset']) {
                    echo '<script>window.location.href="' . $Links['URL'] . 'mot-de-passe"</script>';
                }else {
                    session_destroy();
                    echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
            }
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="' . $Links['URL'] . 'connexion"</script>';
}