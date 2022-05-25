<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'code_ets' => clean_data($_POST['code_ets']),
        'code_service' => clean_data($_POST['code_service'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $edition = $ETABLISSEMENTS->fermer_service($parametres['code_ets'], $parametres['code_service'], date('Y-m-d', strtotime('-1 DAY', time())), $utilisateur['id_user']);
                if ($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ETS SERVICE', json_encode($parametres));
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
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);
