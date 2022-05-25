<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_dossier' => clean_data($_POST['num_dossier']),
        'code_assurance' => clean_data($_POST['code_assurance']),
        'num_assurance' => clean_data($_POST['num_assurance']),
        'num_bon' => str_replace('', null, clean_data($_POST['num_bon'])),
        'taux_assurance' => clean_data($_POST['taux_assurance']),
        'date_soins' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_soins'])))),
        'num_facture' => clean_data($_POST['num_facture']),
        'type_facture' => clean_data($_POST['type_facture']),
        'num_facture_initiale' => clean_data($_POST['num_facture_initiale'])
    );
    if (isset($_POST['code_acte'])) {
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
                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                $nb_modules = count($modules);
                                if ($nb_modules !== 0) {
                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                    if (in_array('AFF_FCTS', $modules, true) && in_array('EDT_FCT', $sous_modules, true)) {
                                        $nb_actes = count($_POST['code_acte']);
                                        $nb_actes_enregistres = 0;
                                        if ($nb_actes != 0) {
                                            $edition = $FACTURESMEDICALES->ajouter($parametres['date_soins'], $parametres['code_assurance'], $parametres['taux_assurance'], $parametres['num_dossier'], $parametres['type_facture'], $parametres['num_facture'], $parametres['num_facture_initiale'], $parametres['num_bon'], null, 'N', $user['id_user']);
                                            if ($edition['success'] == true) {
                                                for ($i = 0; $i < $nb_actes; $i++) {
                                                    $acte = $FACTURESMEDICALES->ajouter_acte($edition['num_facture'], $_POST['code_acte'][$i], $_POST['prix_unitaire'][$i], $_POST['quantite'][$i], 0, 0, $parametres['taux_assurance'], 0, $parametres['date_soins'], $user['id_user']);
                                                    if ($acte['success'] == true) {
                                                        $nb_actes_enregistres++;
                                                    }
                                                }
                                                if ($nb_actes_enregistres == $nb_actes) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION FACTURE PATIENT', json_encode($parametres));
                                                    if ($audit['success'] == true) {
                                                        $json = array(
                                                            'success' => true,
                                                            'num_dossier' => $parametres['num_dossier'],
                                                            'num_facture' => $edition['num_facture'],
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
                                                'message' => "Veuillez renseigner au moins un acte."
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
                                        'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
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
            'message' => "Veuillez renseigner au moins un acte."
        );
    }

} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
