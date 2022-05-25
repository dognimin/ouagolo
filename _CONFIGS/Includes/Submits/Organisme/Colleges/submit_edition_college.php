<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'num_police' => clean_data($_POST['num_police']),
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'description' => clean_data($_POST['description'])
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
                        $police = $POLICES->trouver($organisme['code'], $parametres['num_police']);
                        if($police) {
                            require_once "../../../../Classes/COLLEGES.php";
                            $COLLEGES = new COLLEGES();
                            $edition = $COLLEGES->editer($organisme['code'], $police['code_collectivite'], $parametres['num_police'], $parametres['code'], strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), strtoupper(conversion_caracteres_speciaux($parametres['description'])), date('Y-m-d', time()), null, $user['id_user']);
                            if ($edition['success'] == true) {
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION COLLEGE ORGANISME', json_encode($parametres));
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
                        }else {

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