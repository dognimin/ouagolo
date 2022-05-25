<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'date_soins' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_soins'])))),
        'code_organisme' => clean_data($_POST['code_assurance']),
        'num_assure' => clean_data($_POST['nip'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                require_once "../../../../Classes/ORGANISMES.php";
                require_once "../../../../Classes/PATIENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                $ORGANISMES = new ORGANISMES();
                $PATIENTS = new PATIENTS();
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
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE PATIENT ORGANISMES', json_encode($parametres));
                                if ($audit['success'] === true) {
                                    $organisme = $PATIENTS->trouver_organisme($parametres['code_organisme'], $parametres['num_assure'], $parametres['date_soins']);
                                    if($organisme) {
                                        $json = array(
                                            'success' => true,
                                            'num_police' => $organisme['num_population'],
                                            'taux_couverture' => $organisme['taux_couverture']
                                        );
                                    }else {
                                        $json = array(
                                            'success' => false,
                                            'num_police' => null,
                                            'taux_couverture' => 0
                                        );
                                    }
                                }else {
                                    $json = $audit;
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Vous ne disposez d'aucune habilitation pour accéder à cette ressource, veuillez SVP contacter votre administrateur."
                                );
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
