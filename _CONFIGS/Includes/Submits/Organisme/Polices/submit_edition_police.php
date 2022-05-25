<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_collectivite' => clean_data($_POST['code_collectivite']),
        'id_police' => clean_data($_POST['id_police']),
        'libelle' => clean_data($_POST['libelle']),
        'description' => clean_data($_POST['description']),
        'date_debut' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_debut'])))),
        'date_fin' => date('Y-m-d', strtotime(str_replace('/', '-', clean_data($_POST['date_fin']))))
    );

    if($_POST['date_fin']) {$date_fin = $parametres['date_fin'];}else {$date_fin = null;}

    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session){
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user){
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme){
                        require_once "../../../../Classes/POLICES.php";
                        $POLICES = new POLICES();
                        $edition = $POLICES->editer($organisme['code'], $parametres['code_collectivite'], $parametres['id_police'], $parametres['libelle'], $parametres['description'], $parametres['date_debut'], $date_fin, $user['id_user']);
                        if ($edition['success'] == true) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ORGANISME POLICE', json_encode($parametres));
                            if ($audit['success'] == true) {
                                $json = array(
                                    'success' => true,
                                    'id_police' => $edition['id_police'],
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
    }else{
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