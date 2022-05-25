<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'date_debut' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_debut'])))),
        'date_fin' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_fin'])))),
        'code_organisme' => clean_data($_POST['code_organisme']),
        'type_facture' => clean_data($_POST['type_facture'])
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
                            $nb_factures = count($_POST['num_factures']);
                            $nb_factures_enregistrees = 0;
                            if ($nb_factures != 0) {
                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                $nb_modules = count($modules);
                                if ($nb_modules !== 0) {
                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                    if (in_array('AFF_FCTS', $modules, true) && in_array('EDT_FCTS_BRDRS', $sous_modules, true)) {
                                        $edition = $ETABLISSEMENTS->ajouter_bordereau($ets['code'], $parametres['date_debut'], $parametres['date_fin'], $parametres['code_organisme'], $parametres['type_facture'], $user['id_user']);
                                        if ($edition['success'] == true) {

                                            for ($i = 0; $i < $nb_factures; $i++) {
                                                $facture = $ETABLISSEMENTS->ajouter_facture_bordereau($edition['num_bordereau'], $_POST['num_factures'][$i], $user['id_user']);
                                                if ($facture['success'] == true) {
                                                    $nb_factures_enregistrees++;
                                                }
                                            }
                                            if ($nb_factures_enregistrees == $nb_factures) {
                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ETS BORDEREAU', json_encode($parametres));
                                                if ($audit['success'] == true) {
                                                    $json = array(
                                                        'success' => true,
                                                        'num_bordereau' => $edition['num_bordereau'],
                                                        'message' => $edition['message']
                                                    );
                                                } else {
                                                    $json = $audit;
                                                }
                                            } else {
                                                $json = $acte;
                                            }
                                        } else {
                                            $json = $edition;
                                        }
                                    } else {
                                        $json = array(
                                            'success' => false,
                                            'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                        );
                                    }
                                } else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                    );
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Veuillez sélectionner au moins une facture.",
                                    'factures' => $_POST['num_factures']
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
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
