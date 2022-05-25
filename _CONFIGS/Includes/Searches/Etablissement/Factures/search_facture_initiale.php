<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'num_facture_initiale' => clean_data($_POST['num_facture_initiale'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/FACTURESMEDICALES.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $FACTURESMEDICALES = new FACTURESMEDICALES();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $facture = $FACTURESMEDICALES->trouver($parametres['num_facture_initiale']);
                            if ($facture) {
                                $json = array(
                                    'success' => true,
                                    'num_facture' => $facture['num_facture'],
                                    'code_organisme' => $facture['code_organisme'],
                                    'taux_organisme' => $facture['taux_organisme'],
                                    'num_assurance' => $facture['num_assurance']
                                );
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => 'N° facture incorrect.'
                                );
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur.."
                            );
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    } else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}
echo json_encode($json);
