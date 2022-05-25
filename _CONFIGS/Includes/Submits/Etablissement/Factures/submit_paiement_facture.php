<?php
header('Content-Type: application/json');
if (isset($_POST)){
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_facture' => clean_data($_POST['num_facture']),
        'montant_brut' => clean_data($_POST['montant_brut']),
        'remise' => clean_data($_POST['remise']),
        'montant_net' => clean_data($_POST['montant_net']),
        'mode_paiement' => clean_data($_POST['mode_paiement']),
        'montant_recu' => clean_data($_POST['montant_recu']),
        'monnaie' => clean_data($_POST['monnaie'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $edition = $ETABLISSEMENTS->edition_paiement_facture($ets['code'], $parametres['num_facture'], $parametres['montant_brut'], $parametres['remise'], $parametres['montant_net'], $parametres['mode_paiement'], $parametres['montant_recu'], $parametres['monnaie'], $utilisateur['id_user']);
                            if ($edition['success'] == true) {
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION APIEMENT FACTURE', json_encode($parametres));
                                if ($audit['success'] == true) {
                                    $json = array(
                                        'success' => true,
                                        'num_paiement' => $edition['num_paiement'],
                                        'message' => $edition['message']
                                    );
                                } else {
                                    $json = $audit;
                                }
                            } else {
                                $json = $edition;
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
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
