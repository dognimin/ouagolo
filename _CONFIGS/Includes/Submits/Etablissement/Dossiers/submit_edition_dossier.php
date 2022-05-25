<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'nip' => clean_data($_POST['nip']),
        'num_dossier' => clean_data($_POST['num_dossier']),
        'code_assurance' => clean_data($_POST['code_assurance']),
        'num_assurance' => clean_data($_POST['num_assurance']),
        'num_bon' => str_replace('', null, clean_data($_POST['num_bon'])),
        'taux_assurance' => clean_data($_POST['taux_assurance']),
        'date_soins' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_soins'])))),
        'num_facture' => clean_data($_POST['num_facture']),
        'type_facture' => clean_data($_POST['type_facture']),
        'code_acte' => clean_data($_POST['code_acte']),
        'prix_unitaire' => clean_data($_POST['prix_unitaire']),
        'quantite' => clean_data($_POST['quantite'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/FACTURESMEDICALES.php";
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/DOSSIERS.php";
                $FACTURESMEDICALES = new FACTURESMEDICALES();
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $DOSSIERS = new DOSSIERS();
                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $edition = $DOSSIERS->editer($ets['code'], $parametres['nip'], $parametres['num_dossier'], $parametres['date_soins'], $user['id_user']);
                            if ($edition['success'] === true) {
                                $facture = $FACTURESMEDICALES->ajouter($parametres['date_soins'], $parametres['code_assurance'], $parametres['taux_assurance'], $edition['code'], $parametres['type_facture'], $parametres['num_facture'], null, $parametres['num_bon'], null, 'N', $user['id_user']);
                                if ($facture['success'] === true) {
                                    $acte = $FACTURESMEDICALES->ajouter_acte($facture['num_facture'], $parametres['code_acte'], $parametres['prix_unitaire'], $parametres['quantite'], 0, 0, $parametres['taux_assurance'], 0, $parametres['date_soins'], $user['id_user']);
                                    if ($acte['success'] === true) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION DOSSIER PATIENT', json_encode($parametres));
                                        if ($audit['success'] === true) {
                                            $json = array(
                                                'success' => true,
                                                'num_dossier' => $edition['code'],
                                                'num_facture' => $facture['num_facture'],
                                                'message' => $edition['message']
                                            );
                                        } else {
                                            $json = $audit;
                                        }
                                    } else {
                                        $json = $acte;
                                    }
                                } else {
                                    $json = $facture;
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
