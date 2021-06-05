<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            require_once "../../../../Functions/Functions.php";
            require_once "../../../../Classes/SECURITESMDP.php";
            $SECURITESMDP = new SECURITESMDP();
            $edition = $SECURITESMDP->editer_caracteres_speciaux(conversion_caracteres_speciaux($parametres['donnee']));
            if($edition['success'] == true) {
                $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'EDITION',json_encode($parametres),$utilisateur['id_user']);
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
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);