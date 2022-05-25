<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_pays' => clean_data($_POST['code_pays']),
        'code' => clean_data($_POST['code']),
        'nom' => clean_data($_POST['nom']),
        'latitude' => clean_data($_POST['latitude']),
        'longitude' => clean_data($_POST['longitude'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();

                $edition = $LOCALISATIONSGEOGRAPHIQUES->editer_region(strtoupper(conversion_caracteres_speciaux($parametres['code_pays'])),strtoupper(conversion_caracteres_speciaux($parametres['code'])),strtoupper(conversion_caracteres_speciaux($parametres['nom'])),strtoupper(conversion_caracteres_speciaux($parametres['latitude'])),strtoupper(conversion_caracteres_speciaux($parametres['longitude'])),$utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'EDITION TABLE DE VALEURS REGION',json_encode($parametres));
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