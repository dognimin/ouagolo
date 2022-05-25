<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $nb_parametres = count($parametres);
            if($nb_parametres == 1) {
                require_once "../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($parametres['code_pays']);
                foreach ($regions as $region) {
                    $json[$region['code']] = $region['nom'];
                }
            }elseif($nb_parametres == 2) {
                require_once "../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($parametres['code_region']);
                foreach ($departements as $departement) {
                    $json[$departement['code']] = $departement['nom'];
                }
            }elseif($nb_parametres == 3) {
                require_once "../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($parametres['code_departement']);
                foreach ($communes as $commune) {
                    $json[$commune['code']] = $commune['nom'];
                }
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
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);