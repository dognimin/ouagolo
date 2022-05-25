<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_contrat' => clean_data($_POST['num_contrat']),
        'code_produit' => clean_data($_POST['code_produit'])
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
                        require_once "../../../../Classes/COLLEGES.php";
                        $CONTRATS = new COLLEGES();
                        $contrat = $CONTRATS->trouver($organisme['code'], $parametres['num_contrat']);
                        if($contrat) {
                            if(strtotime($contrat['date_fin']) > strtotime(date('Y-m-d', time()))) {
                                $produit = $CONTRATS->trouver_produit($parametres['num_contrat']);
                                if($produit) {
                                    if($produit['code_produit'] == $parametres['code_produit']) {
                                        $edition = array(
                                            'success' => false,
                                            'message' => "Ce produit est déjà appliqué à ce contrat."
                                        );
                                    } else {
                                        $edition = $CONTRATS->editer_produit($contrat['code'], $parametres['code_produit'], $user['id_user']);
                                    }

                                }else {
                                    $edition = $CONTRATS->editer_produit($contrat['code'], $parametres['code_produit'], $user['id_user']);
                                }

                                if ($edition['success'] == true) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION CONTRAT PRODUIT ORGANISME', json_encode($parametres));
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