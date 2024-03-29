<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'code_panier' => clean_data($_POST['code_panier']),
        'code_acte' => clean_data($_POST['code_acte']),
        'tarif_acte' => clean_data($_POST['tarif_acte']),
        'tarif_plafond' => clean_data($_POST['tarif_plafond']),
        'statut_ep' => clean_data($_POST['statut_ep']),
        'date_debut' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_debut']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        require_once "../../../../../Classes/PANIERSDESOINS.php";
                        $PANIERSDESOINS = new PANIERSDESOINS();
                        $edition = $PANIERSDESOINS->editer_panier_acte_medical($parametres['code_panier'], $parametres['code_acte'], $parametres['tarif_acte'], $parametres['tarif_plafond'], $parametres['statut_ep'], $parametres['date_debut'], $user['id_user']);
                        if ($edition['success'] == true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ORGANISME PANIER DE SOINS ACTES', json_encode($parametres));
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