<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code_dossier' => clean_data($_POST['code_dossier'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/DOSSIERS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $DOSSIERS = new DOSSIERS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $factures = $DOSSIERS->lister_factures_initiales($parametres['code_dossier']);
                            foreach ($factures as $facture) {
                                $json_factures[] = array(
                                    'code_dossier' => $facture['code_dossier'],
                                    'type_facture' => $facture['code_type_facture'],
                                    'num_facture' => $facture['num_facture']
                                );
                            }
                            $nb_factures = count($factures);
                            if ($nb_factures != 0) {
                                $json = array(
                                    'success' => true,
                                    'factures' => $json_factures
                                );
                            } else {
                                $json = array(
                                    'success' => false,
                                    'factures' => null
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
