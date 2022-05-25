<?php
header('Content-Type: application/json');
if (isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'code_rgb' => clean_data($_POST['code_rgb']),
        'libelle' => clean_data($_POST['libelle']),
        'adresse_postale' => clean_data($_POST['adresse_postale']),
        'adresse_geo' => clean_data($_POST['adresse_geo']),
        'pays' => clean_data($_POST['pays']),
        'region' => clean_data($_POST['region']),
        'departement' => clean_data($_POST['departement']),
        'commune' => clean_data($_POST['commune']),
        'longitude' => clean_data($_POST['longitude']),
        'latitude' => clean_data($_POST['latitude'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $edition = $ORGANISMES->editer(strtoupper(conversion_caracteres_speciaux($parametres['code'])), strtoupper(conversion_caracteres_speciaux($parametres['code_rgb'])), strtoupper(conversion_caracteres_speciaux($parametres['libelle'])), strtoupper(conversion_caracteres_speciaux($parametres['adresse_postale'])),strtoupper(conversion_caracteres_speciaux($parametres['adresse_geo'])),strtoupper(conversion_caracteres_speciaux($parametres['pays'])),strtoupper(conversion_caracteres_speciaux($parametres['region'])),strtoupper(conversion_caracteres_speciaux($parametres['departement'])),strtoupper(conversion_caracteres_speciaux($parametres['commune'])),strtoupper(conversion_caracteres_speciaux($parametres['latitude'])),strtoupper(conversion_caracteres_speciaux($parametres['longitude'])), null, null, $utilisateur['id_user']);
                if ($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'EDITION ORGANISME', json_encode($parametres));
                    if ($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'code' => $edition['code_organisme'],
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