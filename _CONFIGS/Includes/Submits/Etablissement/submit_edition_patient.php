<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'nip' => clean_data($_POST['nip']),
        'num_secu' => clean_data($_POST['num_secu']),
        'code_civilite' => clean_data($_POST['code_civilite']),
        'nom' => clean_data($_POST['nom']),
        'nom_patronymique' => str_replace('', null, clean_data($_POST['nom_patronymique'])),
        'prenom' => clean_data($_POST['prenom']),
        'date_naissance' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_naissance'])))),
        'code_sexe' => clean_data($_POST['code_sexe']),
        'code_situation_matrimoniale' => clean_data($_POST['code_situation_matrimoniale']),
        'code_pays_residence' => clean_data($_POST['code_pays_residence']),
        'code_region_residence' => clean_data($_POST['code_region_residence']),
        'code_departement_residence' => clean_data($_POST['code_departement_residence']),
        'code_commune_residence' => clean_data($_POST['code_commune_residence']),
        'adresse_postale' => str_replace('', null, clean_data($_POST['adresse_postale'])),
        'adresse_georaphique' => str_replace('', null, clean_data($_POST['adresse_georaphique']))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if ($utilisateur) {
                require_once "../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $edition = $POPULATIONS->editer($ets['code_pays'], $parametres['nip'], $parametres['num_secu'], $parametres['code_civilite'], strtoupper(conversion_caracteres_speciaux($parametres['nom'])), strtoupper(conversion_caracteres_speciaux($parametres['nom_patronymique'])), strtoupper(conversion_caracteres_speciaux($parametres['prenom'])), $parametres['code_sexe'], null, $parametres['date_naissance'], null, $parametres['code_situation_matrimoniale'], null, null, null, null, null, null, null, $parametres['code_pays_residence'], $parametres['code_region_residence'], $parametres['code_departement_residence'], $parametres['code_commune_residence'], $parametres['adresse_postale'], $parametres['adresse_georaphique'], $utilisateur['id_user']);
                            if ($edition['success'] == true) {
                                if ($edition['num_population']) {
                                    $edition_patient = $ETABLISSEMENTS->editer_patient($ets['code'], $edition['num_population'], $utilisateur['id_user']);
                                }
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION PATIENT',json_encode($parametres));
                                if($audit['success'] == true) {
                                    $json = array(
                                        'success' => true,
                                        'nip' => $edition['num_population'],
                                        'message' => $edition['message']
                                    );
                                }else {
                                    $json = $audit;
                                }
                            }else {
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
