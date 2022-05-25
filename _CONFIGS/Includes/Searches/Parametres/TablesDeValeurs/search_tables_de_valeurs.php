<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'type' => clean_data($_POST['type'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                /**
                 * Tables de valeurs
                 */
                if($parametres['type'] == 'put') {

                }
                elseif($parametres['type'] == 'assur') {

                }
                elseif($parametres['type'] == 'allerg') {

                }
                elseif($parametres['type'] == 'csp') {

                }
                elseif($parametres['type'] == 'cps') {

                }
                elseif($parametres['type'] == 'ordre') {

                }
                elseif($parametres['type'] == 'etab_service') {

                }
                elseif($parametres['type'] == 'Typ_etab') {

                }
                elseif($parametres['type'] == 'civ') {

                }
                elseif($parametres['type'] == 'sex') {

                }
                elseif($parametres['type'] == 'ordre') {

                }
                elseif($parametres['type'] == 'typ_pers') {

                }
                elseif($parametres['type'] == 'tac') {

                }
                elseif($parametres['type'] == 'sif') {

                }
                elseif($parametres['type'] == 'sct') {

                }
                elseif($parametres['type'] == 'prf') {

                }
                elseif($parametres['type'] == 'qtc') {

                }
                elseif($parametres['type'] == 'tco') {
                    require "../../../../Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                    $types_coordonnees = $TYPESCOORDONNEES->lister();
                    foreach ($types_coordonnees as $type_coordonnee) {
                        $json[$type_coordonnee['code']] = $type_coordonnee['libelle'];
                    }
                }
                elseif($parametres['type'] == 'tpi') {

                }
                elseif($parametres['type'] == 'dev') {

                }
                elseif($parametres['type'] == 'gsa') {

                }
                elseif($parametres['type'] == 'rhs') {

                }
                elseif($parametres['type'] == 'lge') {

                }
                elseif($parametres['type'] == 'reg') {

                }
                elseif($parametres['type'] == 'dep') {

                }
                elseif($parametres['type'] == 'com') {

                }
                else{
                    $json = array(
                        'success' => false,
                        'message' => "Le type de données demandé est inconnu."
                    );
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