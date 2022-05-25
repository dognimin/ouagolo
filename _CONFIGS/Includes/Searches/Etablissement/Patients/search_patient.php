<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_organisme' => clean_data($_POST['code_organisme']),
        'num_assure' => clean_data($_POST['num_assure']),
        'num_secu' => clean_data($_POST['num_secu'])
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
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                $ORGANISMES = new ORGANISMES();
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
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE PATIENT', json_encode($parametres));
                                if ($audit['success'] === true) {
                                    if ($parametres['num_assure']) {
                                        $organisme = $ORGANISMES->trouver($parametres['code_organisme']);
                                        if($organisme) {
                                            $assure = $ORGANISMES->trouver_assure($organisme['code'], $parametres['num_assure']);
                                            if ($assure) {
                                                if(!$assure['date_deces']) {
                                                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($assure['code_pays_residence']);
                                                    foreach ($regions as $region) {
                                                        $liste_regions[$region['code']] = $region['nom'];
                                                    }

                                                    $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($assure['code_region_residence']);
                                                    foreach ($departements as $departement) {
                                                        $liste_departements[$departement['code']] = $departement['nom'];
                                                    }
                                                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($assure['code_departement_residence']);
                                                    foreach ($communes as $commune) {
                                                        $liste_communes[$commune['code']] = $commune['nom'];
                                                    }
                                                    $json = array(
                                                        'success' => true,
                                                        'nip' => $assure['num_population'],
                                                        'num_secu' => $assure['num_rgb'],
                                                        'code_civilite' => $assure['code_civilite'],
                                                        'nom' => $assure['nom'],
                                                        'nom_patronymique' => $assure['nom_patronymique'],
                                                        'prenoms' => $assure['prenom'],
                                                        'code_sexe' => $assure['code_sexe'],
                                                        'date_naissance' => date('d/m/Y', strtotime($assure['date_naissance'])),
                                                        'code_situation_familiale' => $assure['code_situation_familiale'],
                                                        'code_pays_residence' => $assure['code_pays_residence'],
                                                        'code_region_residence' => $assure['code_region_residence'],
                                                        'liste_regions' => $liste_regions,
                                                        'code_departement_residence' => $assure['code_departement_residence'],
                                                        'liste_departements' => $liste_departements,
                                                        'code_commune_residence' => $assure['code_commune_residence'],
                                                        'liste_communes' => $liste_communes,
                                                        'adresse_postale' => $assure['adresse_postale'],
                                                        'adresse_geographique' => $assure['adresse_geographique']

                                                    );
                                                } else {
                                                    $json = array(
                                                        'success' => false,
                                                        'message' => "Cet assuré ne peut être créé car il est décédé."
                                                    );
                                                }
                                            } else {
                                                $json = array(
                                                    'success' => false,
                                                    'message' => "Numéro d'Identifiant assuré incorrect."
                                                );
                                            }
                                        } else {
                                            $json = array(
                                                'success' => false,
                                                'message' => "L'organisme sélectionné est incorrect."
                                            );
                                        }
                                    } elseif ($parametres['num_secu']) {
                                        $patient = $POPULATIONS->trouver(null, $parametres['num_secu']);
                                        if ($patient) {
                                            if(!$patient['date_deces']) {
                                                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($patient['code_pays_residence']);
                                                foreach ($regions as $region) {
                                                    $liste_regions[$region['code']] = $region['nom'];
                                                }

                                                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($patient['code_region_residence']);
                                                foreach ($departements as $departement) {
                                                    $liste_departements[$departement['code']] = $departement['nom'];
                                                }
                                                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($patient['code_departement_residence']);
                                                foreach ($communes as $commune) {
                                                    $liste_communes[$commune['code']] = $commune['nom'];
                                                }

                                                $json = array(
                                                    'success' => true,
                                                    'nip' => $patient['num_population'],
                                                    'num_secu' => $patient['num_secu'],
                                                    'code_civilite' => $patient['code_civilite'],
                                                    'nom' => $patient['nom'],
                                                    'nom_patronymique' => $patient['nom_patronymique'],
                                                    'prenoms' => $patient['prenoms'],
                                                    'code_sexe' => $patient['code_sexe'],
                                                    'date_naissance' => date('d/m/Y', strtotime($patient['date_naissance'])),
                                                    'code_situation_familiale' => $patient['code_situation_familiale'],
                                                    'code_pays_residence' => $patient['code_pays_residence'],
                                                    'code_region_residence' => $patient['code_region_residence'],
                                                    'liste_regions' => $liste_regions,
                                                    'code_departement_residence' => $patient['code_departement_residence'],
                                                    'liste_departements' => $liste_departements,
                                                    'code_commune_residence' => $patient['code_commune_residence'],
                                                    'liste_communes' => $liste_communes,
                                                    'adresse_postale' => $patient['adresse_postale'],
                                                    'adresse_geographique' => $patient['adresse_geographique']

                                                );
                                            } else {
                                                $json = array(
                                                    'success' => false,
                                                    'message' => "Ce patient ne peut être créé car il est décédé."
                                                );
                                            }
                                        } else {
                                            $json = array(
                                                'success' => false,
                                                'message' => "Numéro sécu patient incorrect."
                                            );
                                        }
                                    } else {
                                        $json = null;
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
