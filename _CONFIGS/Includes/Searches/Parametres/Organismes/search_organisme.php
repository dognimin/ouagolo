<?php
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $ets = $ORGANISMES->trouver($parametres['code']);
                if (!$ets) {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun résultat correspondant à votre recherche n'a été trouvé."
                    );
                } else {
                    $json = array(
                        'success' => true,
                        'code' => $ets['code'],
                        'libelle' => $ets['libelle']
                    );
                }
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
