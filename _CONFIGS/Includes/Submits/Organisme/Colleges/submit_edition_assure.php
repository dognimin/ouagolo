<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_contrat' => clean_data($_POST['num_contrat']),
        'code_qualite_civile' => clean_data($_POST['code_qualite_civile']),
        'nip' => clean_data($_POST['nip']),
        'num_ip_payeur' => clean_data($_POST['num_ip_payeur']),
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
        'code_csp' => clean_data($_POST['code_csp']),
        'code_secteur_activite' => clean_data($_POST['code_secteur_activite']),
        'num_matricule' => clean_data($_POST['num_matricule']),
        'code_profession' => clean_data($_POST['code_profession']),
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
                        $edition = $POPULATIONS->editer('CIV', $parametres['nip'], $parametres['num_rgb'], $parametres['code_civilite'], strtoupper(conversion_caracteres_speciaux($parametres['nom'])), strtoupper(conversion_caracteres_speciaux($parametres['nom_patronymique'])), strtoupper(conversion_caracteres_speciaux($parametres['prenoms'])), $parametres['code_sexe'], $parametres['code_qualite_civile'], $parametres['date_naissance'], $parametres['code_nationnalite'], $parametres['situation_matrimoniale'], $parametres['code_csp'], $parametres['code_profession'], $parametres['code_pays_naissance'], str_replace('', null, $parametres['code_region_naissance']), $parametres['code_departement_naissance'], $parametres['code_commune_naissance'], strtoupper(conversion_caracteres_speciaux($parametres['lieu_naissance'])), $parametres['code_pays_residence'], $parametres['code_region_residence'], $parametres['code_departement_residence'], $parametres['code_commune_residence'], strtoupper(conversion_caracteres_speciaux($parametres['adresse_postale'])), strtoupper(conversion_caracteres_speciaux($parametres['adresse_geographique'])), $user['id_user']);
                        if ($edition['success'] === true) {
                            $assure = $ORGANISMES->trouver_assure($organisme['code'], $edition['num_population']);
                            if(!$assure) {
                                $edition_assure = $ORGANISMES->editer_assure($organisme['code'], $edition['num_population'], $user['id_user']);
                            } else {
                                $edition_assure = array(
                                    'success' => true
                                );
                            }
                            if($edition_assure['success'] == true) {
                                require_once "../../../../Classes/COLLEGES.php";
                                $CONTRATS = new COLLEGES();
                                $contrat = $CONTRATS->trouver($organisme['code'], $parametres['num_contrat']);
                                if($contrat) {
                                    if(strtotime($contrat['date_fin']) > strtotime(date('Y-m-d', time()))) {
                                        $assure_contrat = $CONTRATS->trouver_assure($organisme['code'], $contrat['code'], $edition['num_population']);
                                        if(!$assure_contrat) {
                                            if($parametres['code_qualite_civile'] == 'PAY') {
                                                $num_population_payeur = $edition['num_population'];
                                                $collectivite = $POPULATIONS->trouver_collectivite($edition['num_population']);
                                                if($collectivite) {
                                                    if($collectivite['code'] != $contrat['code_collectivite']) {
                                                        $edition_collectivite = $POPULATIONS->editer_collectivite($edition['num_population'], $contrat['code_collectivite'], $user['id_user']);
                                                    }
                                                } else {
                                                    $edition_collectivite = $POPULATIONS->editer_collectivite($edition['num_population'], $contrat['code_collectivite'], $user['id_user']);
                                                }
                                            }else {
                                                $num_population_payeur = $parametres['num_ip_payeur'];
                                            }
                                            if(strtotime($contrat['date_debut']) >= strtotime(date('Y-m-d', time()))) {$date_debut = $contrat['date_debut'];}else {$date_debut = date('Y-m-d', time());}

                                            $edition_contrat = $CONTRATS->ajouter_assure($contrat['code'], $parametres['code_qualite_civile'], $num_population_payeur, $edition['num_population'], $date_debut, $user['id_user']);
                                            if($edition_contrat['success'] == true) {
                                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION CONTRAT ORGANISME', json_encode($parametres));
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
                                                $json = $edition_contrat;
                                            }
                                        } else {
                                            $json = array(
                                                'success' => false,
                                                'message' => "Cet assuré a déjà été ajouté à ce contrat."
                                            );
                                        }
                                    } else {
                                        $json = array(
                                            'success' => false,
                                            'message' => "Ce contrat est arrivé à expiration. Aucun ajout ne peut se faire."
                                        );
                                    }

                                }else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Le numéro de contrat renseigné est incorrect. Veuillez contacter votre administrateur."
                                    );
                                }
                            } else {
                                $json = $edition_assure;
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