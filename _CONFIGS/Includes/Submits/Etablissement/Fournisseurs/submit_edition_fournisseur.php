<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'adresse_postale' => clean_data($_POST['adresse_postale']),
        'adresse_geo' => clean_data($_POST['adresse_geo']),
        'pays' => clean_data($_POST['pays']),
        'region' => clean_data($_POST['region']),
        'departement' => clean_data($_POST['departement']),
        'commune' => clean_data($_POST['commune']),
        'email' => clean_data($_POST['email']),
        'num_telephone_1' => clean_data($_POST['num_telephone_1']),
        'num_telephone_2' => clean_data($_POST['num_telephone_2'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/FOURNISSEURS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $FOURNISSEURS = new FOURNISSEURS();
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
                                if (in_array('AFF_FRNSS', $modules, true) && in_array('EDT_FRNS', $sous_modules, true)) {
                                    $edition = $FOURNISSEURS->editer($parametres['code'], strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), $parametres['pays'], $parametres['region'], $parametres['departement'], $parametres['commune'], $parametres['adresse_postale'], $parametres['adresse_geo'], $parametres['email'], $parametres['num_telephone_1'], $parametres['num_telephone_2'], $user['id_user']);
                                    if ($edition['success'] == true) {
                                        if ($edition['code']) {
                                            $edition_ets= $ETABLISSEMENTS->ajouter_fournisseur($ets['code'], $edition['code'], $user['id_user']);
                                        }
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION FOURNISSEUR', json_encode($parametres));
                                        if ($audit['success'] == true) {
                                            $json = array(
                                                'success' => true,
                                                'code' => $edition['code'],
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
