<?php

header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'description' => clean_data($_POST['description'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/BAREMES.php";
                $BAREMES = new App\BAREMES();
                $edition = $BAREMES->editer(strtoupper(conversion_caracteres_speciaux($parametres['code'])),  strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), strtoupper(conversion_caracteres_speciaux($parametres['description'])), $utilisateur['id_user']);
                if ($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION GABARIT DE BAREME', json_encode($parametres));
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