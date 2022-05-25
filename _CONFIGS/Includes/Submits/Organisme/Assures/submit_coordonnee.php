<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'nip' => clean_data($_POST['num_assure']),
        'type' => clean_data($_POST['type']),
        'valeur' => clean_data($_POST['valeur'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ORGANISMES.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $POPULATIONS = new POPULATIONS();
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        $edition = $POPULATIONS->editer_coordonnee($parametres['nip'], $parametres['type'], $parametres['valeur'], $user['id_user']);
                        if ($edition['success'] === true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION COORDONNEE ASSURE', json_encode($parametres));
                            if ($audit['success'] === true) {
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