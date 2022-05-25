<?php
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code_organisme' => clean_data($_POST['code_organisme']),
        'type_facture' => clean_data($_POST['type_facture']),
        'date_debut' => clean_data(date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $_POST['date_fin']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
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
                                if (in_array('AFF_FCTS', $modules, true) && in_array('EDT_FCTS_BRDRS', $sous_modules, true)) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT FACTURES', json_encode($parametres));
                                    if ($audit['success'] === true) {
                                        if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                            $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                            $parametres['date_fin'] = date('Y-m-d', time());
                                        }
                                        $factures = $ETABLISSEMENTS->lister_nouveau_bordereau_factures($ets['code'], $parametres['code_organisme'], $parametres['type_facture'], $parametres['date_debut'], $parametres['date_fin']);
                                        foreach ($factures as $facture) {
                                            $json[] = array(
                                                'success' => true,
                                                'value' => $facture['num_facture'],
                                                'label' => $facture['num_bon']
                                            );
                                        }
                                    } else {
                                        $json = $audit;
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
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
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
    }
    flush();
}
echo json_encode($json);
