<?php
if (isset($_POST)) {
    require_once "../../Classes/UTILISATEURS.php";
    require_once "../../Functions/Functions.php";
    $parametres = array(
        'date' => clean_data(date('l, d F Y', strtotime($_POST['date'])))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $date = traduction_date($parametres['date']);
                $json = array(
                    'success' => true,
                    'date' => $date
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
}
echo json_encode($json);