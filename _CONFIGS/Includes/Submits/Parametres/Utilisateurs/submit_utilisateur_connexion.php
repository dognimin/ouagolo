<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $UTILISATEURS = new UTILISATEURS();
    $connexion = $UTILISATEURS->connexion($parametres['email'], $parametres['mot_de_passe']);
    if($connexion['success'] == true) {
        $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP,ACTIVE_URL,'CONNEXION',$parametres['email'],$connexion['id_user']);
        if($audit['success'] == true) {
            $_SESSION['nouvelle_session'] = $connexion['id_user'];
            $edition = $UTILISATEURS->editer_connexion($connexion['id_user'], CLIENT_ADRESSE_IP);
            if($edition['success'] == true) {
                $json = array(
                    'success' => true,
                    'message' => "Connexion établie."
                );
            }else {
                $json = $edition;
            }
        }
    }else{
        $json = $connexion;
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);