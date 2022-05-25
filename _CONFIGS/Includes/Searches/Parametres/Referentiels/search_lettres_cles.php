<?php

if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null,null);
            if($utilisateur) {
                require_once "../../../../Classes/ACTESMEDICAUX.php";
                $ACTESMEDICAUX = new ACTESMEDICAUX();
                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE LETTRES CLES', null);
                if ($audit['success'] == true) {
                    $lettres = $ACTESMEDICAUX->lister_lettres_cles();
                    foreach ($lettres as $lettre) {
                        $json[$lettre['code']] = $lettre['libelle'];
                    }
                }else {
                    $json = $audit;
                }
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