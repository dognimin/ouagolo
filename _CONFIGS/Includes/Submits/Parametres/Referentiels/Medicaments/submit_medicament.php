<?php
if(isset($_POST)) {
    require_once "../../../../../Classes/UTILISATEURS.php";
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'code_dci' => clean_data($_POST['code_dci']),
        'code_type' => clean_data($_POST['code_type']),
        'code_ean13' => clean_data($_POST['code_ean13']),
        'code_laboratoire' => clean_data($_POST['code_laboratoire']),
        'code_conditionnement_primaire' => clean_data($_POST['code_conditionnement_primaire']),
        'code_conditionnement_secondaire' => clean_data($_POST['code_conditionnement_secondaire'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../../Classes/MEDICAMENTS.php";
                $FORMES = new MEDICAMENTS();
                $edition = $FORMES->editer($parametres['code_dci'], $parametres['code'], $parametres['code_ean13'], $parametres['code_conditionnement_primaire'], $parametres['code_conditionnement_secondaire'], $parametres['code_laboratoire'], $parametres['code_type'], strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), $utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION MEDICAMENT',json_encode($parametres));
                    if($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'message' => $edition['message']
                        );
                    }else {
                        $json = $audit;
                    }
                }else {
                    $json = $edition;
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