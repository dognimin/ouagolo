<?php
require_once '../../../../Classes/UTILISATEURS.php';
$UTILISATEURS = new UTILISATEURS();
$session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
if($session) {
    $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
    if($utilisateur) {
        $edition = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
        if($edition['success'] == true) {
            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'],ACTIVE_URL,'DECONNEXION',null);
            if($audit['success'] == true) {
                session_unset();
                session_destroy();
                $json = array(
                    'success' => true
                );
            }else {
                $json = array(
                    'success' => false
                );
            }
        }else {
            $json = array(
                'success' => false
            );
        }
    }else {
        $json = array(
            'success' => false
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucune session active pour vérifier cette action."
    );
}
echo json_encode($json);


