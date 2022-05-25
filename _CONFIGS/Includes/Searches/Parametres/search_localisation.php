<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $nb_parametres = count($_POST);

    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                if($nb_parametres == 1) {
                    $parametres = array(
                        'code_pays' => clean_data($_POST['code_pays'])
                    );
                    require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($parametres['code_pays']);
                    foreach ($regions as $region) {
                        $json[$region['code']] = $region['nom'];
                    }
                }elseif($nb_parametres == 2) {
                    $parametres = array(
                        'code_pays' => clean_data($_POST['code_pays']),
                        'code_region' => clean_data($_POST['code_region'])
                    );
                    require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($parametres['code_region']);
                    foreach ($departements as $departement) {
                        $json[$departement['code']] = $departement['nom'];
                    }
                }elseif($nb_parametres == 3) {
                    $parametres = array(
                        'code_pays' => clean_data($_POST['code_pays']),
                        'code_region' => clean_data($_POST['code_region']),
                        'code_departement' => clean_data($_POST['code_departement'])
                    );
                    require_once "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                    $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($parametres['code_departement']);
                    foreach ($communes as $commune) {
                        $json[$commune['code']] = $commune['nom'];
                    }
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action.".json_encode($session)
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