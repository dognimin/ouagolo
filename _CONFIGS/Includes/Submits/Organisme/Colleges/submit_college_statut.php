<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_police' => clean_data($_POST['id_police']),
        'code_college' => clean_data($_POST['code_college']),
        'code_statut' => clean_data($_POST['code_statut']),
        'motif' => clean_data($_POST['motif'])
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
                        require_once "../../../../Classes/POLICES.php";
                        $POLICES = new POLICES();
                        $police = $POLICES->trouver($organisme['code'], $parametres['id_police']);
                        if($police) {
                            require_once "../../../../Classes/COLLEGES.php";
                            $COLLEGES = new COLLEGES();
                            $college = $COLLEGES->trouver($police['id_police'], $parametres['code_college']);
                            if($college) {
                                if(!$college['date_fin'] || isset($college['date_fin']) && strtotime($college['date_fin']) > strtotime(date('Y-m-d', time()))) {
                                    $edition = $COLLEGES->editer_statut($college['code'], strtoupper($parametres['code_statut']), strtoupper(conversion_caracteres_speciaux($parametres['motif'])), date('Y-m-d', time()), $user['id_user']);

                                    if ($edition['success'] == true) {
                                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ORGANISME CONTRAT STATUT', json_encode($parametres));
                                        if ($audit['success'] == true) {
                                            $json = array(
                                                'success' => true,
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
                                        'message' => "Ce contrat n'est plus actif."
                                    );
                                }

                            }else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Aucun contrat correspondant à ce numéro n'a été trouvé, veuillez SVP contacter votre administrateur."
                                );
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Identifiant de la police envoyé est inconnu."
                            );
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