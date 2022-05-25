<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'nip' => clean_data($_POST['nip']),
        'num_rgb' => clean_data($_POST['num_rgb']),
        'code_civilite' => clean_data($_POST['code_civilite']),
        'prenoms' => clean_data($_POST['prenoms']),
        'nom' => clean_data($_POST['nom']),
        'nom_patronymique' => clean_data($_POST['nom_patronymique']),
        'date_naissance' => date('Y-m-d',strtotime(str_replace('/', '-', clean_data($_POST['date_naissance'])))),
        'code_sexe' => clean_data($_POST['code_sexe']),
        'situation_matrimoniale' => clean_data($_POST['situation_matrimoniale']),
        'code_nationnalite' => clean_data($_POST['code_nationnalite']),
        'code_pays_naissance' => clean_data($_POST['code_pays_naissance']),
        'code_region_naissance' => clean_data($_POST['code_region_naissance']),
        'code_departement_naissance' => clean_data($_POST['code_departement_naissance']),
        'code_commune_naissance' => clean_data($_POST['code_commune_naissance']),
        'lieu_naissance' => clean_data($_POST['lieu_naissance']),
        'code_pays_residence' => clean_data($_POST['code_pays_residence']),
        'code_region_residence' => clean_data($_POST['code_region_residence']),
        'code_departement_residence' => clean_data($_POST['code_departement_residence']),
        'code_commune_residence' => clean_data($_POST['code_commune_residence']),
        'adresse_postale' => clean_data($_POST['adresse_postale']),
        'adresse_geographique' => clean_data($_POST['adresse_geographique']),
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        require_once "../../../../Classes/POPULATIONS.php";
                        $POPULATIONS = new POPULATIONS();
                        $edition = $POPULATIONS->editer('CIV', $parametres['nip'], $parametres['num_rgb'], $parametres['code_civilite'], strtoupper(conversion_caracteres_speciaux($parametres['nom'])), strtoupper(conversion_caracteres_speciaux($parametres['nom_patronymique'])), strtoupper(conversion_caracteres_speciaux($parametres['prenoms'])), $parametres['code_sexe'], null, $parametres['date_naissance'], $parametres['code_nationnalite'], $parametres['situation_matrimoniale'], null, null, $parametres['code_pays_naissance'], str_replace('', null, $parametres['code_region_naissance']), $parametres['code_departement_naissance'], $parametres['code_commune_naissance'], strtoupper(conversion_caracteres_speciaux($parametres['lieu_naissance'])), $parametres['code_pays_residence'], $parametres['code_region_residence'], $parametres['code_departement_residence'], $parametres['code_commune_residence'], strtoupper(conversion_caracteres_speciaux($parametres['adresse_postale'])), strtoupper(conversion_caracteres_speciaux($parametres['adresse_geographique'])), $user['id_user']);
                        if ($edition['success'] === true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ORGANISME ASSURE', json_encode($parametres));
                            if ($audit['success'] == true) {
                                $json = array(
                                    'success' => true,
                                    'num_population' => $edition['num_population'],
                                    'message' => $edition['message']
                                );
                            } else {
                                $json = $audit;
                            }
                        } else {
                            $json = $edition;
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur."
                        );
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur."
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
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);