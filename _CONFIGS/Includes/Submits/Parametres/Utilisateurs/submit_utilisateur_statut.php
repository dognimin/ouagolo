<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            $concerne = $UTILISATEURS->trouver_statut($parametres['id_user']);
            if($concerne) {
                if($concerne['statut'] == 1) {
                    $statut = 0;
                }else {
                    $statut = 1;
                }
                $edition = $UTILISATEURS->editer_statut($concerne['id_user'], $statut, $utilisateur['id_user']);
                if($edition['success'] == true) {
                    $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'MISE A JOUR STATUT','********',$utilisateur['id_user']);
                    if($audit['success'] == true) {
                        $json = array(
                            'success' => true,
                            'message' => "Statut modifié avec succès"
                        );
                    }else {
                        $json = $audit;
                    }
                }else {
                    $json = $edition;
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
